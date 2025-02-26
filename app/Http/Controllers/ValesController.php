<?php


namespace App\Http\Controllers;

use App\Models\Food;
use App\Models\FoodUser;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ValesController extends Controller
{
    public function goToValesView()
    {
        return view('comidas');
    }

    public function getVales(Request $request)
    {
        $vales = Food::where('unit_id', auth()->user()->unit_id)->get();
      return response()->json($vales);
    }

    public function crearVale(Request $request)
    {
        $request->validate([
            'descripcion' => 'required|string|max:255',
            'precio' => 'numeric',
        ]);

        $vale = Food::create([
            'descripcion' => $request->descripcion,
            'precio' => $request->precio,
            'estado' => 'disponible',
            'unit_id' => auth()->user()->unit_id,
        ]);

        return response()->json([
            'message' => 'Vale creado exitosamente',
            'vale' => $vale
        ], 201);
    }

    public function editarVale(Request $request)
    {
        $request->validate([
            'descripcion' => 'required|string|max:255',
            'precio' => 'numeric',
        ]);

        $vale = Food::findOrFail($request->id); // Busca el vale o devuelve 404

        $vale->update([
            'descripcion' => $request->descripcion,
            'precio' => $request->precio,
        ]);

        return response()->json([
            'message' => 'Vale actualizado exitosamente',
            'vale' => $vale
        ]);
    }

    public function eliminarVale(Request $request)
    {
        $vale = Food::findOrFail($request->id); // Busca el vale o lanza un error 404
        $vale->delete(); // Elimina el vale

        return response()->json([
            'message' => 'Vale eliminado exitosamente'
        ]);
    }
}
