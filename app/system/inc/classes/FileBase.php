<?php

/**
 * Base abstract file system class.
 */
abstract class FileBase
{
    /**
     * Allowed formats for the corresponding file type.
     *
     * @var array|true[]
     */
    public static array $allowedFormats;

    /**
     * Allowed upload file size.
     * Can be changed individually for the respective type.
     *
     * @var int
     */
    //static public int $allowedFileSize = 209715200; //200M
    public static int $allowedFileSize = 15728640; //15M

    /**
     * Format check method.
     *
     * @param string $extension
     * @return string
     * @throws Exception
     */
    public static function checkExtension(string $extension): string
    {
        if (is_null(static::$allowedFormats[$extension])) {
            throw new Exception(static::class . " is not in a valid format");
        }

        return $extension;
    }

    /**
     * Check file size.
     *
     * @param int $size
     * @return int
     * @throws Exception
     */
    public static function checkSize(int $size): int
    {
        if ($size > static::$allowedFileSize) {
            throw new Exception(static::class . " exceeds the maximum allowed size");
        }

        return $size;
    }


    /**
     * Function to check if the file exists.
     *
     * @param $path
     * @return bool
     */
    public static function exist($path): bool
    {
        if (file_exists($path)) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Function to return the size of a file along its path.
     *
     * @param $file
     * @return false|string
     */
    public static function fileSize($file)
    {
        if (self::exist($file)) {
            $fileSize = filesize(_SYSDIR_ . $file);
            return format_bytes($fileSize);
        }

        return false;
    }

    /**
     * Returns the file format from its name.
     *
     * @param $name
     * @return string
     */
    public static function format($name): string
    {
        $format = mb_strtolower($name);
        return mb_substr($format, mb_strrpos($format, '.') + 1);
    }

    /**
     * Writing content to a file.
     *
     * @param $path
     * @param $data
     * @return int|false
     */
    public static function write($path, $data)
    {
        return file_put_contents($path, $data);
    }

    /**
     * Reading content from file.
     *
     * @param $path
     * @return string
     */
    public static function read($path)
    {
        if (self::exist($path)) {
            return file_get_contents($path);
        }

        return false;
    }

    /**
     * Function create file.
     *
     * @param $contents
     * @param $pathSystem
     */
    public static function create($contents, $pathSystem)
    {
        $fp = fopen($pathSystem, 'w');
        fwrite($fp, $contents);
        fclose($fp);
    }

    /**
     * Function is used to delete a directory (folder) along with all its contents, including files and subfolders.
     *
     * @param $dirPath
     */
    public static function removeDir($dirPath)
    {
        if (!is_dir($dirPath)) {
            throw new InvalidArgumentException("$dirPath must be a directory");
        }

        if (substr($dirPath, strlen($dirPath) - 1, 1) != '/') {
            $dirPath .= '/';
        }

        $files = glob($dirPath . '*', GLOB_MARK);

        foreach ($files as $file) {
            if (is_dir($file)) {
                self::removeDir($file);
            } else {
                unlink($file);
            }
        }

        rmdir($dirPath);
    }
}
