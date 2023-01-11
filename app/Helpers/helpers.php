<?php

use Illuminate\Support\Str;

if (!function_exists('str_title')) {
    /**
     * Convert a value to title case.
     *
     * @param  string $value
     * @return string
     */
    function str_title($value)
    {
        return Str::ucfirst(mb_strtolower($value));
    }
}

if (!function_exists('money_view')) {
    function money_view($money)
    {
        $money = number_format((float)$money, 2, '.', ' ');
        $exploded = explode('.', $money);
        if ($exploded[1] == '00') {
            $money = $exploded[0];
        }
        return $money;
    }
}

if (!function_exists('get_webpack_asset')) {
    /**
     * @param string $filename
     * @return string
     * @throws Exception
     */
    function get_webpack_asset($filename)
    {
        $manifest = public_path('manifest.json');

        if (!file_exists($manifest)) {
            throw new Exception(
                "Problem to discover asset {$manifest}, it seems it doesn't exists"
            );
        }

        $manifest_files = json_decode(file_get_contents($manifest), true);

        if (!isset($manifest_files[$filename])) {
            throw new Exception("Asset file with name {$filename} is not included in manifest.json");
        }

        return array_get($manifest_files, $filename);
    }
}
