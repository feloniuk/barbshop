<?php

/**
 * Class Video
 */
class Video extends FileBase
{
    public static array $allowedFormats = [
        'mp4'   => true,
        'avi'   => true,
        'mkv'   => true,
    ];

    /**
     * @var int
     */
    public static int $allowedFileSize = 15728640; //15M
}
