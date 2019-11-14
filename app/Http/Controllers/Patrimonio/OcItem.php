<?php

namespace App\Http\Controllers\Patrimonio;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class OcItem extends Controller
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
          $_SEC_EJE=1230; //UNAM 
          $_anio=2019; //UNAM 
         // $_oc=$request->ocnro; //UNAM 
          $_oc=$request->nrooc;;
          $order=$request->order;
          $value_filtro_CODIGO="";
          $order="";
          //if($request->order){$order=$request->order;}
          if($request->filter){                    
            for($i=0;$i<count($request->filter[0]['predicates']);$i++){              
              if($request->filter[0]['predicates'][$i]['field']=="CODIGO"){
                 $value_filtro_CODIGO=$request->filter[0]['predicates'][$i]['value'];
              }
            }

          }
          $datos = null;        
         $datos = \DB::connection('sqlsrvSiga')->select("EXEC dbo.SP_SIGEUN_PAT_SEL_OC_ITEM ?,?,?,?,?,?",array( $skip,$top,$_SEC_EJE, $_anio,$value_filtro_CODIGO,$_oc));


         $datos_items = null;  

          foreach ($datos as $d) {//recorremos y chekeamos si escompatible SIGEUN CON SIGA
        
          //CONSULTAMOS SI ESTA EN NUESTRA  BASE DE DATOS
            $b=0;
            $datos_catalogoSBN = \DB::select("EXEC pat.Sp_SEL_CatalogoSBN ?,?,?,?,?",array( 1,1,'',substr($d->CODIGO,0, 8),'')); 
            if($datos_catalogoSBN){$b=1;}
              $datos_items[]=array(    
                    'RowNumber'=>$d->RowNumber,   
                    'CODIGO'=>$d->CODIGO,
                    'NOMBRE_ITEM' =>$d->NOMBRE_ITEM,
                    'CANT_ITEM'=>$d->CANT_ITEM,
                    'PREC_UNIT_MONEDA' =>$d->PREC_UNIT_MONEDA,
                    'PREC_TOT_SOLES'=>$d->PREC_TOT_SOLES,
                    'b'=>$b          
                );
            }
           
         
          
     // print_r($datos)
         // $total=45;
          $total=\DB::connection('sqlsrvSiga')->select("EXEC dbo.SP_SIGEUN_PAT_COUNT_OC_ITEM ?,?,?,?",array($_SEC_EJE,$value_filtro_CODIGO, $_oc, $_anio));
          $data = [       
                    'filter'=> $value_filtro_CODIGO,              
                    'results' =>$datos_items,
                    'count' => $total[0]->iTotalRegistros
                                             
                  ];

       return response()->json($data);
        //  return $data;
       // return response()->"{\"result\":" .json($respuesta). ",\"count\":".$total."}";
    }

   




   

}
