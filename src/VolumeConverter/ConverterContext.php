<?php

namespace App\VolumeConverter;

class ConverterContext
{
    private $converter;

    public function setConverter(VolumeConverter $converter)
    {
        $this->converter = $converter;
    }

    public function convertToKilograms($volume = 0, $number = 1)
    {
        return $this->converter->toKilograms($volume, $number);
    }
}