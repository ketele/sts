<?php

namespace App\VolumeConverter;

class ConverterContext
{
    private $converter;

    public function setConverter(VolumeConverter $converter)
    {
        $this->converter = $converter;
    }

    public function convertToLiters($volume = 0, $number = 1)
    {
        return $this->converter->toLiters($volume, $number);
    }
}