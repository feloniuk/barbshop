<?php

/**
 * Class File
 */
class File extends FileBase
{
    /**
     * @var array
     */
    public static array $allowedFormats = [
        '3gp'   => true,
        '7z'    => true,
        'amr'   => true,
        'apk'   => true,
        'avi'   => true,
        'bat'   => true,
        'bmp'   => true,
        'css'   => true,
        'djvu'  => true,
        'doc'   => true,
        'docx'  => true,
        'exe'   => true,
        'flv'   => true,
        'gif'   => true,
        'html'  => true,
        'ini'   => true,
        'ipa'   => true,
        'jar'   => true,
        'jpeg'  => true,
        'jpg'   => true,
        'js'    => true,
        'midi'  => true,
        'mp3'   => true,
        'mp4'   => true,
        'pdf'   => true,
        'php'   => true,
        'png'   => true,
        'pps'   => true,
        'ppt'   => true,
        'pptx'  => true,
        'psd'   => true,
        'rar'   => true,
        'svg'   => true,
        'sxc'   => true,
        'tar'   => true,
        'txt'   => true,
        'wav'   => true,
        'webm'  => true,
        'wma'   => true,
        'xls'   => true,
        'xlsx'  => true,
        'xml'   => true,
        'zip'   => true,
        'csv'   => true,
        'ico'   => true,
    ];

    /**
     * @var int
     */
    public static int $allowedFileSize = 15728640; //15M
}
