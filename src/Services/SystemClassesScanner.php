<?php 
namespace BabeRuka\SystemRoles\Services;

use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;

class SystemClassesScanner
{
    protected $directory;

    public function __construct()
    {
        $this->directory = config('systemroles.controller_directory', 'app/Http/Controllers');
    }

    public function scanControllers()
    {
        $controllers = [];

        $iterator = new RecursiveIteratorIterator(new RecursiveDirectoryIterator(base_path($this->directory)));

        foreach ($iterator as $file) {
            if ($file->isFile() && $file->getExtension() === 'php') {
                $classInfo = $this->getClassInfo($file->getRealPath());
                if ($classInfo) {
                    $controllers[] = $classInfo;
                }
            }
        }

        return $controllers;
    }

    protected function getClassInfo($filePath)
    {
        $contents  = file_get_contents($filePath);
        $namespace = '';
        $className = '';

        // Extract namespace
        if (preg_match('/namespace\s+([^;]+);/', $contents, $matches)) {
            $namespace = trim($matches[1]);
        }

        // Extract class name
        if (preg_match('/class\s+(\w+)/', $contents, $matches)) {
            $className = trim($matches[1]);
        }

        if ($namespace && $className) {
            return [
                'filename'  => basename($filePath),
                'namespace' => $namespace,
                'classname' => $className,
            ];
        }

        return null;
    }
}
