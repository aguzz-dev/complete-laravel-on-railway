<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UsuariosAsociadosController extends Controller
{
    public function goToUsuariosAsociadosView()
    {
        $users = User::where('unit_id', Auth::user()->unit_id)->get();
        return view('usuariosAsociados', compact('users'));
    }
}
