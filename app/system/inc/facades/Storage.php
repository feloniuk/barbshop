<?php
class Storage
{
    /**
     * default dir where store all files
     * @var string
     */
    private static string $defaultDir = 'data';

    /**
     * dir for temporary files
     * @var string
     */
    private static string $tmpDir = 'tmp';

    /**
     * dir for last uploaded images
     * @var string
     */
    private static string $luDir = 'last_uploaded_images';

    /**
     * max files in dir
     * @var int
     */
    private static int $maxDirFiles = 10000;

    private static array $fileUploadErrors = [
        1 => 'The uploaded file exceeds the upload_max_filesize directive in php.ini',
        2 => 'The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form',
        3 => 'The uploaded file was only partially uploaded',
        4 => 'No file was uploaded',
        6 => 'Missing a temporary folder',
        7 => 'Failed to write file to disk.',
        8 => 'A PHP extension stopped the file upload.'
    ];

    /**
     * shard dir for specific entity
     * @param string $entity
     * @param int $id
     * @return string
     */
    public static function shardDir(string $entity, int $id): string
    {
        $folder = intdiv($id, self::$maxDirFiles) + 1;

        return self::$defaultDir . "/$entity/$folder/$id/";
    }

    /**
     * replace not allowed symbols in file name
     * @param string $filename
     * @return string
     */
    public static function filterFileName(string $filename): string
    {
        return preg_replace('/[\/:()\*\?"<>| ]+/', '_', $filename);
    }

    /**
     * get file for specific entity
     * @param string $file
     * @param string $entity
     * @param int $id
     * @return string
     */
    public static function get(string $file, string $entity, int $id): string
    {
        return _SITEDIR_ . self::shardDir($entity, $id) . $file;
    }

    /**
     * @throws Exception
     */
    public static function entityImage($entity, $id, $newImage, $oldImage, $miniWidth = 0, $miniHeight = 0, $webp = false)
    {
        //filter file name (need when move from tmp)
        $newImage = Storage::filterFileName($newImage);

        //name dir for files in storage
        $entityDir = Storage::shardDir($entity, $id);
        $newFilePath = $entityDir . $newImage;
        $newMiniFilePath = _SYSDIR_ . $entityDir . 'mini_' . $newImage;

        //remove old images
        $fileName = pathinfo($oldImage, PATHINFO_FILENAME);
        Storage::remove($entityDir . $oldImage);

        //check if this image from last if yes - copy from `last uploaded images` directory
        if (file_exists(_SYSDIR_ . Storage::tmpPath() . $newImage)) {
            //move uploaded file from tmp to entity dir
            try {
                Storage::moveFromTmp($newImage, $newFilePath);
            } catch (Exception $e) {
                Request::returnError($e->getMessage());
            }
        } else {
            Storage::copy(Storage::luPath() . $newImage, $newFilePath);
        }

        $image = new Image(_SYSDIR_ . $newFilePath);

        //webp format for picture html tag
        if ($webp) {
            //remove old webp image
            Storage::remove($entityDir . $fileName . '.webp');

            //convert new image to webp
            $image->convertTo('webp');
        }

        //thumbnail
        if ($miniWidth || $miniHeight) {
            //remove old mini images
            Storage::remove($entityDir . '/mini_' . $oldImage);
            Storage::remove($entityDir . '/mini_' . $fileName . '.webp');

            //create mini
            $image->resize($miniWidth, $miniHeight, $newMiniFilePath);

            //mini convert to webp
            if ($webp) {
                $imageMini = new Image($newMiniFilePath);
                $imageMini->convertTo('webp');
            }
        }
    }

    /**
     * move file from tmp folder
     * @param string $file
     * @param string $to
     * @return void
     * @throws Exception
     */
    public static function moveFromTmp(string $file, string $to)
    {
        $file = self::filterFileName($file);

        if (!self::move(self::tmpPath() . $file, $to)) {
            throw new Exception('Storage move file Error');
        }
        //todo add chmod 0644
    }

    /**
     * Move file from directory to another one
     * @param $filePath
     * @param $copyPath
     * @return bool
     */
    static public function move($filePath, $copyPath)
    {
        if (self::copy($filePath, $copyPath)) {
            return self::remove($filePath);
        }

        return false;
    }

    /**
     * Copy file
     * @param $filePath
     * @param $copyPath
     * @return bool
     */
    static public function copy($filePath, $copyPath)
    {
        $copyPath = trim($copyPath, '/');
        $array = explode('/', $copyPath);
        array_pop($array); // remove file name

        self::mkdir(implode('/', $array), 0755);
        return copy(_SYSDIR_ . $filePath, _SYSDIR_ . $copyPath);
    }

    /**
     * @param $path
     * @return bool
     */
    static public function remove($path)
    {
        return @unlink(_SYSDIR_ . $path);
    }

    /**
     * function mkdir recursive
     * @param $path
     * @param int $chmod
     * @return string
     */
    static public function mkdir($path, $chmod = 0777)
    {
        $path = trim($path, '/');
        $array = explode('/', $path);

        $fullPath = _SYSDIR_;
        foreach ($array as $value) {
            $fullPath .= $value . '/';

            if (!is_dir($fullPath)) {
                @mkdir($fullPath, $chmod);
            }

            @chmod($fullPath, $chmod);
        }

        return $fullPath;
    }

    /**
     * @param array $file
     * @param $type (image, file)
     * @return array
     * @throws Exception
     */
    public static function upload(array $file, $type = 'image'): array
    {
        //check file errors
        if ($code = $file['error']) {
            throw new Exception(self::$fileUploadErrors[$code]);
        }

        $fileName    = $file['name'];
        $extension   = format($fileName);
        $size        = $file['size'];
        $tmpName     = $file['tmp_name'];

        $newName = randomHash() . '.' . $extension;

        if (!isset($file['tmp_name'])
            || !is_uploaded_file($file['tmp_name'])
            || $file['error']) {
            throw new Exception("File upload error");
        }

        //call check function for image or file (check extension, size)
        $funcName = "check$type";
        self::$funcName($extension, $size);

        //uploaded file to tmp storage
        $newPath = self::tmpPath() . $newName;
        self::moveUploaded($tmpName, $newPath);

        //check valid image resolution and resize if needed
        if ($type == 'image') {
            $image = new Image(_SYSDIR_ . $newPath);
            $image->changeResolution();
        }

        return ['new_name' => $newName, 'name' => $fileName];
    }

    /**
     * @param string $extension
     * @param int $size
     * @return void
     * @throws Exception
     */
    private static function checkImage(string $extension, int $size)
    {
        Image::checkExtension($extension);

        Image::checkSize($size);
    }

    /**
     * @param string $extension
     * @param int $size
     * @return void
     * @throws Exception
     */
    private static function checkFile(string $extension, int $size)
    {
        File::checkExtension($extension);

        File::checkSize($size);
    }

    /**
     * @param string $extension
     * @param int $size
     * @return void
     * @throws Exception
     */
    private static function checkDoc(string $extension, int $size)
    {
        Doc::checkExtension($extension);

        Doc::checkSize($size);
    }

    /**
     * @param string $extension
     * @param int $size
     * @return void
     * @throws Exception
     */
    private static function checkVideo(string $extension, int $size)
    {
        Video::checkExtension($extension);

        Video::checkSize($size);
    }

    /**
     * move file from path to new path
     * @param string $from
     * @param string $to
     * @return bool
     * @throws Exception
     */
    private static function moveUploaded(string $from, string $to): bool
    {
        self::mkdir(self::tmpPath());

        //when use 'move_uploaded_file' - get error
        if (!copy($from, _SYSDIR_ . $to)) {
            throw new Exception("File upload error");
        }

        return true;
    }

    /**
     * @return string
     */
    public static function tmpPath(): string
    {
        return self::$defaultDir . '/' . self::$tmpDir . '/';
    }

    /**
     * last uploaded images path
     * @return string
     */
    public static function luPath(): string
    {
        return self::$defaultDir . '/' . self::$luDir . '/';
    }
}