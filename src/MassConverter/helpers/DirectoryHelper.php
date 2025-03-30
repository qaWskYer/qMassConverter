<?php

namespace MassConverter\helpers;

use Iterator;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;

class DirectoryHelper
{
    public static function createDirectory(string $path): bool
    {
        return mkdir($path, 0755, true) || is_dir($path);
    }
    
    public static function validatePath(string $path): bool
    {
        return is_dir($path);
    }
    
    public static function getFilesInDir(string $path): Iterator
    {
        $directory = new RecursiveDirectoryIterator($path);
        
        return new RecursiveIteratorIterator($directory);
    }
}
