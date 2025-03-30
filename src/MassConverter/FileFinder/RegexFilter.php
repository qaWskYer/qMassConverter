<?php

namespace MassConverter\FileFinder;

use MassConverter\helpers\DirectoryHelper;
use RegexIterator;

class RegexFilter implements FilterInterface
{
    protected $filter;
    
    public function __construct(string $filter)
    {
        $this->filter = $filter;
    }
    
    public function getFiles(string $path)
    {
        $flattened = DirectoryHelper::getFilesInDir($path);
        
        return new RegexIterator($flattened, $this->filter);
    }
}
