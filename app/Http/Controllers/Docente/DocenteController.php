<?php

namespace App\Http\Controllers\Docente;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Docente\Docente;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\EstudiantesExport;
use PHPExcel;
class DocenteController extends Controller
{
    /*
     * Obtiene los Cursos de un Docente
     */
    public function CursosDocente($ciclo,$id)
    {

        $cursos = \DB::select('exec ura.Sp_SEL_CursosxDocente ?, ?', array($ciclo,$id));

        return response()->json( $cursos );

    }

    /*
     * Obtiene los datos de la carga academica y datos del Docente
     */
    public function obtenerDatosCargaHorariaDocente($id,$ciclo)
    {

        $cargadocente = \DB::select('exec ura.Sp_DOCE_SEL_cursosXiDocenteIdXiControlCicloAcad ?,?', array($id,$ciclo));

        return response()->json($cargadocente);

    }


    /*
     * Obtiene informacion de contacto de un Docente
     */
    public function obtenerDatosContacto($codigo)
    {
        try {
            $data = \DB::select('exec [ura].[Sp_DOCE_SEL_DatosDocente] ?', array( $codigo ));
            $codeResponse = 200;
            
        } catch (\Exception $e) {
            
            $data = ['mensaje' => substr($e->errorInfo[2] ?? '', 54), 'exception' => $e];
            $codeResponse = 500;
        }
        
        return response()->json( $data, $codeResponse );
    }

    /*
     * edita informacion de contacto de un Docente
     */
    public function editarDatosContacto(Request $request)
        {

        # code...EXEC [ura].[Sp_ESTUD_UPD_datosContacto] @_cEstudCorreo varchar(200), @_cEstudTelef varchar(50), @cClave varchar(20), @cEstudCodUniv varchar(20), @iFilId int=0, @iCarreraId int
        $this->validate(
            $request, 
            [
                //'password' => 'required| min:6| required_with:password_confirmation| regex:/^.*(?=.{3,})(?=.*[a-zA-Z])(?=.*[0-9])(?=.*[\d\X])(?=.*[!$#%]).*$/| confirmed', 
                
                //'correo' => 'required',
                //'telefono' => 'required',
                'clave' => 'required|min:6',
                'clave2' => 'required|min:6|same:clave|regex:/^.*(?=.{3,})(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[\d\X])(?=.*[!$#%@]).*$/', 
                                                       
                //'clave2' => 'required|min:6|same:clave',
                'cDoceDni' => 'required',
                //'filId' => 'required',
                //'carreraId' => 'required',
            ], 
            [
                //'correo.required' => 'Hubo un problema al obtener el ID de Proforma.',
                //'telefono.required' => 'Hubo un problema al obtener el código del estudiante',
                'clave.required' => 'No pudo recordar su Clave.',
                'cDoceDni.required' => 'No se pudo identificar el DNI',
                //'filId.required' => 'Hubo un problema al obtener información de los cursos.',
                //'carreraId.required' => 'Hubo un problema al obtener información de los conceptos.',
                'clave.required' => 'Nueva contraseña es obligatorio',
                'clave.min' => 'Nueva contraseña debe ser de al menos :min caracteres',
                'clave2.required' => 'Repite contraseña es obligatorio',
                'clave2.min' => 'Repita contraseña debe ser de al menos :min caracteres',
                'clave2.same' => 'Nueva Contraseña y Repita Contraseña no coinciden.',
                'clave2.regex' => 'La contraseña debe de contener al menos una Mayusculas (A - Z), Minusculas (a - z), Numeros (0 - 9) y No alfanumérico (por ejemplo:!, $, # O%)',
                //'clave2.confirmed' => 'Confirmar contraseña.',
                
            ]
        );

        $parametros =[
            //$request->correo ?? NULL,
            //$request->telefono ?? NULL,
            $request->clave ?? NULL,
            $request->cDoceDni ?? NULL,
            //$request->filId ?? NULL,
            //$request->carreraId ?? NULL,
            //auth()->user()->cCredUsuario,
            'user',
            'equipo',
            $request->server->get('REMOTE_ADDR'),
            'mac'
        ];

        //dd($parametros);

        try {
            $queryResult = \DB::select('exec [ura].[Sp_DOCE_UPD_DatosDocente]  ?, ?, ?, ?, ?, ?', $parametros );
            $response = ['validated' => true, 'mensaje' => 'Se Guardaron sus Contraseñas correctamente.', 'queryResult' => $queryResult[0] ];

            $codeResponse = 200;
            
        } catch (\Exception $e) {
            
            $response = ['validated' => true, 'mensaje' => substr($e->errorInfo[2] ?? '', 54), 'exception' => $e];
            $codeResponse = 500;
        
        }

        return response()->json( $response, $codeResponse );
    }


    /**
     *
     *
     *
     *
     *
     */

    public function asistenciaCabecera($cDoceDni,$iControlCicloAcad,$iCarreraId,$cCurricCursoCod,$iCurricId,$iSeccionId)
    {

        $cursos = \DB::select('exec ura.Sp_DOCE_SEL_Asistencia_Cabecera ?,?,?,?,?,?', array($cDoceDni,$iControlCicloAcad,$iCarreraId,$cCurricCursoCod,$iCurricId,$iSeccionId));

        return response()->json($cursos);
    }

    public function asistenciaList($cDoceDni,$iControlCicloAcad,$iCarreraId,$cCurricCursoCod,$cFechaAsis,$iSeccionId)
    {
        $cursos = \DB::select('exec ura.Sp_DOCE_SEL_Asistencia_Listado ?,?,?,?,?,?', array($cDoceDni,$iControlCicloAcad,$iCarreraId,$cCurricCursoCod,$cFechaAsis,$iSeccionId));

        return response()->json($cursos);
    }

    public function listadoEstudiantes($iControlCicloAcad,$iFilId,$iCarreraId,$iCurricId,$cCurricCursoCod,$iSeccionId,$iDocenteId)
    {
        $list = \DB::select('exec ura.Sp_DOCE_SEL_Asistencia_Listado_Xls ?,?,?,?,?,?,?', array($iControlCicloAcad,$iFilId,$iCarreraId,$iCurricId,$cCurricCursoCod,$iSeccionId,$iDocenteId));
       /*  foreach ($list as $key => $value) {
            \print_r($value->Codigo_Estudiante);
        } */
        //dump($list);
        return response()->json($list);
    }
    public function exportlistEstudiantes($iControlCicloAcad,$iFilId,$iCarreraId,$iCurricId,$cCurricCursoCod,$iSeccionId,$iDocenteId)
    {
        $list = \DB::select('exec ura.Sp_DOCE_SEL_Asistencia_Listado_Xls ?,?,?,?,?,?,?', array($iControlCicloAcad,$iFilId,$iCarreraId,$iCurricId,$cCurricCursoCod,$iSeccionId,$iDocenteId));

        return (new EstudiantesExport(collect($list)))->download('estudiantes-list.xlsx');

    }

    public function exportlistEstudiantesXls($ControlCicloAcad,$iFilId,$iCarreraId,$iCurricId,$cCurricCursoCod,$iSeccionId,$iDocenteId)
    {

        $cursos = \DB::select('exec ura.Sp_DOCE_SEL_Asistencia_Listado_Xls ?,?,?,?,?,?,?', array($ControlCicloAcad,$iFilId,$iCarreraId,$iCurricId,$cCurricCursoCod,$iSeccionId,$iDocenteId));
        Excel::create('Listado de Asistencia', function($excel) use($cursos){

            $excel->sheet('Asistencia', function($sheet) use($cursos) {
                //$cursos = \DB::select('exec ura.Sp_DOCE_SEL_Asistencia_Listado_Xls ?,?,?,?,?,?', array(20192,1,2,'GP-413',1,324));
                $sheet->setCellValue('B1', 'UNIVERSIDAD NACIONAL DE MOQUEGUA');
                $sheet->mergeCells("B1:K1");
                $sheet->getStyle('B1')->getFont()->setName('Tahoma')->setBold(true)->setSize(22);
                $sheet->setCellValue('C3', 'DOCENTE');
                $sheet->setCellValue('C4', 'CARRERA');
                $sheet->setCellValue('C5', 'CURSO');
                $sheet->setCellValue('C6', 'CICLO');

                $sheet->setCellValue('I5', 'CODIGO CURSO');
                $sheet->setCellValue('I6', 'PLAN');

                
                $sheet->getStyle('C3')->getFont()->setName('Tahoma')->setBold(true)->setSize(10);
                $sheet->getStyle('C4')->getFont()->setName('Tahoma')->setBold(true)->setSize(10);
                $sheet->getStyle('C5')->getFont()->setName('Tahoma')->setBold(true)->setSize(10);
                $sheet->getStyle('C6')->getFont()->setName('Tahoma')->setBold(true)->setSize(10);

                $sheet->getStyle('I5')->getFont()->setName('Tahoma')->setBold(true)->setSize(10);
                $sheet->getStyle('I6')->getFont()->setName('Tahoma')->setBold(true)->setSize(10);
                


                $sheet->mergeCells("C3:D3");
                $sheet->mergeCells("C4:D4");
                $sheet->mergeCells("C5:D5");
                $sheet->mergeCells("C6:D6");

                $sheet->mergeCells("I5:J5");
                $sheet->mergeCells("I6:J6");

                $sheet->setCellValue('E3',$cursos[0]->Nombre_Docente);
                $sheet->setCellValue('E4',$cursos[0]->Carrera);
                $sheet->setCellValue('E5',$cursos[0]->Nombre_Curso);
                $sheet->setCellValue('E6',$cursos[0]->Ciclo_Academico);

                $sheet->setCellValue('K5',$cursos[0]->Codigo_Curso);
                $sheet->setCellValue('K6',$cursos[0]->Plan_Curso);

                $sheet->mergeCells("E3:H3");
                $sheet->mergeCells("E4:H4");
                $sheet->mergeCells("E5:H5");
                $sheet->mergeCells("E6:H6");



                $data= json_decode( json_encode($cursos), true);

                $sheet->setCellValue('C9', 'N°');
                $sheet->setCellValue('D9', 'CODIGO');
                $sheet->setCellValue('E9', 'APELLIDOS');
                $sheet->setCellValue('H9', 'NOMBRES');

                $sheet->getStyle('C9')->getFont()->setName('Tahoma')->setBold(true)->setSize(10);
                $sheet->getStyle('D9')->getFont()->setName('Tahoma')->setBold(true)->setSize(10);
                $sheet->getStyle('E9')->getFont()->setName('Tahoma')->setBold(true)->setSize(10);
                $sheet->getStyle('H9')->getFont()->setName('Tahoma')->setBold(true)->setSize(10);


                $sheet->mergeCells("E9:G9");
                $sheet->mergeCells("H9:J9");

                foreach ($cursos as $key => $value) {
                    $x = ($key + 10);
                    $c = "C".$x;
                    $d = "D".$x;

                    $e = "E".$x;
                    $f = "F".$x;

                    $g = "G".$x;
                    $h = "H".$x;
                    $j = "J".$x;

                    $sheet->setCellValue($c,$key+1);
                    $sheet->setCellValue($d,$value->Codigo_Estudiante);
                    $sheet->setCellValue($e,$value->Apellidos);
                    $sheet->mergeCells($e.":".$g);
                    $sheet->setCellValue($h,$value->Nombres);
                    $sheet->mergeCells($h.":".$j);

                    # code...
                }

                //$sheet->fromArray($data,'A5');
                $sheet->setOrientation('landscape');

            });

        })->download('xlsx');



    }

    public function estudianteList(Request $request)
    {
        $query = Docente::where();
    }

    public function HorarioDocente($idDocente,$ciclo)
    {
        $respuesta = \DB::select('exec ura.Sp_DOCE_SEL_horarioClasesXiDocenteIdXiControlCicloAcad ?, ?', array($idDocente,$ciclo));
        return response()->json( $respuesta );
    }

    public function exportHorarioDocenteXls($idDocente,$ciclo)
    {

        $respuesta = \DB::select('exec ura.Sp_DOCE_SEL_horarioClasesXiDocenteIdXiControlCicloAcad ?, ?', array($idDocente,$ciclo));
        Excel::create('Horario', function($excel) use($respuesta,$ciclo){

            $excel->sheet('Asistencia', function($sheet) use($respuesta,$ciclo) {
                
                $sheet->setCellValue('B1', 'UNIVERSIDAD NACIONAL DE MOQUEGUA');
                $sheet->mergeCells("B1:O1");
                $sheet->getStyle('B1')->getFont()->setName('Tahoma')->setBold(true)->setSize(22);
                $sheet->setCellValue('C3', 'DOCENTE');
                

                $sheet->getStyle('C3')->getFont()->setName('Tahoma')->setBold(true)->setSize(10);
               

                $sheet->setCellValue('B6', 'SEMESTRE '.$ciclo);
                $sheet->getStyle('B6')->getFont()->setName('Tahoma')->setBold(true)->setSize(12);

                
                
                
                $sheet->mergeCells("B6:N6");

                $sheet->cells('B6:N6', function ($cells) {
                    $cells->setBackground('#1299c5');
                    $cells->setAlignment('center');
                    $cells->setFontColor('#ffffff');
                });
                
                $sheet->cells('B1:O1', function ($cells) {
                    $cells->setBackground('#1299c5');
                    $cells->setAlignment('center');
                    $cells->setFontColor('#ffffff');
                });
                
               $sheet->setCellValue('D3',$respuesta[0]->cPersNombre.' '.$respuesta[0]->cPersPaterno.' '.$respuesta[0]->cPersMaterno);
                

                $sheet->setCellValue('B7', 'N°');
                $sheet->setCellValue('C7', 'CODIGO');
                $sheet->setCellValue('D7', 'NOMBRE DEL CURSO');
                $sheet->setCellValue('E7', 'SECCION');
                $sheet->setCellValue('F7', 'SEDE');
                
                $sheet->setCellValue('H7', 'DIA');
                $sheet->setCellValue('H8', 'LUNES');
                $sheet->setCellValue('I8', 'MARTES');
                $sheet->setCellValue('J8', 'MIERCOLES');
                $sheet->setCellValue('K8', 'JUEVES');
                $sheet->setCellValue('L8', 'VIERNES');
                $sheet->setCellValue('M8', 'SABADO');
                $sheet->setCellValue('N8', 'DOMINGO');


                $sheet->mergeCells("B7:B8");
                $sheet->mergeCells("C7:C8");
                $sheet->mergeCells("D7:D8");
                $sheet->mergeCells("E7:E8");

                $sheet->mergeCells("F7:G8");

                $sheet->mergeCells("H7:N7");
                
                $sheet->cells('B7:N8', function ($cells) {
                    $cells->setBackground('#1299c5');
                    $cells->setAlignment('center');
                    $cells->setFontColor('#ffffff');
                    $cells->setFontSize(11);
                    
                });

                $sheet->cells('B9:N130', function ($cells) {
                    
                    $cells->setFontSize(8);
                    
                });
                foreach ($respuesta as $key => $value) {


                    $x = ($key + 9);

                    $b = "B".$x;
                    $c = "C".$x;
                    $d = "D".$x;
                    $e = "E".$x;
                    $f = "F".$x;

                    $g = "G".$x;      

                    $h = "H".$x;
                    $i = "I".$x;

                    $j = "J".$x;
                    $k = "K".$x;

                    $l = "L".$x;
                    $m = "M".$x;
                    $n = "N".$x;

                    $sheet->setCellValue($b,$key+1);

                    $sheet->setCellValue($c,$value->cCurricCursoCod);
                    $sheet->setCellValue($d,$value->cCurricCursoDsc);
                    $sheet->setCellValue($e,$value->cSeccionDsc);
                    $sheet->setCellValue($f,$value->cFilDescripcion);
                    $sheet->mergeCells($f.":".$g);


                    $sheet->setCellValue($h,$value->lunes);
                    $sheet->setCellValue($i,$value->martes);
                    $sheet->setCellValue($j,$value->miercoles);
                    $sheet->setCellValue($k,$value->jueves);
                    $sheet->setCellValue($l,$value->viernes);
                    $sheet->setCellValue($m,$value->sabado);
                    $sheet->setCellValue($n,$value->domingo);
                    
                    

                    # code...
                }


                //$sheet->fromArray($data,'A5');
                $sheet->setOrientation('landscape');

            });

        })->download('xlsx');



    }


    public function exportlistAsistenciaExcel($idDocente,$ciclo)
    {

        $respuesta = \DB::select('exec ura.Sp_DOCE_SEL_horarioClasesXiDocenteIdXiControlCicloAcad ?, ?', array(324,20192));
        Excel::create('Asistencia de Estudiantes', function($excel) use($respuesta,$ciclo){
            for($i=1;$i<=3;$i++){
            $excel->sheet('Curso '.$i, function($sheet) use($respuesta,$ciclo) {
               
                $sheet->setCellValue('B1', 'UNIVERSIDAD NACIONAL DE MOQUEGUA');
                $sheet->mergeCells("B1:O1");
                $sheet->getStyle('B1')->getFont()->setName('Tahoma')->setBold(true)->setSize(22);
                $sheet->setCellValue('C3', 'DNI');
                $sheet->setCellValue('C4', 'DOCENTE');
                $sheet->setCellValue('C5', 'CICLO ACADEMICO');

                $sheet->setCellValue('G4', 'FECHA INICIO');
                $sheet->setCellValue('G5', 'FECHA FIN');


                $sheet->setCellValue('C7', 'HISTORIAL DE ASISTENCIA ');
                $sheet->setCellValue('C8', 'CURSO ');
                $sheet->setCellValue('F8', 'CODIGO ');
                $sheet->setCellValue('I8', 'CICLO ');
                $sheet->setCellValue('L8', 'SECCION ');
                
                
                $sheet->setCellValue('I9', '# ALUMNOS ');
                $sheet->setCellValue('L9', '% AVANCE ');

                $sheet->setCellValue('C10', 'N° ');
                $sheet->setCellValue('D10', 'CODIGO ');
                $sheet->setCellValue('F10', 'APELLIDOS ');
                $sheet->setCellValue('H10', 'NOMBRES ');
                $sheet->setCellValue('K10', 'ASISTENCIA ');

                $sheet->setCellValue('K11', 'A ');
                $sheet->setCellValue('L11', 'F ');
                $sheet->setCellValue('M11', '% A');
                $sheet->setCellValue('N11', '% F ');


                $sheet->getStyle('C3')->getFont()->setName('Tahoma')->setBold(true)->setSize(10);
                $sheet->getStyle('C4')->getFont()->setName('Tahoma')->setBold(true)->setSize(10);
                $sheet->getStyle('C5')->getFont()->setName('Tahoma')->setBold(true)->setSize(10);
                $sheet->getStyle('G4')->getFont()->setName('Tahoma')->setBold(true)->setSize(10);
                $sheet->getStyle('G5')->getFont()->setName('Tahoma')->setBold(true)->setSize(10);
                
                
                
                $sheet->mergeCells("C7:N7");
                $sheet->getStyle('C7')->getFont()->setName('Tahoma')->setBold(true)->setSize(11);

                $sheet->cells('B1:O1', function ($cells) {
                    
                    $cells->setAlignment('center');
                   
                });

                $sheet->cells('C7:N7', function ($cells) {
                    $cells->setBackground('#1299c5');
                    $cells->setAlignment('center');
                    $cells->setFontColor('#ffffff');
                });
                $sheet->cells('C8', function ($cells) {
                    $cells->setBackground('#1299c5');
                    $cells->setAlignment('center');
                    $cells->setFontColor('#ffffff');
                });
                $sheet->cells('F8', function ($cells) {
                    $cells->setBackground('#1299c5');
                    $cells->setAlignment('center');
                    $cells->setFontColor('#ffffff');
                });
                $sheet->cells('I8', function ($cells) {
                    $cells->setBackground('#1299c5');
                    $cells->setAlignment('center');
                    $cells->setFontColor('#ffffff');
                });
                $sheet->cells('L8', function ($cells) {
                    $cells->setBackground('#1299c5');
                    $cells->setAlignment('center');
                    $cells->setFontColor('#ffffff');
                });
                $sheet->cells('I9', function ($cells) {
                    $cells->setBackground('#1299c5');
                    $cells->setAlignment('center');
                    $cells->setFontColor('#ffffff');
                });
                $sheet->cells('L9', function ($cells) {
                    $cells->setBackground('#1299c5');
                    $cells->setAlignment('center');
                    $cells->setFontColor('#ffffff');
                });
                $sheet->cells('C10:N11', function ($cells) {
                  
                    $cells->setAlignment('center');
                   
                });
                $sheet->cells('C9:H9', function ($cells) {
                    $cells->setBackground('#ffffff');
                    $cells->setAlignment('center');
                    $cells->setFontColor('#ffffff');
                });

                $sheet->mergeCells("D8:E8");

                $sheet->mergeCells("C9:H9");

                $sheet->mergeCells("C10:C11");
                $sheet->mergeCells("D10:E11");
                $sheet->mergeCells("F10:G11");
                $sheet->mergeCells("H10:J11");
                
                $sheet->mergeCells("G8:H8");
                $sheet->cells('G8:H8', function ($cells) {
                    $cells->setBackground('#ffffff');
                    $cells->setAlignment('center');
                    $cells->setFontColor('#ffffff');
                });

                $sheet->mergeCells("J8:K8");
                $sheet->cells('J8:K8', function ($cells) {
                    $cells->setBackground('#ffffff');
                    $cells->setAlignment('center');
                    $cells->setFontColor('#ffffff');
                });

                $sheet->mergeCells("J9:K9");
                $sheet->cells('J9:K9', function ($cells) {
                    $cells->setBackground('#ffffff');
                    $cells->setAlignment('center');
                    $cells->setFontColor('#ffffff');
                });

                $sheet->mergeCells("M8:N8");
                $sheet->cells('M8:N8', function ($cells) {
                    $cells->setBackground('#ffffff');
                    $cells->setAlignment('center');
                    $cells->setFontColor('#ffffff');
                });

                $sheet->mergeCells("M9:N9");
                $sheet->cells('M9:N9', function ($cells) {
                    $cells->setBackground('#ffffff');
                    $cells->setAlignment('center');
                    $cells->setFontColor('#ffffff');
                });

                $sheet->mergeCells("K10:N10");
                
                $sheet->cells('C10:J11', function ($cells) {
                    $cells->setBackground('#1299c5');
                    $cells->setAlignment('center');
                    $cells->setFontColor('#ffffff');
                });
                $sheet->cells('K10:N10', function ($cells) {
                    $cells->setBackground('#1299c5');
                    $cells->setAlignment('center');
                    $cells->setFontColor('#ffffff');
                    
                });
                
                
                $sheet->setShowGridlines(false);
                //$sheet->fromArray($data,'A5');
                $sheet->setOrientation('landscape');

            }
        
        );

        }
    }
        )->download('xlsx');



    }

    public function exportlistAsistenciaPdf($idDocente,$ciclo)
    {

        $respuesta = \DB::select('exec ura.Sp_DOCE_SEL_horarioClasesXiDocenteIdXiControlCicloAcad ?, ?', array(324,20192));
        Excel::create('Asistencia de Estudiantes', function($excel) use($respuesta,$ciclo){
            for($i=1;$i<=3;$i++){
            $excel->sheet('Curso '.$i, function($sheet) use($respuesta,$ciclo) {
               
                $sheet->setCellValue('B1', 'UNIVERSIDAD NACIONAL DE MOQUEGUA');
                $sheet->mergeCells("B1:O1");
                $sheet->getStyle('B1')->getFont()->setName('Tahoma')->setBold(true)->setSize(22);
                $sheet->setCellValue('C3', 'DNI');
                $sheet->setCellValue('C4', 'DOCENTE');
                $sheet->setCellValue('C5', 'CICLO ACADEMICO');

                $sheet->setCellValue('G4', 'FECHA INICIO');
                $sheet->setCellValue('G5', 'FECHA FIN');


                $sheet->setCellValue('C7', 'HISTORIAL DE ASISTENCIA ');
                $sheet->setCellValue('C8', 'CURSO ');
                $sheet->setCellValue('F8', 'CODIGO ');
                $sheet->setCellValue('I8', 'CICLO ');
                $sheet->setCellValue('L8', 'SECCION ');
                
                
                $sheet->setCellValue('I9', '# ALUMNOS ');
                $sheet->setCellValue('L9', '% AVANCE ');

                $sheet->setCellValue('C10', 'N° ');
                $sheet->setCellValue('D10', 'CODIGO ');
                $sheet->setCellValue('F10', 'APELLIDOS ');
                $sheet->setCellValue('H10', 'NOMBRES ');
                $sheet->setCellValue('K10', 'ASISTENCIA ');

                $sheet->setCellValue('K11', 'A ');
                $sheet->setCellValue('L11', 'F ');
                $sheet->setCellValue('M11', '% A');
                $sheet->setCellValue('N11', '% F ');


                $sheet->getStyle('C3')->getFont()->setName('Tahoma')->setBold(true)->setSize(10);
                $sheet->getStyle('C4')->getFont()->setName('Tahoma')->setBold(true)->setSize(10);
                $sheet->getStyle('C5')->getFont()->setName('Tahoma')->setBold(true)->setSize(10);
                $sheet->getStyle('G4')->getFont()->setName('Tahoma')->setBold(true)->setSize(10);
                $sheet->getStyle('G5')->getFont()->setName('Tahoma')->setBold(true)->setSize(10);
                
                
                
                $sheet->mergeCells("C7:N7");
                $sheet->getStyle('C7')->getFont()->setName('Tahoma')->setBold(true)->setSize(11);

                $sheet->cells('B1:O1', function ($cells) {
                    
                    $cells->setAlignment('center');
                   
                });

                $sheet->cells('C7:N7', function ($cells) {
                    $cells->setBackground('#1299c5');
                    $cells->setAlignment('center');
                    $cells->setFontColor('#ffffff');
                });
                $sheet->cells('C8', function ($cells) {
                    $cells->setBackground('#1299c5');
                    $cells->setAlignment('center');
                    $cells->setFontColor('#ffffff');
                });
                $sheet->cells('F8', function ($cells) {
                    $cells->setBackground('#1299c5');
                    $cells->setAlignment('center');
                    $cells->setFontColor('#ffffff');
                });
                $sheet->cells('I8', function ($cells) {
                    $cells->setBackground('#1299c5');
                    $cells->setAlignment('center');
                    $cells->setFontColor('#ffffff');
                });
                $sheet->cells('L8', function ($cells) {
                    $cells->setBackground('#1299c5');
                    $cells->setAlignment('center');
                    $cells->setFontColor('#ffffff');
                });
                $sheet->cells('I9', function ($cells) {
                    $cells->setBackground('#1299c5');
                    $cells->setAlignment('center');
                    $cells->setFontColor('#ffffff');
                });
                $sheet->cells('L9', function ($cells) {
                    $cells->setBackground('#1299c5');
                    $cells->setAlignment('center');
                    $cells->setFontColor('#ffffff');
                });
                $sheet->cells('C10:N11', function ($cells) {
                  
                    $cells->setAlignment('center');
                   
                });
                $sheet->cells('C9:H9', function ($cells) {
                    $cells->setBackground('#ffffff');
                    $cells->setAlignment('center');
                    $cells->setFontColor('#ffffff');
                });

                $sheet->mergeCells("D8:E8");

                $sheet->mergeCells("C9:H9");

                $sheet->mergeCells("C10:C11");
                $sheet->mergeCells("D10:E11");
                $sheet->mergeCells("F10:G11");
                $sheet->mergeCells("H10:J11");
                
                $sheet->mergeCells("G8:H8");
                $sheet->cells('G8:H8', function ($cells) {
                    $cells->setBackground('#ffffff');
                    $cells->setAlignment('center');
                    $cells->setFontColor('#ffffff');
                });

                $sheet->mergeCells("J8:K8");
                $sheet->cells('J8:K8', function ($cells) {
                    $cells->setBackground('#ffffff');
                    $cells->setAlignment('center');
                    $cells->setFontColor('#ffffff');
                });

                $sheet->mergeCells("J9:K9");
                $sheet->cells('J9:K9', function ($cells) {
                    $cells->setBackground('#ffffff');
                    $cells->setAlignment('center');
                    $cells->setFontColor('#ffffff');
                });

                $sheet->mergeCells("M8:N8");
                $sheet->cells('M8:N8', function ($cells) {
                    $cells->setBackground('#ffffff');
                    $cells->setAlignment('center');
                    $cells->setFontColor('#ffffff');
                });

                $sheet->mergeCells("M9:N9");
                $sheet->cells('M9:N9', function ($cells) {
                    $cells->setBackground('#ffffff');
                    $cells->setAlignment('center');
                    $cells->setFontColor('#ffffff');
                });

                $sheet->mergeCells("K10:N10");
                
                $sheet->cells('C10:J11', function ($cells) {
                    $cells->setBackground('#1299c5');
                    $cells->setAlignment('center');
                    $cells->setFontColor('#ffffff');
                });
                $sheet->cells('K10:N10', function ($cells) {
                    $cells->setBackground('#1299c5');
                    $cells->setAlignment('center');
                    $cells->setFontColor('#ffffff');
                    
                });
                
                
                $sheet->setShowGridlines(false);
                //$sheet->fromArray($data,'A5');
                $sheet->setOrientation('landscape');

            }
        
        );

        }
    }
        )->download('pdf');





    }
    

    public function NotasEstudiante(Request $request)
    {   
        
        return $request[0];// [1];

    }



    public function InsertarAsistenciaCurso(Request $request)
    {
        $this->validate(
            $request,
            [
                'cDoceDni' => 'required',
                'iControlCicloAcad' => 'required|integer',
                'iCarreraId' => 'required|integer',
                'iCurricId' => 'required|integer',
                'cCurricCursoCod' => 'required',
                'cFechaAsis' => 'required',
                'iSeccionId' => 'required|integer',
            ],
            [
                'cDoceDni.required' => 'DNI del Docente requerido',
                'iControlCicloAcad.required' => 'Código del Ciclo Académico requerido',
                'iCarreraId.required' => 'Código de Carrera Profesional requerido',
                'iCurricId.required' => 'Currícula del Curso requerida',
                'cCurricCursoCod.required' => 'Código del Curso requerido.',
                'cFechaAsis.required' => 'Fecha de Asistencia requerida.',
                'iSeccionId.required' => 'Sección del Curso requerida.',
            ]
        );
        
        $parametros = [
            $request->cDoceDni,
            $request->iControlCicloAcad,
            $request->iCarreraId,
            $request->iCurricId,
            $request->cCurricCursoCod,
            $request->cFechaAsis,
            $request->iSeccionId,
        ];

        try {
            $data = \DB::select('exec ura.Sp_DOCE_INS_Asistencia_Genera_ListadoAsistencia ?, ?, ?, ?, ?, ?, ?', $parametros);

            $response = ['validated' => true, 'mensaje' => 'Se guardó la asistencia exitosamente.'];
            $codeResponse = 200;
        } catch (\Exception $e) {
            $response = ['validated' => true, 'mensaje' => substr($e->errorInfo[2], 54), 'code' => $e->getCode()];

            $codeResponse = 500;
        }

        return response()->json($response, $codeResponse);
    }

}
