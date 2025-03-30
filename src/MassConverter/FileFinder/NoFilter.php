<?php

namespace MassConverter\FileFinder;

use MassConverter\FileFinder\FilterInterface;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;

class NoFilter implements FilterInterface
{
    
    public function getFiles(string $path)
    {
        $directory = new RecursiveDirectoryIterator($path);
        
        return new RecursiveIteratorIterator($directory);
    }
}
