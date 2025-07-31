<?php

namespace App\Http\Controllers;

use App\Helpers\AccesoHelper;
use Illuminate\Http\Request;
use Session;

class LoginController extends Controller
{
    public function index()
    {
    	if ( Session::has('login') ) return redirect()->route('index');

        return view('login');
    }

	public function login(Request $request)
    {
        if ( Session::has('login') ) Session::flush();

        $credentials = $request->validate([
            // 'email' => ['required', 'email'],
            'usuario' => ['required'],
            'password' => ['required'],
        ], [
            'usuario.required' => 'El campo Usuario es requerido',
            'password.required' => 'El campo Password es requerido',
        ]);

        try {
        
            // Consumiendo la API Acceso
            $responseApi = AccesoHelper::login($request);

            if ( !$responseApi->error && $responseApi->usuario ) {
                $usuario = $responseApi->usuario;

                // if ( $usuario->esAdministrador || $usuario->tienePerfilAdministrador || $usuario->tieneAcceso ) {

                    Session::put('login', $usuario);

                    return redirect()->route('index');

                // }

                // return back()->withErrors([
                //     'usuario' => 'El usuario no tiene acceso a esta aplicación',
                // ])->with(['login-usuario' => $credentials['usuario']]);

            }

            return back()->withErrors([
                'usuario' => $responseApi->errorMessage,
            ])->with(['login-usuario' => $credentials['usuario']]);

        } catch (\Exception $e) {
            return back()->withErrors([
                // 'usuario' => 'No se lograron validar sus credenciales, intente de nuevo',
                'usuario' => $e->getMessage(),
            ])->with(['login-usuario' => $credentials['usuario']]);
        }
    }

    public function changePassword()
    {
        return view('cambiar-password', [ 'titulo' => 'Cambiar Contraseña' ]);
    }

    public function changePasswordUpdate(Request $request)
    {
        $passwords = $request->validate([
            'password' => ['required'],
            'newPassword' => ['required'],
            'confirmPassword' => ['required'],
        ], [
            'password.required' => 'El campo Contraseña Actual es requerido',
            'newPassword.required' => 'El campo Nueva Contraseña es requerido',
            'confirmPassword.required' => 'El campo Confirmar Contraseña es requerido',
        ]);

        try {

            $usuarioAutenticado = Session::get('login');
            $userName = $usuarioAutenticado->usuario;

            // Consumiendo la API Acceso
            $responseApi = AccesoHelper::changePassword($request, $userName);

            if ( !$responseApi->error ) {
                return redirect()->route('cambiar-password')
                    ->with(['clase-flash' => 'bg-success',
                            'titulo-flash' => 'Cambiar contraseña',
                            'subtitulo-flash' => 'OK',
                            'mensaje-flash' => 'La contraseña ha sido actualizada']);
            }

            return back()->withErrors([
                'password' => $responseApi->errorMessage,
            ]);

        } catch (\Exception $e) {
            return back()->withErrors([
                'password' => 'No se logró realizar el cambio de contraseña, intente de nuevo',
            ]);
        }
    }

    public function logout(Request $request)
    {
        if ( Session::has('login') ) Session::flush();
            
        return redirect()->route('index');
    }
}
