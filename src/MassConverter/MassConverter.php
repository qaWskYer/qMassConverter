<?php

namespace MassConverter;

use MassConverter\Converter\FileConverterInterface;
use MassConverter\Converter\JpegToPngConverter;
use MassConverter\exceptions\ConvertingException;
use MassConverter\FileFinder\FileFinder;
use MassConverter\FileFinder\FileFinderInterface;
use MassConverter\FileFinder\FilterInterface;
use MassConverter\FileFinder\NoFilter;
use MassConverter\helpers\DirectoryHelper;
use MassConverter\validators\JpegValidator;
use RuntimeException;

class MassConverter
{
    protected $path;
    protected $newPath;
    protected $filters;
    protected $files = [];
    protected $successCount = 0;
    protected $errors = [];
    
    protected $createIfNotExist = false;
    
    protected $fileFinder;
    protected $fileConverter;
    
    public function __construct(
        string $path,
        FileFinderInterface $fileFinder,
        FileConverterInterface $fileConverter
    ) {
        $this->path = $path;
        $this->fileFinder = $fileFinder;
        $this->fileConverter = $fileConverter;
    }
    
    public static function createJpegToPng(string $path): self
    {
        return new self(
            $path,
            new FileFinder(new JpegValidator(), new NoFilter()),
            new JpegToPngConverter()
        );
    }
    
    public function setFilters(FilterInterface $filters): self
    {
        $this->filters = $filters;
        
        return $this;
    }
    
    public function setQuality($quality): self
    {
        $this->fileConverter->setQuality($quality);
        
        return $this;
    }
    
    public function enableCreateDirectory(bool $create): self
    {
        $this->createIfNotExist = $create;
        
        return $this;
    }
    
    public function collectFiles(): self
    {
        $this->files = $this->fileFinder->find($this->path);
        
        return $this;
    }
    
    public function getFiles(): array
    {
        return $this->files;
    }
    
    public function convert(string $newPath = null): bool
    {
        $this->clearSuccessCount();
        $this->setOutputDirectory($newPath ?: $this->path);
        
        foreach ($this->files as $file) {
            try {
                $filename = pathinfo($file, PATHINFO_FILENAME);
                
                if ($this->fileConverter->convert($file, $this->newPath, $filename)) {
                    $this->successCount++;
                } else {
                    throw new ConvertingException('Ошибка сохранения');
                }
            } catch (ConvertingException $e) {
                $this->addError("[{$filename}." . $this->fileConverter->getTargetExtension() . "]: {$e->getMessage()}");
            }
        }
        
        return !$this->hasErrors();
    }
    
    public function getErrors(): array
    {
        return $this->errors;
    }
    
    public function addError(string $error): void
    {
        $this->errors[] = $error;
    }
    
    public function hasErrors(): bool
    {
        return !empty($this->errors);
    }
    
    public function getSuccessCount(): int
    {
        return $this->successCount;
    }
    
    
    protected function clearSuccessCount(): void
    {
        $this->successCount = 0;
    }
    
    protected function setOutputDirectory(string $path): void
    {
        if (!DirectoryHelper::validatePath($path)) {
            if ($this->createIfNotExist) {
                if (!DirectoryHelper::createDirectory($path)) {
                    throw new RuntimeException('Не удалось создать каталог: ' . $path);
                }
            } else {
                throw new RuntimeException('Каталог не существует: ' . $path);
            }
        }
        
        $this->newPath = rtrim($path, '/\\') . DIRECTORY_SEPARATOR;
    }
}
