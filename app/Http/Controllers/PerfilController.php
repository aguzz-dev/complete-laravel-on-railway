<?php
namespace App\Http\Controllers;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class PerfilController extends Controller
{
    public function goToPerfilView()
    {
        $user = auth()->user();

        return view('perfil', compact('user'));
    }

    public function updatePerfil(Request $request)
    {
        $user = Auth::user();

        $validator = Validator::make($request->all(), [
            'grado' => 'required|string|max:255',
            'nombre' => 'required|string|max:255',
            'apellido' => 'required|string|max:255',
            'dni' => 'required|string|max:20|unique:users,dni,' . $user->id,
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $user->update([
            'grado' => $request->input('grado'),
            'nombre' => $request->input('nombre'),
            'apellido' => $request->input('apellido'),
            'dni' => $request->input('dni'),
            'email' => $request->input('email'),
        ]);

        return redirect()->route('perfil')
            ->with('success', 'Perfil actualizado correctamente.');
    }
}
