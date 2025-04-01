<?php

namespace MassConverter\Converter;

class JpegToGifConverter extends AbstractConverter
{
    protected const TARGET_EXTENSION = 'gif';
    
    public function convert(string $source, string $destination, string $filename, $quality = null): bool
    {
        $image = imagecreatefromjpeg($source);
        $filepath = $this->getFilepath($destination, $filename);
        
        return imagegif($image, $filepath);
    }
}
