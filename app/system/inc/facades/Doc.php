<?php

/**
 * Class Doc
 */
class Doc extends FileBase
{
    public static array $allowedFormats = [
        'doc'   => true,
        'docx'  => true,
        'pdf'   => true,
        'txt'   => true,
        'fotd'  => true
    ];

    /**
     * @var int
     */
    public static int $allowedFileSize = 15728640; //15M
}
