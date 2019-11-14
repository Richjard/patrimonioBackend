<?php

namespace App\Http\Controllers\DASA;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\UraCurriculaCursoDetalle;

class ReporteController extends Controller
{   
    /**
     * Reportes Matriculados
     */
    public function obtenerReporteMatriculados($cicloAcad)
    {
        $matriculados = \DB::select('exec ura.[Sp_ESTUD_SEL_estudiantes_matriculadosXcicloAcad] ?', array( $cicloAcad) );

        $proformas = \DB::select('exec ura.[Sp_ESTUD_SEL_estudiantes_proformasXcicloAcad] ?', array( $cicloAcad) );

        $total = \DB::select('exec ura.[Sp_ESTUD_SEL_count_matriculados]');

        return response()->json( [ 'matriculados' => $matriculados, 'proformas' => $proformas, 'total' => $total[0]->total ] );
    }

    public function matriculadosPorCurso($carrFilId, $curricID)
    {
        $matriculas = \DB::select('exec [ura].[Sp_DASA_SEL_matriculadosPorCurso] ?, ?', array($carrFilId, $curricID));

        return response()->json( $matriculas );
    }

    public function matriculadosPorCursoFilial($carreraId, $filialId, $curricID)
    {
        $matriculas = \DB::select('exec [ura].[Sp_DASA_SEL_matriculadosPorCursoXiCarrFilIdXiFilIdXiCurricId] ?, ?, ?', array($carreraId, $filialId, $curricID));

        return response()->json( $matriculas );
    }

    public function matriculadosPorCursoFilialDetallado(Request $request)
    {
        #@cCurricCursoCod varchar(25), @iSeccionId
        $matriculas = \DB::select('exec [ura].[Sp_DASA_SEL_estudiantesMatriculadosCursos] ?, ?, ?, ?, ?', array( $request->filialId, $request->carreraId, $request->curricId, $request->cursoCod, $request->seccionId));

        return response()->json( $matriculas );
    }

    public function matriculadosPorCarrera($carreraId, $semestre)
    {
        $matriculas = \DB::select('exec ura.Sp_SEL_Estudiantes_MatriculadosXiCarreraIdXiSemestre ?, ?', array( $carreraId, $semestre ));

        return response()->json( $matriculas );
    }

    public function matriculadosPorSemestre($semestre)
    {
        $matriculas = \DB::select('exec ura.Sp_SEL_Estudiantes_MatriculadosXiCarreraIdXiSemestre ?', array( $semestre ));

        return response()->json( $matriculas );
    }
}
