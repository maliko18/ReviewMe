<?php

namespace App\Helpers;

use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Log;
use ReflectionClass;
use ReflectionException;

class Helper
{
    public static function getEnumClassValues(string $enumClass): array
    {
        try {
            $reflection = new ReflectionClass($enumClass);
            return Arr::pluck($reflection->getConstants(),'value');
        } catch (ReflectionException $e) {
            Log::error($e->getMessage());
            return [];
        }

    }
}
