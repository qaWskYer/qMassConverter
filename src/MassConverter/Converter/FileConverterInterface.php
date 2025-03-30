<?php

namespace MassConverter\Converter;

interface FileConverterInterface
{
    public function convert(string $source, string $destination, string $filename, $quality = null): bool;
    
    public function getDefaultQuality();
    
    public function getQuality();
    public function setQuality($quality);
    
    public function getTargetExtension(): string;
}
