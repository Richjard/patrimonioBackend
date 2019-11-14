<?php
namespace App\Http\Controllers\Tre;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class grl_tablas_mixtasController extends Controller{
    public function grl_tablas_mixtas_select(Request $data){
        $TabMixId       = $data->get("TabMixId");
        $UniEjeId       = $data->get("UniEjeId");
        $TabMixType     = $data->get("TabMixType");
        $Tablex         = $data->get("Tablex");
        $TablexId       = $data->get("TablexId");
        $Tabley         = $data->get("Tabley");
        $TableyId       = $data->get("TableyId");
        $TabMixEstado   = $data->get("TabMixEstado");
        $TabMixKey      = $data->get("TabMixKey");
        $UniEjeKey      = $data->get("UniEjeKey");
        $TablexKey      = $data->get("TablexKey");
        $TableyKey      = $data->get("TableyKey");
        $SessKey        = $data->get("SessKey");
        $MenuId         = $data->get("MenuId");
        $TypeRecord     = $data->get("TypeRecord"); 
        $TypeQuery      = $data->get("TypeQuery"); 
        $OrderBy        = $data->get("OrderBy");
        $RecordLimit    = $data->get("RecordLimit");
        $RecordStart    = $data->get("RecordStart");

        $_records = \DB::select('exec grl.[tablas_mixtas_sp_select] ?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?',array($TabMixId,$UniEjeId,$TabMixType,$Tablex,$TablexId,$Tabley,$TableyId,$TabMixEstado,$TabMixKey,$UniEjeKey,$TablexKey,$TableyKey,$SessKey,$MenuId,$TypeRecord,$TypeQuery,$OrderBy,$RecordLimit,$RecordStart));
        return response()->json($_records);
    }
}