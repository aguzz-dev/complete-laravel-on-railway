<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'dni' => 'required|string',
            'password' => 'required|string',
        ]);

        if (Auth::attempt($credentials)) {
            $ruta = Auth::user()->status === 'admin' ? 'dashboard' : 'seleccionar';
            return redirect()->route($ruta);
        }
        return redirect()->back()->withErrors(['Credenciales incorrectas']);
    }
}
