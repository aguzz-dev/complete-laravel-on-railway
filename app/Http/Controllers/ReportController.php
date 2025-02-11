<?php


namespace App\Http\Controllers;

use App\Models\Food;
use App\Models\FoodUser;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ReportController extends Controller
{

    public function goToDescargarReportesView()
    {
        $meses = FoodUser::selectRaw('DATE_FORMAT(date, "%Y-%m-%d") as formatted_date')
            ->distinct()
            ->pluck('formatted_date');

        return view('descargarReportes', compact('meses'));
    }

    public function generatePDF(Request $request)
    {
        $mes = $request->mes;
        $unidad = $request->unit_id;

        // Get the types of food
        $tiposComida = Food::where('unit_id', $unidad)->pluck('descripcion', 'id');

        // Get the meals grouped by user and food type
        $comidasPorUsuario = FoodUser::where('date', 'like', $mes . '%')
            ->with(['user', 'food'])
            ->get()
            ->groupBy(['user_id', 'food_id']);

        $meals = [];

        foreach ($comidasPorUsuario as $userId => $comidas) {
            $usuario = $comidas->first()->first()->user;
            $nombreUsuario = $usuario->grado . ' ' . $usuario->apellido . ' ' . $usuario->nombre;

            $meals[$nombreUsuario] = [];

            foreach ($comidas as $foodId => $comidasTipo) {
                $tipoComida = $tiposComida[$foodId] ?? 'Otro'; // If the food type doesn't exist, assign 'Otro'
                $meals[$nombreUsuario][$tipoComida] = $comidasTipo->count();
            }
        }

        $fechaDeGeneracion = Carbon::now()->format('d/m/Y');

        $nombreMesYear = Carbon::now()->locale('es')->isoFormat('MMMM/YYYY');

        $pdf = PDF::loadView('report', compact(['meals', 'fechaDeGeneracion', 'nombreMesYear']));

        return response($pdf->output(), 200)
            ->header('Content-Type', 'application/pdf')
            ->header('Content-Disposition', 'attachment; filename="Reporte-ValesEA.pdf"');
    }
}
