<?php

class Image extends FileBase
{
    /**
     * allowed formats for image
     * @var array|true[]
     */
    public static array $allowedFormats = [
        'gif'   => true,
        'png'   => true,
        'jpg'   => true,
        'jpeg'  => true,
        'svg'   => true,
        'webp'  => true,
    ];

    /**
     * max image size to uploading (bytes)
     * @var int
     */
    public static int $allowedFileSize = 2048576; //2M

    /**
     * max allowed image width
     * @var float|int
     */
    public static float $maxWidth = 2880;

    /**
     * max allowed image height
     * @var float|int
     */
    public static float $maxHeight = 1800;

    /**
     * @var string
     */
    private string $fileName;

    /**
     * @var float
     */
    private float $width;

    /**
     * @var float
     */
    private float $height;

    /**
     * image extension
     * @var string
     */
    private string $extension;

    /**
     * @param string $path
     * @throws Exception
     */
    public function __construct(string $path)
    {
        $this->setPath($path);
        $this->setImageSize();
    }

    /**
     * resize image
     * @param float $newWidth
     * @param float $newHeight
     * @param string $newPath
     * @return bool
     */
    public function resize(float $newWidth = 0, float $newHeight = 0, string $newPath = ''): bool
    {
        if (!$newPath) {
            $newPath = $this->getPath();
        }

        //get current width and height of image
        $width = $this->getWidth();
        $height = $this->getHeight();

        //calculate of new height/width if one of the values is not passed
        if ($newWidth !== 0 && $newHeight === 0) {
            $hw = round($width / $height, 6);
            $newWidth = round($hw * $newHeight);
        } else if ($newHeight == 0 && $newWidth !== 0) {
            $hw = round($height / $width, 6);
            $newHeight = round($hw * $newWidth);
        }

        //calculate ratio
        $ratio = max($newWidth / $width, $newHeight / $height);
        $height = $newHeight / $ratio;
        $x = ($width - $newWidth / $ratio) / 2; // align by center
        $width = $newWidth / $ratio;

        //create image
        $screen = imagecreatetruecolor($newWidth, $newHeight);

        //transparency for PNG
        if ($this->getExtension() === 'png') {
            $this->transparency($screen);
        }

        //copy image
        $imageCreateFrom = $this->getCreateFromFunc();
        $img = $imageCreateFrom($this->getPath());
        imagecopyresampled($screen, $img, 0, 0, $x, 0, $newWidth, $newHeight, $width, $height);

        $imagePrint = $this->getImageFunc();

        $status = $imagePrint($screen, $newPath);

        imageDestroy($img);

        return $status;
    }

    public function convertTo(string $newExtension, bool $removeOld = false)
    {
        self::checkExtension($newExtension);

        $fileName = pathinfo($this->getPath(), PATHINFO_FILENAME);
        $dirName = pathinfo($this->getPath(), PATHINFO_DIRNAME);

        $imageCreateFrom = $this->getCreateFromFunc();
        $image = $imageCreateFrom($this->getPath());

        $imgWidth = $this->getWidth();
        $imgHeight = $this->getHeight();

        // Create new image
        $newImage = imagecreatetruecolor($imgWidth, $imgHeight);

        //transparency for PNG
        if ($this->getExtension() === 'png') {
            $this->transparency($newImage);
        }

        // Copy and resize part of an image with resampling
        imagecopy($newImage, $image, 0, 0, 0, 0, $imgWidth, $imgHeight);

        $imageFunc = $this->getImageFunc($newExtension);
        $imageFunc($newImage,  "$dirName/$fileName.$newExtension");

        imageDestroy($image);

        if ($removeOld) {
            @unlink($this->getPath()); //todo redo for a method
        }
    }

    /**
     * Image cropping method.
     *
     * @param float $x
     * @param float $y
     * @param float $w
     * @param float $h
     * @param int $quality
     * @param string $newPath
     * @return mixed
     */
    public function crop(float $x = 0, float $y = 0, float $w = 0, float $h = 0, int $quality = 90, string $newPath = '')
    {
        if (!$newPath) {
            $newPath = $this->getPath();
        }

        $quality = $this->checkQuality($quality);
        $imageCreateFrom = $this->getCreateFromFunc();
        $currentImage = $imageCreateFrom($this->getPath()); //sys dir

        // Create new image
        $screen = imageCreateTrueColor($w, $h);

        // Alpha channel
        if ($this->getExtension() === 'png') {
            $this->transparency($screen);
        }

        // Copy and resize part of an image with resampling
        imagecopyresampled($screen, $currentImage, 0, 0, $x, $y, $w, $h, $w, $h);

        $imagePrint = $this->getImageFunc();

        $status = $imagePrint($screen, $newPath, $quality);

        imageDestroy($currentImage);

        return $status;
    }

    /**
     * Method of checking the value of image quality.
     *
     * imagejpeg // 0 - 100 (worst - best)
     * imagewebp // 0 - 100 (worst - best)
     * imagepng // 0 - 9 (no compress - worst)
     *
     * @param int $quality
     * @return int
     */
    private function checkQuality(int $quality): int
    {
        if ($quality > 100 || $quality < 0) {
            $quality = 60;
        }

        if ($this->getExtension() == 'png') {
            $quality = abs($quality / 10 - 10);

            if ($quality > 9 || $quality < 0) {
                $quality = 4;
            }
        }

        return $quality;
    }

    /**
     * Set transparency for image.
     *
     * @param GdImage resource $screen
     */
    private function transparency(&$screen)
    {
        // integer representation of the color black (rgb: 0,0,0)
        $background = imagecolorallocate($screen , 0, 0, 0);
        // removing the black from the placeholder
        imagecolortransparent($screen, $background);
        // turning off alpha blending (to ensure alpha channel information
        // is preserved, rather than removed (blending with the rest of the image in the form of black))
        imagealphablending($screen, false);
        // turning on alpha channel information saving (to ensure the full range of transparency is preserved)
        imagesavealpha($screen, true);
    }

    /**
     * get function for create new image
     * @param string $newExtension
     * @return string
     */
    private function getImageFunc(string $newExtension = '')
    {
        $extension = $newExtension ?: $this->getExtension();
        if ($extension === 'jpg') {
            return 'imageJpeg';
        }

        return 'image' . $extension;
    }

    /**
     * Get function name for create new image from.
     *
     * @param bool|string $extension
     * @return string
     */
    private function getCreateFromFunc($extension = false): string
    {
        if (!$extension) {
            $extension = $this->getExtension();
        }

        if ($extension === 'jpg') {
            return 'imagecreatefromjpeg';
        }

        return 'imagecreatefrom' . $extension;
    }

    /**
     * set image width and height
     * @return void
     */
    private function setImageSize()
    {
        [$width, $height] = getimagesize($this->getPath());

        $this->setWidth($width);
        $this->setHeight($height);
    }

    /**
     * setter for path
     * @param string $path
     * @return void
     * @throws Exception
     */
    public function setPath(string $path)
    {
        if (!file_exists($path)) {
            throw new Exception("Image does not exist");
        }

        //check if file extension is allowed
        $extension = self::checkExtension(pathinfo($path, PATHINFO_EXTENSION));
        $this->setExtension($extension);

        //check if the file size is not larger than the maximum size
        self::checkSize(filesize($path));

        $this->processName($path);

        $this->path = $path;
    }

    /**
     * getter for path
     * @return string
     */
    public function getPath(): string
    {
        return $this->path;
    }

    /**
     * setter for width
     * @param float $width
     * @return void
     */
    public function setWidth(float $width)
    {
        $this->width = $width;
    }

    /**
     * getter for width
     * @return float
     */
    public function getWidth(): float
    {
        return $this->width;
    }

    /**
     * Setter for file name
     *
     * @param string $name
     * @return void
     */
    public function setName(string $name)
    {
        $this->fileName = $name;
    }

    /**
     * Getter for file name
     *
     * @return string
     */
    public function getName(): string
    {
        return $this->fileName;
    }

    /**
     * setter for height
     * @param float $height
     * @return void
     */
    public function setHeight(float $height)
    {
        $this->height = $height;
    }

    /**
     * getter for height
     * @return float
     */
    public function getHeight(): float
    {
        return $this->height;
    }

    /**
     * setter for extension
     * @param string $extension
     * @return void
     */
    public function setExtension(string $extension)
    {
        $this->extension = $extension;
    }

    /**
     * getter for extension
     * @return string
     */
    public function getExtension(): string
    {
        return $this->extension;
    }


    /**
     * change image resolution if needed
     * @return bool
     */
    public function changeResolution(): bool
    {
        if (!$this->checkResolution()) {
            [$newWidth, $newHeight] = $this->calcValidResolution();
            return $this->resize($newWidth, $newHeight);
        }

        return true;
    }

    /**
     * @return bool
     */
    public function checkResolution(): bool
    {
        if ($this->getWidth() > self::$maxWidth || $this->getHeight() > self::$maxHeight) {
            return false;
        }

        return true;
    }

    /**
     * calculate new resolution
     * @return array
     */
    public function calcValidResolution(): array
    {
        $ratio = min(self::$maxWidth / $this->getWidth(), self::$maxHeight / $this->getHeight());
        $newWidth = round($this->getWidth() * $ratio);
        $newHeight = round($this->getHeight() * $ratio);

        return [$newWidth, $newHeight];
    }

    /**
     * Returns the original image name.
     *
     * @param string $path
     */
    private function processName(string $path)
    {
        $filenameWithExtension = basename($path);
        $fileInfo = pathinfo($filenameWithExtension);

        $this->fileName = $fileInfo['filename'];
    }
}