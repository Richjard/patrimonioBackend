<?php

namespace App\Http\Controllers\Estudiante;

use App\Http\Controllers\Controller;
use App\UraEstudiante;
use Illuminate\Http\Request;

use PDF;

class ReportePDFController extends Controller
{
    /**
     * 
     */
    public function getDocumentoPDF($tipo, $codigo, $matricId)
    {
        $estudiante = UraEstudiante::where('cEstudCodUniv', $codigo)->join('ura.carreras', 'ura.carreras.iCarreraId', 'ura.estudiantes.iCarreraId')->join('grl.personas', 'grl.personas.iPersId', 'ura.estudiantes.iPersId')->first();

        $detalles = \DB::select('exec [ura].[Sp_ESTUD_SEL_boletaNotasXmatricId] ?', array($matricId));

        //return response()->json($detalles);

        switch ($tipo) {
            case 1:
                $pdf = PDF::loadView('estudiantes.fichaMatricula', [ 'estudiante' => $estudiante, 'detalles' => $detalles] )->setPaper('A4');
                break;
            
            case 2:
            
                //return view('estudiantes.boletaNotas', [ 'estudiante' => $estudiante, 'detalles' => $detalles] ); 

                $pdf = PDF::loadView('estudiantes.boletaNotas', [ 'estudiante' => $estudiante, 'detalles' => $detalles] )->setPaper('A4');

                break;
            
            default:
                # code...
                break;
        }

        return $pdf->stream();
    }
}
