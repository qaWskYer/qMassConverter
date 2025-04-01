<?php

namespace MassConverter\Converter;

abstract class AbstractConverter implements FileConverterInterface
{
    protected const DEFAULT_QUALITY = 7;
    protected const TARGET_EXTENSION = '';
    
    protected $quality = self::DEFAULT_QUALITY;
    
    public function convert(string $source, string $destination, string $filename, $quality = null): bool
    {
        // TODO: Implement convert() method.
        return false;
    }
    
    public function getDefaultQuality()
    {
        return static::DEFAULT_QUALITY;
    }
    
    public function getQuality()
    {
        return $this->quality;
    }
    
    public function setQuality($quality)
    {
        // TODO: Implement setQuality() method.
    }
    
    public function getTargetExtension(): string
    {
        return static::TARGET_EXTENSION;
    }
    
    
    protected function getFilepath(string $destination, string $filename): string
    {
        return "{$destination}{$filename}." . static::TARGET_EXTENSION;
    }
}
