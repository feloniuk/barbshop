<?php

include_once(_SYSDIR_ . 'system/inc/classes/FileBase.php');
include_once(_SYSDIR_ . 'system/Function.php');

/**
 * Class BuildModule
 */
class BuildModule
{
    private string $nameModule;
    private string $nameModuleToLower;
    private string $nameTable;
    private string $defaultPath;
    private string $pathSystem;
    private string $pathViews;
    private string $pathTemplates;

    private array $systemFiles = [
        'Controller.php',
        'Model.php',
        'Permission.php',
    ];

    private array $viewFiles = [
        'add.php',
        'archive.php',
        'edit.php',
        'index.php',
        '_table_body.php',
    ];

    public string $status = '';

    public function __construct(array $arguments, string $defaultPath, $template = 'module')
    {
        $this->nameModule = ucfirst($arguments[1]);
        $this->nameModuleToLower = strtolower($arguments[1]);
        $this->nameTable = isset($arguments[2]) ? $arguments[2] : $this->nameModuleToLower;
        $this->defaultPath = $defaultPath;
        $this->pathSystem = $defaultPath . '/system/';
        $this->pathViews = $defaultPath . '/views/';
        $this->pathTemplates = _SYSDIR_ . "system/inc/console/templates/$template/";

        $this->initBuild();
    }

    private function initBuild()
    {
        try {
            $this->generateModuleDirectory();
            $this->generateModuleSystemFiles();
            $this->generateModuleViewFiles();

            $this->status('s', 'Module has been created successfully!');
        } catch (Exception $e) {
            $this->status('e', $e->getMessage());
        }
    }

    /**
     * Method generating creation status.
     *
     * @param $code
     * @param $str
     */
    public function status($code, $str)
    {
        $this->status = ConsoleColor::getColor($code, $str);
    }

    /**
     * Create an directory to store the models in. If the directory already exists and contains files all files will be
     * removed to provide an empty directory for model generation.
     *
     * @param int $directoryMode The mode to create the directory with
     */
    public function generateModuleDirectory(int $directoryMode = 0777)
    {
        if (!is_dir($this->defaultPath)) {
            mkdir($this->defaultPath, $directoryMode, true);
        }

        $directoryIterator = new RecursiveDirectoryIterator($this->defaultPath, FilesystemIterator::SKIP_DOTS);
        $iterator = new RecursiveIteratorIterator($directoryIterator, RecursiveIteratorIterator::CHILD_FIRST);

        foreach ($iterator as $file) {
            $file->isDir() ? rmdir($file->getRealPath()) : unlink($file->getRealPath());
        }

        if (!is_dir($this->pathSystem)) {
            mkdir($this->pathSystem, $directoryMode, true);
        }

        if (!is_dir($this->pathViews)) {
            mkdir($this->pathViews, $directoryMode, true);
        }
    }

    private function generateModuleSystemFiles()
    {
        $this->generateFile('system');
    }

    private function generateModuleViewFiles()
    {
        $this->generateFile('views');
    }

    // Process System files
    private function generateFile($folder)
    {
        switch ($folder) {
            case 'system':
                $files = $this->systemFiles;
                $path = $this->pathSystem;
                break;
            case 'views':
                $files = $this->viewFiles;
                $path = $this->pathViews;
                break;
            default:
                $path = '';
                $files = [];
        }

        foreach ($files as $file) {
            if(!FileBase::exist($path . $file)) {
                $contents = $this->processContent($folder, $file);

                FileBase::write($path . $file, $contents);
            }
        }
    }

    /**
     * Process template for content pages system.
     *
     * @param $folder
     * @param $fileName
     * @return string
     * @throws ConsoleCommandException
     */
    public function processContent($folder, $fileName): string
    {
        $arrSearch  = []; // it will be replaced
        $arrReplace = []; // will be replaced on
        $arrOptions = []; // options

        $template = FileBase::read($this->pathTemplates . $folder . '/' . $fileName . 't');

        if (!$template) {
            throw new ConsoleCommandException('Template is not found!');
        }

        preg_match_all("~{{ (.*?) }}~sm", $template, $result, PREG_OFFSET_CAPTURE);

        foreach ($result[1] as $key => $value) {
            $pos = $result[0][$key][1]; // position of substring
            $arrSearch[$pos] = $result[0][$key][0];
            $arrOptions[$pos] = $value[0];
        }

        ksort($arrSearch);

        foreach ($arrSearch as $k => $v) {
            if ($arrOptions[$k] === 'className') {
                $arrReplace[$k] = $this->nameModule;
            }

            if ($arrOptions[$k] === 'classNamePath') {
                $arrReplace[$k] = $this->nameModuleToLower;
            }

            if ($arrOptions[$k] === 'tableName') {
                $arrReplace[$k] = $this->nameTable;
            }

            if ($arrOptions[$k] === 'singTableName') {
                $arrReplace[$k] = singularize($this->nameTable);
            }
        }

        return str_replace($arrSearch, $arrReplace, $template);
    }
}