<?php
namespace App\Http\Controllers\Tre;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class grl_filialesController extends Controller{
    public function grl_filiales_select(Request $data){
        $FilId         = $data->get("FilId");
        $FilKey        = $data->get("FilKey");
        $UniEjeId      = $data->get("UniEjeId");
        $FilPrincipal  = $data->get("FilPrincipal");
        $FilNombre     = $data->get("FilNombre");
        $FilAbrev      = $data->get("FilAbrev");
        $FilSigla      = $data->get("FilSigla");
        $PaisId        = $data->get("PaisId");
        $DptoId        = $data->get("DptoId");
        $PrvnId        = $data->get("PrvnId");
        $DsttId        = $data->get("DsttId");
        $SessKey     = $data->get("SessKey");
        $MenuId      = $data->get("MenuId");
        $TypeRecord  = $data->get("TypeRecord"); 
        $TypeQuery   = $data->get("TypeQuery"); 
        $OrderBy     = $data->get("OrderBy");
        $RecordLimit = $data->get("RecordLimit");
        $RecordStart = $data->get("RecordStart");

        $_records = \DB::select('exec grl.[filiales_sp_select] ?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?',array($FilId,$FilKey,$UniEjeId,$FilPrincipal,$FilNombre,$FilAbrev,$FilSigla,$PaisId,$DptoId,$PrvnId,$DsttId,$SessKey,$MenuId,$TypeRecord,$TypeQuery,$OrderBy,$RecordLimit,$RecordStart));
        return response()->json($_records);
    }
}