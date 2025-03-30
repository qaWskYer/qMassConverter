<?php

namespace MassConverter\validators;

class JpegValidator implements ValidatorInterface
{
    public function validate(string $filepath): bool
    {
        $imgParams = getimagesize($filepath);
        
        return isset($imgParams['mime']) && $imgParams['mime'] === 'image/jpeg';
    }
}
