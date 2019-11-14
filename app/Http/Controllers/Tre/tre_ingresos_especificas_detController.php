<?php
namespace App\Http\Controllers\Tre;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class tre_ingresos_especificas_detController extends Controller{
    public function tre_ingresos_especificas_det_select(Request $data){
        $IngEspeDetId     = $data->get("IngEspeDetId");
        $IngEspeDetKey    = $data->get("IngEspeDetKey");
        $UniEjeId         = $data->get("UniEjeId");
        $EspeDetId        = $data->get("EspeDetId");
        $EspeDetNombre    = $data->get("EspeDetNombre");
        $EspeDetCodigo    = $data->get("EspeDetCodigo");
        $EspeDetSiaf      = $data->get("EspeDetSiaf");
        $SessKey          = $data->get("SessKey");
        $MenuId           = $data->get("MenuId");
        $TypeRecord       = $data->get("TypeRecord"); 
        $TypeQuery        = $data->get("TypeQuery"); 
        $OrderBy          = $data->get("OrderBy");
        $RecordLimit      = $data->get("RecordLimit");
        $RecordStart      = $data->get("RecordStart");

        $_records = \DB::select('exec tre.[ingresos_especificas_det_sp_select] ?,?,?,?,?,?,?,?,?,?,?,?,?,?',array($IngEspeDetId,$IngEspeDetKey,$UniEjeId,$EspeDetId,$EspeDetNombre,$EspeDetCodigo,$EspeDetSiaf,$SessKey,$MenuId,$TypeRecord,$TypeQuery,$OrderBy,$RecordLimit,$RecordStart));
        return response()->json( $_records );
    }
}