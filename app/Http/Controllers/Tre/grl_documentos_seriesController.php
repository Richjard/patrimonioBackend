<?php
namespace App\Http\Controllers\Tre;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class grl_documentos_seriesController extends Controller{
    public function grl_documentos_series_select(Request $data){
        $DocSerId      = $data->get("DocSerId");
        $UniEjeId      = $data->get("UniEjeId");
        $FilId         = $data->get("FilId");
        $DocId         = $data->get("DocId");
        $YearId        = $data->get("YearId");
        $MesId         = $data->get("MesId");
        $DocSerSerie   = $data->get("DocSerSerie");
        $CredSessId    = $data->get("CredSessId");
        $SessKey     = $data->get("SessKey");
        $MenuId      = $data->get("MenuId");
        $TypeRecord  = $data->get("TypeRecord"); 
        $TypeQuery   = $data->get("TypeQuery"); 
        $OrderBy     = $data->get("OrderBy");
        $RecordLimit = $data->get("RecordLimit");
        $RecordStart = $data->get("RecordStart");
    
        $_records = \DB::select('exec grl.[documentos_series_sp_select] ?,?,?,?,?,?,?,?,?,?,?,?,?,?,?',
        array($DocSerId,$UniEjeId,$FilId,$DocId,$YearId,$MesId,$DocSerSerie,$CredSessId,$SessKey,$MenuId,$TypeRecord,$TypeQuery,$OrderBy,$RecordLimit,$RecordStart));
        return response()->json( $_records );
    }
}