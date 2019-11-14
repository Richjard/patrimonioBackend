<?php

namespace App\Http\Controllers\Tram;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class TramitesController extends Controller
{
    //
    public function leerData(Request $request)
    {
        $req = $request->get('tipo');
        $data =  $request->get('data') ;

        //dd($data);

        DB::enableQueryLog();

        $respuesta = null;
        switch ($req) {
            case 'filiales':
                $respuesta = DB::select('EXEC grl.Sp_SEL_filialesXiEntId 1');
                break;
            case 'anios':
                //regresa anios con registros;
                $respuesta = DB::select("EXEC tram.Sp_SEL_tramites_iTramYearRegistro");
                break;
            case 'mes_anio':
                //regresa Meses con registro segun año;
                $respuesta = DB::select("EXEC tram.Sp_SEL_tramites_MesesXiTramYearRegistro  ?", $data);
                break;
            case 'data_fecha':
                //regresa registros en una fecha especificada
                $respuesta = DB::select("EXEC tram.Sp_SEL_tramitesXiDepenEmisorIdXcConsultaVariablesCampos 19,?,0,0,'',''", $data);
                break;
            case 'data_dias':
                //regresa registros en una fecha especificada
                $respuesta = DB::select("EXEC tram.Sp_SEL_tramites_enprocesosXiDepenIdXcConsultaVariablesCampos ?,'',0,0,'','', ?",$data);
                break;
            case 'data_mes':
                //regresa registros en un mes de año especifico
                $respuesta = DB::select("EXEC tram.Sp_SEL_tramitesXiDepenEmisorIdXcConsultaVariablesCampos  1,'',?,?,'',''", $data);
                break;
            case 'data_rango':
                //regresa registros en un rango de fechas.
                $respuesta = DB::select("EXEC tram.Sp_SEL_tramitesXiDepenEmisorIdXcConsultaVariablesCampos 1,'',0,0,?,?", $data);
                break;
            case 'data_personas':
                //Buscar personas por num documento o nombre
                //dd($data[0]);
                if (count($data)>1) {
                    $respuesta = DB::select("EXEC grl.Sp_SEL_personasXiTipoPersIdXcDocumento_cDescripcion ? ,?", $data);
                } else {
                    $respuesta = DB::select("EXEC grl.Sp_SEL_personasXcDocumento_cDescripcion ?", $data);
                }
                break;
            case 'data_oficinas_usuario':
                $respuesta = DB::select("EXEC seg.Sp_SEL_credenciales_dependenciasXiCredId ?", $data);
                break;
            case 'data_jefe_oficina':
                $respuesta = DB::select("EXEC seg.Sp_SEL_Tramites_DatosIniciales_NuevoTramiteXiDepenId ?", $data);
                break;
            case 'data_personal_oficina':
                $respuesta = DB::select("EXEC seg.Sp_SEL_credenciales_dependenciasXiDepenId ?", $data);
                break;
            case 'data_tipo_documentos':
                $respuesta = DB::select("EXEC grl.Sp_SEL_tipo_documentosXiTipoTramId ?", $data);
                break;
            case 'data_indicaciones':
                $respuesta = DB::select("EXEC tram.Sp_SEL_indicaciones");
                break;
            case 'data_observaciones':
                $respuesta = DB::select("EXEC tram.Sp_SEL_observaciones");
                break;
            case 'data_tupa':
                $respuesta = DB::select("EXEC grl.Sp_SEL_conceptosXiDepenIniciaId ?", $data);
                //$respuesta = DB::select("EXEC grl.Sp_SEL_tupasXiEntIdXcCodigo_cDenominacion ?,?", $data);
                break;
            case 'data_tupa_requisitos':
                $respuesta = DB::select("EXEC grl.Sp_SEL_conceptos_requisitosXiConcepId ?", $data);
                // $respuesta = DB::select("EXEC grl.Sp_SEL_tupas_requisitosXiTupaId ?", $data);
                break;
            case 'data_prioridades':
                $respuesta = DB::select('EXEC tram.Sp_SEL_tipo_prioridades', $data);
                // $respuesta = DB::select("EXEC grl.Sp_SEL_tupas_requisitosXiTupaId ?", $data);
                break;
            case 'data_tramites_proceso':
                $respuesta = DB::select('EXEC tram.Sp_SEL_tramites_enprocesosXiDepenIdXcConsultaVariablesCampos ?, ?, ?, ?, ?, ?', $data);
                // $respuesta = DB::select("EXEC grl.Sp_SEL_tupas_requisitosXiTupaId ?", $data);
                break;
            case 'data_destinatario_obligado':
                $respuesta = DB::select('EXEC tram.Sp_SEL_movimientos_DatosIniciales_EnvioXiTipoTramIdXiConcepIdXiTipoDocId ?, ?, ?, ?', $data);
                // $respuesta = DB::select("EXEC grl.Sp_SEL_tupas_requisitosXiTupaId ?", $data);
                break;
            case 'data_destinatarios_posibles':
                $respuesta = DB::select('EXEC tram.Sp_SEL_dependencias_EnvioXiTipoTramIdXiConcepIdXiTipoDocId ?, ?, ?, ?', $data);
                // $respuesta = DB::select("EXEC grl.Sp_SEL_tupas_requisitosXiTupaId ?", $data);
                break;
            case 'data_numeracion':
                $respuesta = DB::select('EXEC tram.Sp_SEL_iTramNumeroDocumentoXiDepenEmisorIdXiTipoDocIdXiTramYearDocumento ?, ?, ?', $data);
                // $respuesta = DB::select("EXEC grl.Sp_SEL_tupas_requisitosXiTupaId ?", $data);
                break;
            case 'data_credencial':
                if (!isset($data[0])) {
                    $data[0] = auth()->user()->iCredId;
                }
                $respuesta = DB::select('EXEC seg.Sp_SEL_credencialesXiCredId ?', $data);
                // $respuesta = DB::select("EXEC grl.Sp_SEL_tupas_requisitosXiTupaId ?", $data);
                break;
            case 'data_tramites_por_recibir':
                $respuesta = DB::select('EXEC tram.Sp_SEL_tramites_porrecibirXiDepenId_Receptor ?', $data);
                // $respuesta = DB::select("EXEC grl.Sp_SEL_tupas_requisitosXiTupaId ?", $data);
                break;
            case 'data_reniec':
                $respuesta = DB::select('EXEC grl.Sp_SEL_reniecXcReniecDni ?', $data);
/*
                if (count($respuesta)<1){

                }*/
                break;


            case 'dependencias_filial':
                $respuesta = DB::select('EXEC grl.Sp_SEL_dependenciasXiFilId ?', $data);
                break;




        }
        //dd($data);
        //dd(DB::getQueryLog());

        return response()->json($respuesta);
    }

    public function guardarData(Request $request)
    {
        $req = $request->get('tipo');
        $data = $request->get('data') ;

        $data = json_decode(json_encode($data));
        // $data = json_encode($data);
        // return $data->tipo_tramite_id;

        // return response()->json($data);

        if (auth()->user()->iCredId != $data->auditoria->credencial_id) {
            return response()->json(['error' => true, 'msg' => 'Usuario NO AUTENTICADO']);
        }




        //dd($data);

        //DB::enableQueryLog();

        $respuesta = null;
        switch ($req) {
            case 'nuevo_expediente':


                $dataIngreso = [
                    $data->tipo_tramite_id,
                    $data->emisor_interno->credencial_id,
                    $data->emisor_interno->dependencia_id??null,
                    $data->emisor_interno->firmante_persona_id??null,

                    $data->emisor_externo->persona_natural_id?$data->emisor_externo->persona_natural_id*1:null,
                    $data->emisor_externo->persona_natural_nombre??null,
                    $data->emisor_externo->persona_juridica_id?$data->emisor_externo->persona_juridica_id*1:null,

                    $data->fecha_documento,
                    $data->tipo_documento_id?$data->tipo_documento_id*1:null,
                    $data->numero_documento??null,
                    $data->sigla_documento??null,

                    $data->tiene_tupa?1:0,
                    $data->tupa_id_concepto??null,
                    $data->documento_asunto,
                    $data->documento_contenido??null,
                    $data->documento_folios??null,

                    $data->observacion_id?$data->observacion_id*1:null,
                    $data->emisor_externo->persona_natural_presentante_id?$data->emisor_externo->persona_natural_presentante_id*1:null,
                    $data->observacion??null,

                    $data->file??null,
                    json_encode($data->archivos_fisicos),

                    auth()->user()->iCredId,
                    null,
                    $data->auditoria->ip??null,
                    null,

                ];

                // return response()->json($dataIngreso);
                //$jsonResponse = $dataIngreso;
                //return response()->json($jsonResponse);
                try {
                    // ", $dataIngreso); //
                    //$jsonResponse = $dataIngreso;
                    $respuesta = DB::select('EXEC tram.Sp_INS_tramites ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?', $dataIngreso);
                    // DB::rollback();
                    // return response()->json($respuesta);
                    $reqDB = DB::select('EXEC tram.Sp_SEL_tramites_requisitosXiTramId ?', [$respuesta[0]->iTramId]);

                    foreach ($reqDB as $req) {
                        // return response()->json($data->chk_tupa_requisitos->{$req->iConcepReqId});
                        DB::select('EXEC tram.Sp_UPD_tramites_requisitos ?, ?, ?, ?, ?, ?', [
                            $req->iTramReqId,
                            $data->chk_tupa_requisitos->{$req->iConcepReqId}??0,


                            auth()->user()->iCredId,
                            null,
                            $data->auditoria->ip??null,
                            null,
                        ]);
                    }


                    /*
                    return response()->json($reqDB);

                    $dataRequisitos = $data->chk_tupa_requisitos;
                    foreach ($dataRequisitos as $key => $value) {
                        $rptaChk = DB::select('EXEC tram.Sp_UPD_tramites_requisitos ?, ?, ?, ?, ?, ?', [
                            $key,
                            $value,


                            auth()->user()->iCredId,
                            null,
                            $data->auditoria->ip??null,
                            null,
                            ]);
                    }
                    */

                    $dataDestinatarios = $data->destinatarios;
                    foreach ($dataDestinatarios as $destino){
                        $dataDestino = [
                            $respuesta[0]->iTramId,
                            $data->emisor_interno->credencial_id,
                            $data->emisor_interno->dependencia_id??null,
                            $data->emisor_interno->firmante_persona_id??null,

                            $destino->dependencia,
                            $destino->persona,
                            $destino->prioridad??1,
                            $destino->copia,
                            $destino->atencion??null,
                            $destino->plazo,

                            auth()->user()->iCredId,
                            null,
                            $data->auditoria->ip??null,
                            null,
                        ];
                        DB::select('EXEC tram.Sp_INS_tramites_movimientos_Enviar ?, ?, ?, ?,     ?, ?, ?, ?, ?, ?,       ?, ?, ?, ?', $dataDestino);
                    }

                    $detNuevoReg = DB::select('EXEC tram.Sp_SEL_tramitesXiTramId ?', $respuesta[0]->iTramId);

                    $dataRetorno = [
                        'tramite_id' => $respuesta[0]->iTramId,
                        'numeracion' => $respuesta[0]->cTramNumeroDocumento,
                        'qr' => $respuesta[0]->cTramQrNumRegistro,
                        'codigo' => $detNuevoReg[0]->cTramCodigoBusqueda
                    ];

                    $jsonResponse = [
                        'error' => false,
                        'msg' => 'Se guardo Correctamente',
                        'data' => $dataRetorno
                    ];
                } catch (\Exception $e) {
                    $jsonResponse = [
                        'error' => true,
                        'msg' =>  $msgResuelto,
                        //'mensaje' => substr($e->errorInfo[2], 54), 'code' => $e->getCode(),
                        'errorLaravel' => $e->getMessage(),
                        'data' => null
                    ];
                    DB::rollback();
                }

                // dd($data);


                // return response()->json(['error' => true, 'msg' => 'NO SE CONSIGUIO']);


                break;
            case 'recibir_tramite':
                $dataRecibir = $data->chkPorRecibir;
                $idxRec = [];
                foreach ($dataRecibir as $key => $value) {
                    if ($value) {
                        $idxRec[] = $key;
                    }
                }
                $idxRec = implode(',', $idxRec);
                DB::beginTransaction();
                try{
                    $respuesta = DB::select('EXEC tram.Sp_UPD_tramites_movimientos_RecepcionarXcCodigoCadena ?, ?, ?,       ?, ?, ?, ?', [
                        $idxRec,
                        $data->credencial_receptor,
                        $data->observacion??NULL,


                        auth()->user()->iCredId,
                        null,
                        $data->auditoria->ip??null,
                        null,
                    ]);

                    $dataRetorno = [
                    ];

                    $jsonResponse = [
                        'error' => false,
                        'msg' => 'Se guardo Correctamente',
                        'data' => $dataRetorno
                    ];
                    DB::commit();
                }
                catch(\Exception $e){
                    $jsonResponse = [
                        'error' => true,
                        'msg' =>  substr($e->errorInfo[2], 54), //'No se guardaron datos SQL, ERROR: ' . $e->getMessage(),
                        //'mensaje' => substr($e->errorInfo[2], 54), 'code' => $e->getCode(),
                        'errorLaravel' => $e->getMessage(),
                        'data' => null
                    ];
                    DB::rollback();
                }
                // return response()->json($data);
                break;
        }
        //dd($data);
        //dd(DB::getQueryLog());

        return response()->json($jsonResponse);
    }

    public function prueba()
    {
        $url = "https://ws5.pide.gob.pe/Rest/Reniec/Consultar?nuDniConsulta=43177406&nuDniUsuario=41395590&nuRucUsuario=20449347448&password=41395590";
        $result = file_get_contents($url, false);
        dd($result);
    }
}
