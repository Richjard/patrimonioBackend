<?php

namespace App\Http\Controllers\DASA;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\UraEstudiante;

class ProcesoEstudianteController extends Controller
{   
    /**
     * Obtiene los estudiantes con reserva excedida
     * 
     * Mod: DASA - Procesar
     */
    public function obtenerEstudiantesReservaExcedida()
    {
        $cicloAcademico = \DB::select('exec ura.[Sp_GRAL_cicloAcademicoActivo]');
        
        $estudiantes = \DB::select('exec [ura].[Sp_GRAL_SEL_estudiantes_reserva_excedida] ?', array( $cicloAcademico[0]->iControlCicloAcad));
        
        $data = [ 'cicloAcademico' => $cicloAcademico[0], 'estudiantes' => $estudiantes ];

        return response()->json( $data );
    }

    /**
     * Obtiene los estudiantes con 4ta matricula desaprobada
     * 
     * Mod: DASA - Procesar
     */
    public function obtenerEstudiantesCuartaDesaprobada($carreraId, $cicloAcad)
    {
        $estudiantes = \DB::select('exec [ura].[Sp_GRAL_SEL_estudiantes_para_ser_retirados] ?, ?', array( $carreraId, $cicloAcad ));
        
        return response()->json( $estudiantes );
    }

    /**
     * Obtiene los estudiantes para cambio de plan
     * 
     * Mod: DASA - Procesar
     */
    public function obtenerEstudiantescambioPlan($carreraId, $plan)
    {
        $estudiantes = \DB::select('exec [ura].[Sp_GRAL_SEL_estudiantes_para_cambio_plan] ?, ?', array( $carreraId, $plan ));
        
        return response()->json( $estudiantes );
    }

    /**
     * Obtiene los estudiantes para ser sancionados
     * 
     * Mod: DASA - Procesar
     */
    public function obtenerEstudiantesASancionar($carreraId, $cicloAcad)
    {
        $estudiantes = \DB::select('exec [ura].[Sp_GRAL_SEL_estudiantes_tercera_matricula] ?, ?', array( $carreraId, $cicloAcad ));
        
        return response()->json( $estudiantes );
    }

    public function obtenerEstudiantesSinMatricula($carreraId, $cicloAcad)
    {
        $estudiantes_abandono = \DB::select('exec [ura].[Sp_GRAL_SEL_estudiantes_sin_matricula_abandono] ?, ?', array( $carreraId, $cicloAcad ));

        $ingresantes = \DB::select('exec [ura].[Sp_GRAL_SEL_ingresantes_sin_matricula] ?, ?', array( $carreraId, $cicloAcad ));

        $estudiantes_cambio = \DB::select('exec [ura].[Sp_GRAL_SEL_estudiantes_cambio_sin_matricula] ?, ?', array( $carreraId, $cicloAcad ));

        $data = [ 'estudiantes_abandono' => $estudiantes_abandono, 'ingresantes' => $ingresantes, 'estudiantes_cambio' => $estudiantes_cambio];
        
        return response()->json( $data );
    }

    public function actualizarEstadoEstudiante(Request $request)
    {   
        if ($request->tipoReporte == 'cuarta')
            $clasificacionId = 8;// 8: Clasific. Retiro
        elseif ($request->tipoReporte == 'tercera')
            $clasificacionId = 9;// 9: Clasific. Sancionado
        elseif ($request->tipoReporte == 'sinMat')
            $clasificacionId = 10;// 10: Clasific. Sin Matricula
        elseif ($request->tipoReporte == 'egresados')
            $clasificacionId = 2;// 10: Clasific. Egresado
        elseif ($request->tipoReporte == 'retiro_reserva')
            $clasificacionId = 15;// Clasific. Retiro por reserva excedida

        try {
            if ($request->tipoReporte == 'pps') {
                $queryResponse = \DB::select('exec ura.Sp_DASA_UPD_PPS_estudiantes ?, ?',array( $request->data, $request->cicloAcad));
            }
            elseif ($request->tipoReporte == 'ppa') {
                $queryResponse = \DB::select('exec [ura].[Sp_DASA_UPD_PPA_estudiantes] ?, ?',array( $request->data, $request->cicloAcad));
            }
            elseif ($request->tipoReporte == 'cambio_plan') {
                $queryResponse = 1;
            }
            else {
                $queryResponse = \DB::select('exec ura.Sp_DASA_UPD_clasificacion_estudiantes ?, ?',array( $request->data, $clasificacionId));
            }

            $response = ['validated' => true, 'mensaje' => 'Datos actualizados exitosamente.', 'queryResponse' => $queryResponse];
            $codeResponse = 200;

        } catch (\QueryException $e) {

            $response = ['validated' => true, 'mensaje' => substr($e->errorInfo[2] ?? '', 54), 'exception' => $e];
            $codeResponse = 500; 
        }

        return response()->json( $response, $codeResponse );
    }
}
