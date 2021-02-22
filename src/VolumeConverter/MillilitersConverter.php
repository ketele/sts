<?php

namespace App\VolumeConverter;

class MillilitersConverter implements VolumeConverter
{
    protected $multiplier = 0.001;

    public function toKilograms($volume = 0, $number = 1): float
    {
        return $volume * $number * $this->multiplier;
    }
}