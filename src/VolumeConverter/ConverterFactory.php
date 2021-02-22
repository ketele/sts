<?php

namespace App\VolumeConverter;

class ConverterFactory
{
    public static function getConversionMethod(string $unit): VolumeConverter
    {
        switch ($unit) {
            case "ml":
                return new MillilitersConverter();
            default:
                throw new \Exception("Unknown Conversion Method");
        }
    }
}