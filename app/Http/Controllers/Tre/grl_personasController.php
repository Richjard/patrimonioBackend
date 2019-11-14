<?php
namespace App\Http\Controllers\Tre;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class grl_personasController extends Controller{
    public function grl_personas_select(Request $data){
        $PersId                = $data->get("iPersId");
        $TipoPersId            = $data->get("TipoPersId");
        $TipoIdentId           = $data->get("TipoIdentId");
        $PersDocumento         = $data->get("PersDocumento");
        $PersPaterno           = $data->get("PersPaterno");
        $PersMaterno           = $data->get("PersMaterno");
        $PersNombre            = $data->get("PersNombre");
        $PersNacimiento        = $data->get("TabMixEstado");
        $TipSexId              = $data->get("TipSexId");
        $TipEstaCivId          = $data->get("TipEstaCivId");
        $PersRazonSocialNombre = $data->get("PersRazonSocialNombre");
        $PersRazonSocialCorto  = $data->get("PersRazonSocialCorto");
        $PersApeNom            = $data->get("PersApeNom");
        $SessKey     = $data->get("SessKey");
        $MenuId      = $data->get("MenuId");
        $TypeRecord  = $data->get("TypeRecord"); 
        $TypeQuery   = $data->get("TypeQuery"); 
        $OrderBy     = $data->get("OrderBy");
        $RecordLimit = $data->get("RecordLimit");
        $RecordStart = $data->get("RecordStart");

        $_records = \DB::select('exec grl.[personas_sp_select] ?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?',array($PersId,$TipoPersId,$TipoIdentId,$PersDocumento,$PersPaterno,$PersMaterno,$PersNombre,$PersNacimiento,$TipSexId,$TipEstaCivId,$PersRazonSocialNombre,$PersRazonSocialCorto,$PersApeNom,$SessKey,$MenuId,$TypeRecord,$TypeQuery,$OrderBy,$RecordLimit,$RecordStart));
        return response()->json($_records);
    }

    public function grl_personas_update(Request $data){
        $TypeEdit      = ($data->get("PersId")*1 > 0 ? 2 : 1);
        $PersId        = $data->get("PersId");
        $PersKey       = $data->get("PersKey");
        $TipoPersId    = $data->get("TipoPersId");
        $TipoIdentId   = $data->get("TipoIdentId");
        $PersDocumento = $data->get("PersDocumento");
        $PersPaterno   = $data->get("PersPaterno");
        $PersMaterno   = $data->get("PersMaterno");
        $PersNombre    = $data->get("PersNombre");
        $PersSexo      = $data->get("PersSexo");
        $SessKey = $data->get("SessKey");
        $MenuId  = $data->get("MenuId");

        $_id = \DB::select('exec grl.[personas_sp_update] ?,?,?,?,?,?,?,?,?,?,?,?',array($TypeEdit,$PersId,$PersKey,$TipoPersId,$TipoIdentId,$PersDocumento,$PersPaterno,$PersMaterno,$PersNombre,$PersSexo,$SessKey,$MenuId));
        return $_id;
    }
}