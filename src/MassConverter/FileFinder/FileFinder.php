<?php

namespace MassConverter\FileFinder;

use MassConverter\validators\ValidatorInterface;

class FileFinder implements FileFinderInterface
{
    protected $validator;
    protected $filter;
    
    public function __construct(ValidatorInterface $validator, FilterInterface $filter)
    {
        $this->validator = $validator;
        $this->filter = $filter;
    }
    
    public function find(string $path): array
    {
        $files = $this->filter->getFiles($path);
        
        $result = [];
        
        foreach ($files as $file) {
            if ($this->validator->validate($file)) {
                $result[] = $file;
            }
        }
        
        return $result;
    }
}
