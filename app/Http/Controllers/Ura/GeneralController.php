<?php

namespace App\Http\Controllers\Ura;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Generales\GrlPersonasController;

class GeneralController extends Controller
{
    /**
     * Busca entre docentes y estudiantes
     */
    public function buscarEstudiantesDocentes($parametro, $carreraId = 0, $filialId = 0)
    {
        
        $docentes = \DB::select('exec ura.[Sp_GRAL_SEL_docentesSistema] ?, ?',array($parametro, $carreraId));
        $estudiantes = \DB::select('exec ura.[Sp_GRAL_SEL_estudiantes] ?, ?, ?',array($parametro, $carreraId, $filialId));

        $data = [ 'docentes' => $docentes, 'estudiantes' => $estudiantes];

        return response()->json( $data );

    }

    /**
     * Obtener datos del estudiante
     */
    public function obtenerDatosEstudiante($codigo)
    {
        $estudiante = \DB::select('exec [ura].[Sp_GRAL_SEL_estudiantesXcEstudCodUniv] ?',array($codigo));

        $gpc = new GrlPersonasController();

        $request = new \Illuminate\Http\Request();
        $request->replace(['code' => $estudiante[0]->iPersId]);

        $estudiante[0]->fotoReniec = $gpc->getFotoReniec($request, true);
        
        return response()->json( $estudiante[0] );
    }

    /**
     * obtener el horario de un estudiante 
     */
    public function obtenerHorarioEstudiante($codigo, $cicloAcad)
    {
        $horario = \DB::select('exec [ura].[Sp_ESTUD_SEL_horario_estudiante] ?, ?',array($codigo, $cicloAcad));
        
        return response()->json( $horario );
    }

    public function reporteMatriculados($carreraId)
    {
        $estudiantes = \DB::select('exec [ura].[SP_SEL_reporte_matriculados] ?',array($carreraId));

        return view('reporteMatriculados', [ 'estudiantes' => $estudiantes ]);
    }

    public function obtenerFilialesCarreras()
    {
        $filialesCarreras = \DB::select('exec [ura].[Sp_GRAL_SEL_carrerasFiliales]');

        return response()->json( $filialesCarreras );
    }

    public function obtenerPlanesCarrera($carreraFilialId)
    {
        $planes = \DB::select('exec [ura].[Sp_GRAL_SEL_curriculasXiCarreraId] ?', array($carreraFilialId));

        return response()->json( $planes );
    }
}
