<?php
namespace App\Http\Controllers\Tre;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class grl_conceptos_importesController extends Controller{
    public function grl_conceptos_importes_select(Request $data){
        $ConcepImptId        = ($data->get("ConcepImptId") == "" ? 0 : $data->get("ConcepImptId"));
        $ConcepImptKey       = ($data->get("ConcepImptKey") == "" ? NULL : $data->get("ConcepImptKey"));
        $ConcepReqId         = $data->get("ConcepReqId");
        $ConcepReqNombrex    = ($data->get("ConcepReqNombrex") == "" ? NULL : $data->get("ConcepReqNombrex"));
        $ConcepReqNombrey    = ($data->get("ConcepReqNombrey") == "" ? NULL : $data->get("ConcepReqNombrey"));
        $DepenId             = $data->get("DepenId");
        $EspeDetId           = $data->get("EspeDetId");
        $PlanCtblId          = $data->get("PlanCtblId");
        $TipAproxImptId      = $data->get("TipAproxImptId");
        $ConcepReqOnlyEstud  = $data->get("ConcepReqOnlyEstud");
        $ConcepReqOnlyExter  = $data->get("ConcepReqOnlyExter");
        $ConcepReqkey        = ($data->get("ConcepReqkey") == "" ? NULL : $data->get("ConcepReqkey"));
        $ConcepId            = $data->get("ConcepId");
        $TipConcepReqId      = $data->get("TipConcepReqId");
        $ConcepReqParent     = $data->get("ConcepReqParent");
        $ConcepReqNombre     = $data->get("ConcepReqNombre");
        $ConcepReqCode       = $data->get("ConcepReqCode");
        $ConcepReqEstado     = $data->get("ConcepReqEstado");
        $Concepkey           = $data->get("Concepkey");
        $ConcepDepen         = $data->get("ConcepDepen");
        $DocGestId           = $data->get("DocGestId");
        $UniEjeId            = $data->get("UniEjeId");
        $TipDocGestId        = $data->get("TipDocGestId");
        $DocGestYear         = $data->get("DocGestYear");
        $Depenkey            = $data->get("Depenkey");
        $SessKey     = $data->get("SessKey");
        $MenuId      = $data->get("MenuId");
        $TypeRecord  = $data->get("TypeRecord"); 
        $TypeQuery   = $data->get("TypeQuery"); 
        $OrderBy     = $data->get("OrderBy");
        $RecordLimit = $data->get("RecordLimit");
        $RecordStart = $data->get("RecordStart");

        $_records = \DB::select('exec grl.[conceptos_importes_sp_select] ?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?', array($ConcepImptId,$ConcepImptKey,$ConcepReqId,$ConcepReqNombrex,$ConcepReqNombrey,$DepenId,$EspeDetId,$PlanCtblId,$TipAproxImptId,$ConcepReqOnlyEstud,$ConcepReqOnlyExter,$ConcepReqkey,$ConcepId,$TipConcepReqId,$ConcepReqParent,$ConcepReqNombre,$ConcepReqCode,$ConcepReqEstado,$Concepkey,$ConcepDepen,$DocGestId,$UniEjeId,$TipDocGestId,$DocGestYear,$Depenkey,$SessKey,$MenuId,$TypeRecord,$TypeQuery,$OrderBy,$RecordLimit,$RecordStart));
        return response()->json($_records);
    }
}