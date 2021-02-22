<?php

namespace App\VolumeConverter;

interface VolumeConverter
{
    public function toLiters($volume, $number): float;
}