<?php

namespace App\Helpers;

use Carbon\Carbon;

class Helper
{

    public static function formatDate(?string $data, string $format = 'd/m/Y'): string
    {
        if (!$data) return '-';

        return Carbon::parse($data)->format($format);
    }

    public static function formatToCurrency(?float $number, string $currency = 'R$ '): string
    {
        if (!$number) return '-';
        return $currency . number_format($number, 2, ',', '.');
    }
}