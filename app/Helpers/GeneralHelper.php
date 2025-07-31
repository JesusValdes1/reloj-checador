<?php

namespace App\Helpers;

// use Exception;
// use Illuminate\Support\Facades\DB;
// use Illuminate\Http\Request;
// use GuzzleHttp\Client;
// use function config;

class GeneralHelper
{
    /**
    * Convierte caracteres especiales en entidades HTML
    */
    static public function fString($string) {
        return ( is_null($string) ) ? "" : htmlspecialchars($string);
    }
}
