<?php

namespace App\VolumeConverter;

interface VolumeConverter
{
    public function toKilograms($volume, $number): float;
}