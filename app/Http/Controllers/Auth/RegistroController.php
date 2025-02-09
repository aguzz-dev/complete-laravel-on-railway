<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\RegistroRequest;
use App\Models\Unit;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class RegistroController extends Controller
{
    public function goToRegistroView($code)
    {
        $unidades = Unit::pluck('codigo');
        foreach ($unidades as $unidad) {
            if ($code == $unidad) {
                return view('registro', compact('code'));
            }
        }
        return view('errors.404');
    }

    public function registro(RegistroRequest $request)
    {
        $unitId = Unit::where('codigo', '=', $request->unit_id)->first()->id;

        User::create([
            'dni' => $request->dni,
            'grado' => $request->grado,
            'nombre' => $request->nombre,
            'apellido' => $request->apellido,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'status' => 1,
            'unit_id' => $unitId
        ]);

        return response()->json([
            'success' => 'usuario registrado correctamente',
        ], 200);
    }
}
