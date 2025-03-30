<?php

namespace MassConverter\Converter;

class JpegToPngConverter implements FileConverterInterface
{
    protected const DEFAULT_QUALITY = 7;
    protected const TARGET_EXTENSION = 'png';
    
    protected $quality = self::DEFAULT_QUALITY;
    
    public function convert(string $source, string $destination, string $filename, $quality = null): bool
    {
        $image = imagecreatefromjpeg($source);
        $filepath = "{$destination}{$filename}." . self::TARGET_EXTENSION;
        
        return imagepng($image, $filepath, (int) ($quality ?? $this->quality));
    }
    
    public function getDefaultQuality()
    {
        return self::DEFAULT_QUALITY;
    }
    
    public function getQuality()
    {
        return $this->quality;
    }
    
    public function setQuality($quality)
    {
        if ($quality < -1 || $quality > 9) {
            throw new \InvalidArgumentException('Качество сжатия должно быть в диапазоне от -1 до 9');
        }
        $this->quality = $quality;
    }
    
    public function getTargetExtension(): string
    {
        return self::TARGET_EXTENSION;
    }
}
