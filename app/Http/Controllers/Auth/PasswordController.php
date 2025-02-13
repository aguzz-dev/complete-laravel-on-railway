<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Mail\ResetPasswordCodeMail;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class PasswordController extends Controller
{
    public function sendCodeResetPassword(Request $request)
    {
        // Validar que el campo email esté presente y sea un email válido
        $request->validate([
            'email' => 'required|email',
        ]);

        // Generar un código de verificación
        $codigo = random_int(100, 999); // Código de 6 dígitos para mayor seguridad

        // Buscar al usuario por su email
        $user = User::where('email', $request->email)->first();

        // Si el usuario no existe, lanzar una excepción
        if (!$user) {
            throw new \Exception("El correo electrónico no está registrado.");
        }

        // Actualizar el campo remember_token con el código generado
        $user->remember_token = $codigo;
        $user->save();

        // Enviar el código por correo electrónico
        Mail::to($user->email)->send(new ResetPasswordCodeMail($codigo));

        // Retornar una respuesta JSON indicando que el código fue enviado
        return response()->json([
            'message' => 'Código de verificación enviado correctamente.',
        ]);
    }

    public function verificarCodeResetPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'code' => 'required',
        ]);

        $user = User::where('remember_token', $request->code)
            ->where('email', $request->email)
            ->first();

        if (!$user) {
            throw new \Exception("Código Inválido.");
        }

        return response()->json(['Codigo válido']);
    }

    public function showResetPasswordForm(Request $request)
    {
        // Obtener los parámetros de la URL (email y code)
        $email = $request->query('email');
        $code = $request->query('code');

        // Pasar los datos a la vista
        return view('resetpassword', [
            'email' => $email,
            'code' => $code,
        ]);
    }

    public function resetearPassword(Request $request)
    {
        $request->validate([
           'email' => 'required|email',
           'code' => 'required',
           'password' => 'required|string|min:8',
        ]);

        if ($request->password != $request->confirm_password) {
            throw new \Exception('Las contraseñas no coinciden.');
        }

        $user = User::where('email', $request->email)
            ->where('remember_token', $request->code)
            ->first();

        if (!$user) {
            throw new \Exception('Usuario no encontrado.');

        }

        $user->password = Hash::make($request->password);
        $user->remember_token = null;
        $user->save();
    }
}
