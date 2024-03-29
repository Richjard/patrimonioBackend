<?php

namespace App\Http\Controllers\DASA;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\UraFichaMatricula;

class EstudianteController extends Controller
{   
    /**
     * 
     */
    public function obtenerEstadosEstudiante()
    {
        $estados = \DB::select('exec [ura].[Sp_ESTUD_SEL_clasificaciones]');

        return response()->json( $estados );
    }

    /**
     * 
     */
    public function cambiarEstadoEstudiante(Request $request)
    {
        $this->validate(
            $request, 
            [
                'codUniv' => 'required',
                'idClasific' => 'required',
                'cicloAcad' => 'required',
            ], 
            [
                'codUniv.required' => 'Hubo un problema al obtener información del estudiante.',
                'idClasific.required' => 'Hubo un problema al obtener el estado',
                'cicloAcad.required' => 'Hubo un problema al obtener el ciclo académico.',
            ]
        );

        $parametros = [
            $request->codUniv,
            $request->idClasific,
            $request->resolucion ?? NULL,
            $request->detallesObs ?? NULL,
            $request->cicloAcad,
            auth()->user()->cCredUsuario,
            'equipo',
            $request->server->get('REMOTE_ADDR'),
            'mac'
        ];

        try {
            $queryResult = \DB::select("exec [ura].[Sp_DASA_UPD_clasificaciones] ?, ?, ?, ?, ?, ?, ?, ?, ?", $parametros);

            $response = ['validated' => true, 'mensaje' => 'Se cambió el estado del estudiante exitosamente.', 'queryResult' => $queryResult[0] ];

            $codeResponse = 200;
            
        } catch (\QueryException $e) {

            $response = ['validated' => true, 'mensaje' => substr($e->errorInfo[2] ?? '', 54), 'code' => $e->getCode(), 'exception' => $e];
            $codeResponse = 500;
        }
        
        return response()->json( $response, $codeResponse );
    }

    /**
     * Reseteo contraseña
     * 
     */
    public function resetearContraseniaEstudiante(Request $request)
    {
        $this->validate(
            $request, 
            [
                'persDocumento' => 'required',
            ], 
            [
                'persDocumento.required' => 'Hubo un problema al obtener el estudiante.',
            ]
        );

        $parametros = [
            $request->persDocumento,
            auth()->user()->cCredUsuario,
            'equipo',
            $request->server->get('REMOTE_ADDR'),
            'mac'
        ];

        try {
            $queryResult = \DB::select('exec [ura].[Sp_GRAL_UPD_reseteoContrasenia] ?, ?, ?, ?, ?', $parametros );
            $response = ['validated' => true, 'mensaje' => 'Se reestableció la contraseña correctamente.', 'queryResult' => $queryResult[0] ];

            $codeResponse = 200;
            
        } catch (\Exception $e) {
            
            $response = ['validated' => true, 'mensaje' => substr($e->errorInfo[2] ?? '', 54), 'exception' => $e];
            $codeResponse = 500;
        
        }

        return response()->json( $response, $codeResponse );

        # code...[ura].[Sp_GRAL_UPD_reseteoContrasenia] @_cPersDocumento varchar(20), @cUsuarioSis VARCHAR(50),@_cEquipoSis VARCHAR(50), @_cIpSis VARCHAR(15), @_cMacNicSis VARCHAR(35)
    }

    /**
     * Cambiar Contraseña estudiante
     * 
     */
    public function cambiarContraseniaEstudiante(Request $request)
    {
        $this->validate(
            $request, 
            [
                'clave' => 'required|min:6',
                'clave2' => 'required|min:6|same:clave',
            ], 
            [
                'clave.required' => 'El campo Nueva contraseña es obligatorio',
                'clave.min' => 'Los campos contraseña debe ser de al menos :min caracteres',
                'clave2.required' => 'El campo Repite contraseña es obligatorio',
                'clave2.min' => 'El campo contraseña debe ser de al menos :min caracteres',
                'clave2.same' => 'Los campos contraseña no coinciden.',
            ]
        );

        $parametros =[
            $request->clave,
            auth()->user()->cCredUsuario,
            'equipo',
            $request->server->get('REMOTE_ADDR'),
            'mac'
        ];

        try {
            $queryResult = \DB::select('exec [ura].[Sp_GRAL_UPD_cambioContrasenia] ?, ?, ?, ?, ?', $parametros );
            $response = ['validated' => true, 'mensaje' => 'Se cambió la contraseña correctamente.', 'queryResult' => $queryResult[0] ];

            $codeResponse = 200;
        } catch (\Exception $e) {
            $response = ['validated' => true, 'mensaje' => substr($e->errorInfo[2] ?? '', 54), 'exception' => $e];
            $codeResponse = 500;
        }

        return response()->json( $response, $codeResponse );
    }

    public function obtenerFichasMatriculas($codigo)
    {
        $fichas = \DB::select('exec [ura].[Sp_DASA_SEL_fichasMatriculas] ?', array($codigo));
        foreach ($fichas as $ficha) {
            $ficha->detalles = \DB::select('exec [ura].[Sp_DASA_SEL_fichasMatriculasDetalles] ?', array($ficha->iMatricId));
        }

        return response()->json( $fichas );
    }

    public function getObservacionesEstudiante($codigo, $local = false)
    {
        $observaciones = \DB::table('ura.observaciones')->where('cEstudCodUniv', $codigo)->get();

        if ($local) {
            return $observaciones;
        }
        return response()->json( $observaciones );
    }

    public function guardarObservacionEstudiante(Request $request)
    {
        $this->validate(
            $request, 
            [
                'codUniv' => 'required',
                'detallesObs' => 'required',
            ], 
            [
                'codUniv.required' => 'Hubo un problema al obtener la información del estudiante.',
                'detallesObs.required' => 'El campo Detalles es obligatorio.'
            ]
        );

        $parametros =[
            $request->codUniv,
            $request->resolucion ?? NULL,
            $request->detallesObs,
            auth()->user()->cCredUsuario,
            'equipo',
            $request->server->get('REMOTE_ADDR'),
            'mac'
        ];

        try {
            $queryResult = \DB::select('exec [ura].[Sp_DASA_INS_observaciones] ?, ?, ?, ?, ?, ?, ?', $parametros );

            $response = ['validated' => true, 'mensaje' => 'Se guardó la observación correctamente.', 'queryResult' => $queryResult[0], 'data' => $this->getObservacionesEstudiante($request->codUniv, true) ];

            $codeResponse = 200;
        } catch (\Exception $e) {
            $response = ['validated' => true, 'mensaje' => substr($e->errorInfo[2] ?? '', 54), 'exception' => $e];
            $codeResponse = 500;
        }

        return response()->json( $response, $codeResponse );
    }

    public function obtenerDatosFichaMatricula($codigo, $libre = 0)
    {
        # [Sp_DASA_SEL_datosInicialesFichasMatriculas]
        if ($libre == 1)
            $response = \DB::select('exec [ura].[Sp_DASA_SEL_datosInicialesFichasMatriculasLibres] ?', array($codigo));
        else
            $response = \DB::select('exec [ura].[Sp_DASA_SEL_datosInicialesFichasMatriculas] ?', array($codigo));

        $data = [];
            foreach ($response[0] as $key => $value) {
                $data[$key] = json_decode($value);
            }

        return response()->json( $data );
    }

    public function guardarReservaMatricula(Request $request)
    {
        $this->validate(
            $request, 
            [
                'codigo' => 'required',
                'cicloAcad' => 'required',
                'estudId' => 'required',
                'fechaFut' => 'required',
                'hasFicha' => 'required|boolean',
                'nroFut' => 'required'
            ], 
            [
                'codigo.required' => 'Hubo un problema al obtener la información del estudiante.',
                'cicloAcad.required' => 'Hubo un problema al obtener la información del ciclo académico.',
                'estudId.required' => 'Hubo un problema al obtener la información del estudiante.',
                'fechaFut.required' => 'El campo Fecha FUT es obligatorio.',
                'hasFicha.required' => 'Falta información de ficha.',
                'nroFut.required' => 'El campo Nro Registro FUT es obligatorio.'
            ]
        );

        if ($request->hasFicha) {
            $observacion = "FUT $request->fechaFut Registro Nº $request->nroFut :-: $request->infoRecibo :-: Rec. reserva Nº $request->recNro :-: PROCESADO " . date('d-m-Y H:i:s');
        }
        else {
            $observacion = "FUT $request->fechaFut Registro Nº $request->nroFut :-: (NO PAGÓ POR MATRÍCULA) :-: Rec. reserva Nº $request->recNro :-: PROCESADO " . date('d-m-Y H:i:s');
        }
        

        $parametros =[
            $request->estudId,
            $request->hasFicha,
            $observacion,
            $request->fichaId,
            $request->cicloAcad,
            auth()->user()->cCredUsuario,
            'equipo',
            $request->server->get('REMOTE_ADDR'),
            'mac'
        ];

        try {
            $queryResult = \DB::select("exec [ura].[Sp_DASA_UPD_clasificaciones] ?, ?, ?, ?, ?, ?, ?, ?, ?", array( $request->codigo, 6, NULL, 'Reserva de matrícula', $request->cicloAcad, auth()->user()->cCredUsuario, 'equipo', $request->server->get('REMOTE_ADDR'), 'mac'));

            if ($queryResult[0]->id > 0){
                $queryResult2 = \DB::select('exec [ura].[Sp_DASA_INS_UPD_reserva_matricula] ?, ?, ?, ?, ?, ?, ?, ?, ?', $parametros );

                $response = ['validated' => true, 'mensaje' => 'Se guardó la reserva de matrícula exitosamente.', 'queryResult' => $queryResult2[0] ];
                $codeResponse = 200;

                /*if ($queryResult2[0]->filasAfectadas > 0){
                    $response = ['validated' => true, 'mensaje' => 'Se guardó la reserva de matrícula exitosamente.', 'queryResult' => $queryResult2[0] ];
                    $codeResponse = 200;
                }
                else {
                    $response = ['validated' => true, 'mensaje' => 'No se pudo guardar la reserva de matrícula.' ];
                    $codeResponse = 500;
                }*/
            }
            else {
                $response = ['validated' => true, 'mensaje' => 'No se ha podido actualizar el estado del estudiante.'];
                $codeResponse = 500;
            }
        } catch (\QueryException $e) {
            $response = ['validated' => true, 'mensaje' => substr($e->errorInfo[2] ?? '', 54), 'exception' => $e];
            $codeResponse = 500;
        }

        return response()->json( $response, $codeResponse );
    }

    public function getPdfReserva($matricId)
    {
        $ficha =  UraFichaMatricula::select('ura.ficha_matriculas.iMatricId', 'ura.ficha_matriculas.iControlCicloAcad','ura.ficha_matriculas.cNumFicha', 'ura.ficha_matriculas.iEstudId','ura.ficha_matriculas.cEstudCodUniv', 'ura.ficha_matriculas.iCarreraId', 'ura.ficha_matriculas.iFilId', 'ura.ficha_matriculas.iCurricId', 'ura.curriculas.cCurricAnio', 'ura.carreras.cCarreraDsc', 'tre.ingresos.iDocSerie', 'tre.ingresos.iDocNro', 'tre.ingresos.dDocFecha', 'tre.ingresos.nIngImpt','ura.ficha_matriculas.iMatricEstado', 'ura.ficha_matriculas.dMatricFecha', 'ura.ficha_matriculas.cMatricObs', 'ura.ficha_matriculas.cMatricTipo', 'ura.ficha_matriculas.iTiposMatId', 'ura.ficha_matriculas.iMatricEstado', 'grl.personas.*', 'ura.ficha_matriculas.nMatricTotalCred')
        ->where([['ura.ficha_matriculas.iMatricId', $matricId], ['iMatricEstado', 1]])
        ->join('ura.carreras', 'ura.ficha_matriculas.iCarreraId', '=', 'ura.carreras.iCarreraId')
        ->join('ura.curriculas', 'ura.ficha_matriculas.iCurricid', '=', 'ura.curriculas.iCurricid')
        ->join('ura.estudiantes', 'ura.ficha_matriculas.iEstudId', '=', 'ura.estudiantes.iEstudId')
        ->join('grl.personas', 'grl.personas.iPersId', 'ura.estudiantes.iPersId')
        ->leftJoin('tre.ingresos', 'ura.ficha_matriculas.iReciboId', '=', 'tre.ingresos.iIngId')
        ->orderBy('ura.ficha_matriculas.iControlCicloAcad', 'DESC')
        ->first();

        //$barra = new DNS1D();

        $data = [
            'title' => 'Reserva de matrícula',
            'ficha' =>  $ficha,
            //'barra' =>  $barra
        ];
        
        $pdf = \PDF::loadView('estudiantes.reservaMatricula', $data);  
        return $pdf->stream();

    }

    public function rectificarMatricula(Request $request)
    {

        /*$this->validate(
            $request, 
            [
                'iProforId' => 'required',
                'cEstudCodUniv' => 'required',
                'iTiposMatId' => 'required',
                'cicloAcad' => 'required',
                'estudId' => 'required',
                'fechaFut' => 'required',
                'hasFicha' => 'required|boolean',
                'nroFut' => 'required'
            ], 
            [
                'iProforId.required' => 'Hubo un problema al obtener información de la matrícula.',
                'iTiposMatId.required' => 'Hubo un problema al obtener información de la matrícula.',
                'cEstudCodUniv.required' => 'Hubo un problema al obtener la información del estudiante.',
                'cicloAcad.required' => 'Hubo un problema al obtener la información del ciclo académico.',
                'estudId.required' => 'Hubo un problema al obtener la información del estudiante.',
                'fechaFut.required' => 'El campo Fecha FUT es obligatorio.',
                'hasFicha.required' => 'Falta información de ficha.',
                'nroFut.required' => 'El campo Nro Registro FUT es obligatorio.'
            ]
        );
        
        @iProfId INT = 0, 
        @cEstudCodUniv varchar(20), 
        @iTiposMatId int, 
        @bEsRegular int, 
        @UsuarioSis varchar(50), 
        @cEquipoSis varchar(35), 
        @cIpSis varchar(35), 
        @cMacNicSis varchar(35),
        @cursos_a_matricular_y_sus_conceptos_de_pago varchar(max), 
        @conceptos_a_pago_grl varchar(max),
        @cursos_a_matricular_adicional varchar(max)=null, 
        @cursos_a_matricular_electivos varchar(max)=null*/

        $user = auth()->user()->cCredUsuario;
        $ip = $request->server->get('REMOTE_ADDR');

        $cursos = $this->formatJson($request->d, 'cursos');
        $conceptos = json_encode($request->conceptos);
        $cursoExtra = $this->formatJson($request->extra, 'cursos');

        try {

            $queryResult = \DB::select("exec [ura].[Sp_ESTUD_INS_rectificacionMatricOnline] $request->iProforId, '$request->cEstudCodUniv', $request->iTiposMatId, $request->bRegular, '$user', 'equipo', '$ip', 'mac', '$cursos', '$conceptos', '$cursoExtra'");

            $mensaje = $queryResult[0]->cMensaje;

            $response = ['validated' => true, 'mensaje' => $mensaje, 'queryResult' => $queryResult[0] ];

            $codeResponse = 200;
            
        } catch (\QueryException $e) {
            //return response()->json( $e );
            $response = ['validated' => true, 'mensaje' => substr($e->errorInfo[2] ?? '', 54), 'code' => $e->getCode(), 'exception' => $e];
            $codeResponse = 500;
        }

        return response()->json( $response, $codeResponse );
    }

    public function formatJson($array, $tipo)
    {
        $data = [];

        foreach ($array as $registro) {

            if ($tipo == 'cursos') {
                $registro_nuevo = [ 
                    'iCurricId' => $registro['iCurricId'],
                    'cCurricAnio' => $registro['cCurricAnio'],
                    'iCurricCursoId' => $registro['iCurricCursoId'],
                    'iCarreraId' => $registro['iCarreraId'],
                    'cCurricCursoCod' => $registro['cCurricCursoCod'],
                    'cCurricDetCicloCurso' => $registro['cCurricDetCicloCurso'],
                    'iCurricDetHrsPCurso' => $registro['iCurricDetHrsPCurso'],
                    'iCurricDetHrsTcurso' => $registro['iCurricDetHrsTcurso'],
                    'nCurricDetCredCurso' => $registro['nCurricDetCredCurso'],
                    'num_matricula' => $registro['num_matricula'],
                    'tipo_curso' => $registro['tipo_curso'],
                    'iSeccionId' => $registro['iSeccionId'],
                    'iConceptoItem' => $registro['iConceptoItem'],
                    'nMontoCaja' => $registro['nMontoCaja'],
                ];
            }
            $data[] = $registro_nuevo;
        }
        
        return json_encode($data);
    }

    public function verificarCruceHorarioRectificacion(Request $request)
    {
        # [ura].[Sp_ESTUD_SEL_verificaCruceHorarios]

        $queryResult = \DB::select("exec [ura].[Sp_ESTUD_SEL_verificaCruceHorarios] ?, ?", array($request->cursosSeleccionados, $request->nuevoCurso));

        return response()->json( $queryResult );
    }

}
