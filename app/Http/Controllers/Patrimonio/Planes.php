<?php

namespace App\Http\Controllers\Patrimonio;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class Planes extends Controller
{
    /**
     * 
     * 
     * @return \Illuminate\Http\JsonResponse
     */

    //public function getResult($skip,$top,$inlinecount,$format){
     public function getResult(Request $request){

          $skip=$request->skip;
          $top=$request->top;
          $order=$request->order;
          $value_filtro_cPlanContDescripcion="";
          $order="";
          if($request->order){$order=$request->order;}
          if($request->filter){                    
            for($i=0;$i<count($request->filter[0]['predicates']);$i++){              
              if($request->filter[0]['predicates'][$i]['field']=="cPlanContDescripcion"){
                 $value_filtro_cPlanContDescripcion=$request->filter[0]['predicates'][$i]['value'];
              }
            }

          }
          $datos = null;        
       
       // $respuesta = DB::select('EXECUTE tram.Sp_SEL_CiclosAcademicosMatricXcEstudCodUniv ?', $data);
         $datos = \DB::select("EXEC pat.Sp_SEL_Plan ?,?,?,?",array( $skip,$top,$value_filtro_cPlanContDescripcion,$order));
     // print_r($datos)
         // $total=45;
          $total=\DB::select("EXEC pat.Sp_COUNT_Plan ?",array($value_filtro_cPlanContDescripcion));
          $data = [       
                    'filter'=> $value_filtro_cPlanContDescripcion,              
                    'results' =>$datos,
                    'count' => $total[0]->iTotalRegistros
                                             
                  ];

       return response()->json($data);
        //  return $data;
       // return response()->"{\"result\":" .json($respuesta). ",\"count\":".$total."}";
    }

     public function getCombo(){
       // $respuesta = DB::select('EXECUTE tram.Sp_SEL_CiclosAcademicosMatricXcEstudCodUniv ?', $data);
         $datos = \DB::select("EXEC pat.Sp_SEL_Combo_Grupo_generico");
  
          $data = [         
                    'results' =>$datos                                             
                  ];

       return response()->json($datos);
        //  return $data;
       // return response()->"{\"result\":" .json($respuesta). ",\"count\":".$total."}";
    }

 


    public function guardar(Request $request)
    {
        $this->validate(
            $request, 
            [
                'cPlanContDescripcion' => 'required',
                 'cPlanContCodigo' => 'required',
            ], 
            [
               
                'cPlanContDescripcion.required' => 'Hubo un problema al obtener la descripcion d',
                'cPlanContCodigo.required' => 'Hubo un problema al obtener la descripcion d',
            ]
        );

        $ip = $request->server->get('REMOTE_ADDR');
        try {
            $queryResult = \DB::select("exec [pat].[Sp_INS_Plan] ?,?,? ",array($request->cPlanContDescripcion,$request->cPlanContCodigo,20648) );   
            $response = ['validated' => true, 'mensaje' => 'Se guardó  : '. $queryResult[0]->cPlanContDescripcion.', exitosamente.', 'queryResult' => $queryResult[0] ];
            $codeResponse = 200;            
        } catch (\QueryException $e) {;
            $response = ['validated' => true, 'mensaje' => substr($e->errorInfo[2] ?? '', 54), 'code' => $e->getCode(), 'exception' => $e];
            $codeResponse = 500;
        }        
        return response()->json( $response, $codeResponse );

    }

     public function modificar(Request $request, $id)
    {
       $this->validate(
            $request, 
            [
                'iPlanContId' => 'required',  
                'cPlanContDescripcion' => 'required',
                 'cPlanContCodigo' => 'required',
            ], 
            [
               'iPlanContId.required' => 'Hubo un problema al obtener ID ',
                'cPlanContDescripcion.required' => 'Hubo un problema al obtener la descripcion d',
                'cPlanContCodigo.required' => 'Hubo un problema al obtener la descripcion d',
            ]
        );

        $ip = $request->server->get('REMOTE_ADDR');
       /* $response = ['validated' => true, 'mensaje' => 'Se guardó el Local exitosamente.'];
            $codeResponse = 200;  */
        try {
            $queryResult = \DB::select("exec [pat].[Sp_UPD_Plan] ?, ?, ?,?", array($id,$request->cPlanContDescripcion,$request->cPlanContCodigo,20648));   
            $response = ['validated' => true, 'mensaje' => 'Se Modifico   : '. $queryResult[0]->cPlanContDescripcion.', exitosamente.', 'queryResult' => $queryResult[0] ];
            $codeResponse = 200;            
        } catch (\QueryException $e) {
            //return response()->json( $e );
            $response = ['validated' => true, 'mensaje' => substr($e->errorInfo[2] ?? '', 54), 'code' => $e->getCode(), 'exception' => $e];
            $codeResponse = 500;
        }
        //NO CAPTURAN LOS EERROS SQL DB
        
        return response()->json( $response, $codeResponse );

    }

    public function eliminar($id)
    {
        $data = \DB::select('exec pat.Sp_DEL_Plan ?', array($id));
        if ($data[0]->eliminados > 0) {
            $response = [ 'validated' => true, 'mensaje' => 'Se eliminó el horario exitosamente.', 'eliminados' => $data[0]->eliminados ];
            $codeResponse = 200;
        } else {
            $response = [ 'validated' => true, 'mensaje' => 'El horario no se ha podido eliminar o no existe.', 'eliminados' => $data[0]->eliminados ];
            $codeResponse = 500;
        }

        return response()->json($response, $codeResponse);
    }

   

}
