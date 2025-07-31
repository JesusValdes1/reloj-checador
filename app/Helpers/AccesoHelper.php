<?php

namespace App\Helpers;

use Exception;
// use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use GuzzleHttp\Client;
use function config;

class AccesoHelper
{
    /**
     * @throws Exception
     */
    static function httpClientParaAcceso(): Client
    {
        if ( !config('app.api-acceso-url') ) {
            throw new Exception('Url de la API Acceso no esta configurada');
        }

        $baseUrl = config('app.api-acceso-url') . '/api/';

        return new Client([
            'base_uri' => $baseUrl,
            'verify' => false, // Disable SSL
            'headers' => [
                'Accept' => 'application/json',
            ]
        ]);
    }

    /**
    * Solicita a la API Acceso la Autenticación del Usuario
    */
    static public function login(Request $request)
    {
        if ( !config('app.api-acceso-key') ) {
            throw new Exception('Key de la API Acceso no esta configurada');
        }

        $apiKey = config('app.api-acceso-key');

        $client = self::httpClientParaAcceso();

        $response = $client->request('POST', 'login', [
            'form_params' => [
                'usuario' => $request->usuario,
                'password' => $request->password,
                'api_key' => $apiKey,
                // 'aplicacion_key' => 'nombre-de-la-aplicacion',
            ]
        ]);

        return json_decode($response->getBody()->getContents());
    }

    /**
    * Solicita a la API Acceso la Autenticación del Usuario
    */
    static public function changePassword(Request $request, $userName)
    {
        if ( !config('app.api-acceso-key') ) {
            throw new Exception('Key de la API Acceso no esta configurada');
        }

        $apiKey = config('app.api-acceso-key');

        $client = self::httpClientParaAcceso();

        $response = $client->request('POST', 'changePassword', [
            'form_params' => [
                'password' => $request->password,
                'new_password' => $request->newPassword,
                'confirm_password' => $request->confirmPassword,
                'user_name' => $userName,
                'api_key' => $apiKey,
            ]
        ]);

        return json_decode($response->getBody()->getContents());
    }
}
