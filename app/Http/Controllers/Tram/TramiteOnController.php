<?php

namespace App\Http\Controllers\Tram;

use App\Http\Controllers\Controller;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TramiteOnController extends Controller
{
    public function conceptosTramites(Request $request)
    {
        $tramites =
            DB::select(
                'EXEC [grl].[Sp_SEL_conceptos_tramites_estudiantesXiEntIdXcEstudCodUniv] ?,?',
                [$request->iEntId, $request->cEstudCodUniv]

            );
        return response()->json($tramites, 200);
    }

    public function conceptosImportes(Request $request)
    {
        $tramites =
            DB::select(
                'EXEC grl.Sp_SEL_Conceptos_importes_estudiantesXiConcepIdXiCantidad ?,?',
                [$request->iConcepId,$request->iCantidad]

            );
        return response()->json($tramites, 200);
    }

    public function listTramite(Request $request)
    {
        $tramites =
            DB::select(
                'EXEC tram.Sp_SEL_tramitesXcEstudCodUniv ?',
                [$request->cEstudCodUniv]

            );
        return response()->json($tramites, 200);
    }

    public function tramitesEstudCodUniv(Request $request) {
        $adjunto = $request->cTramAdjuntarArchivo;
        /*
        if ($request->get('fotografia') == '') {
            $uploadedFile = $request->file('fotografia');
            $filename = time().'-'.$uploadedFile->getClientOriginalName();

            $archivoFoto =Storage::disk('public')->putFileAs(
                'certEstudios/fotos',
                $uploadedFile,
                $filename
            );
            $adjunto = $archivoFoto;
            // return $archivoFoto;
        }
        */
        // dd($request->fotografia);
        // return response()->json(Storage::url('files.asd'));
        if (preg_match('/^data:image\/(\w+);base64,/', $adjunto)) {
            $data = substr($adjunto, strpos($adjunto, ',') + 1);
            $filename = $request->cEstudCodUniv.'-'.time().'.jpg';
            $data = base64_decode($data);
            $filePath = 'certEstudios/fotos/' . $filename;
            Storage::disk('public')->put($filePath, $data);
            /*$archivoFoto =Storage::disk('public')->putFileAs(
                'certEstudios/fotos',
                $data,
                $filename
            );*/
            $adjunto = $filePath;
            // dd("stored");
        }

        /*
        if (strlen($adjunto) > 50) {
            $filename = time().'.jpg';
            $archivoFoto =Storage::disk('public')->putFileAs(
                'certEstudios/fotos',
                base64_decode($adjunto),
                $filename
            );
            dd($archivoFoto);
            // $adjunto = $archivoFoto;
        }*/

        //dd($adjunto);

        $this->validate(
            $request,
            [
                'cEstudCodUniv' => 'required',
                'iConcepId' => 'required',
                'iCantidad' => 'required',
                // 'fotografia' => 'image|mimes:jpeg,jpg|max:1024|dimensions:min_width=378,min_height=508,ratio=0,74',

            ],
            [
                'cEstudCodUniv.required' => 'Debe seleccionar un aula.',
                'iConcepId.required' => 'Hubo un problema al verificar la carrera.',
                'iCantidad.required' => 'Hubo un problema al verificar la filial.',
/*
                'fotografia.image' => 'El archivo adjunto debe ser una imagen',
                'fotografia.mimes' => 'El archivo adjunto debe ser formato JPG o JPEG',
                'fotografia.dimensions' => 'La imagen adjunta debe ser de tamaño 378 x 508 px.',
                'fotografia.ratio' => 'La imagen adjunta debe ser de tamaño 378 x 508 px.',
*/

            ]
        );
        $parametros = [
            $request->cEstudCodUniv,
            $request->iConcepId,
            $request->iTipoDocEstudId,
            $request->iCantidad,
            $request->cTramContenido,
            // $request->cTramAdjuntarArchivo,
            $adjunto,
            $request->iFilId,
            $request->cTramObservaciones,

            $request->cEquipoSis,
            $request->cIpSis,
            $request->cMacNicSis
        ];

        // return response()->json($parametros);


        try {
            $tramites =
            DB::select(
                // "EXEC tram.Sp_INS_tramitesXcEstudCodUniv '2010204017',10030,7,3,'','RUTA DE ARCHIVO',1,'OBSERVACIONES','','',''",
                'EXEC tram.Sp_INS_tramitesXcEstudCodUniv ?,?,?,?,?,?,?,?,       ?,?,?',
                $parametros
            );

            if ($tramites[0]->iResult > 0) {
                $response = ['validated' => true, 'mensaje' => 'El registro se guardo correctamene.'];
            } else {
                $response = ['validated' => true, 'mensaje' => 'No se ha podido guardar el registro.'];
            }
        } catch (\Exception $e) {
            $response = [
                        'error' => true,
                        'errorLaravel' => $e->getMessage(),
                        'data' => null
                    ];
        }

        return response()->json($response);
    }

    public function deleteTramite($iTramId)
    {
        $dataTramite = DB::select('EXEC tram.Sp_SEL_tramitesXiTramId ?', [$iTramId]);
        $filePath = $dataTramite[0]->cTramAdjuntarArchivo;
        Storage::delete($filePath);

        $tramites = DB::select(
                'tram.Sp_DEL_tramites_estudiantesXiTramId ?',
                ["{$iTramId}"]
            );

        return response()->json($tramites);
        if ($tramites[0]->iResult > 0) {
            $response = [ 'validated' => true, 'mensaje' => 'Se eliminó el registro exitosamente.', 'eliminados' => $data[0]->eliminados ];
        } else {
            $response = [ 'validated' => true, 'mensaje' => 'El registro no se ha podido eliminar o no existe.', 'eliminados' => $data[0]->eliminados ];
        }
        //catch(\Exception $e){
        $response = [
                        'error' => true,
                        'errorLaravel' => $e->getMessage(),
                        'data' => null
                    ];
        //}


        return response()->json($response);
    }

    public function seguimientoTraminte($iTramId)
    {
        $tramites =
            DB::select(
                'EXEC tram.Sp_SEL_tramites_movimientosXiTramId ?',
                [$iTramId]

            );
        return response()->json($tramites);
    }

    public function documentosEstudiantesDASA($id)
    {
        $tramites =
            DB::select(
                'EXEC tram.Sp_SEL_documentos_estudiantes_DASAXcConsultaVariablesCampos ?,?,?,?,?,?,?,?,?,?',
                array(1,$id,'',0,'',0,0,'','',0)


            );
        return response()->json($tramites);
    }
}
