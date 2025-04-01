<?php

namespace MassConverter\Converter;

class JpegToPngConverter extends AbstractConverter
{
    protected const DEFAULT_QUALITY = 7;
    protected const TARGET_EXTENSION = 'png';
    
    public function convert(string $source, string $destination, string $filename, $quality = null): bool
    {
        $image = imagecreatefromjpeg($source);
        $filepath = "{$destination}{$filename}." . self::TARGET_EXTENSION;
        
        return imagepng($image, $filepath, (int) ($quality ?? $this->quality));
    }
    
    public function setQuality($quality)
    {
        if ($quality < -1 || $quality > 9) {
            throw new \InvalidArgumentException('Качество сжатия должно быть в диапазоне от -1 до 9');
        }
        $this->quality = $quality;
    }
}
