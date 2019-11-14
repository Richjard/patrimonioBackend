<?php

namespace App\Http\Controllers\Patrimonio;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class LoginAndroid extends Controller
{
    /**
     * 
     * 
     * @return \Illuminate\Http\JsonResponse
     */

    //public function getResult($skip,$top,$inlinecount,$format){
  /*  public function login(){
  //Get the input request parameters
          $inputJSON = file_get_contents('php://input');
          $input = json_decode($inputJSON, TRUE); //convert JSON into array
          $username = $input['username'];
          $password = $input['password'];
          $data=array('username'=>$username,'password'=>$password);
          $userResponse = $this->md_l->processLoginAndroid($data);
          if($userResponse){
                 $response["status"] = 0;
                 $response["message"] = "Inicio de sesión correcto";
                 $response["full_name"] = $userResponse->cNombres." ".$userResponse->cApellido1;
          }else{
              $response["status"] = 1;
              $response["message"] = "usuario o contraseña invalido ";
          } 
          echo  json_encode($response);


    }*/


  public function login(Request $request)
    {


       //if($userResponse){
                 $response["status"] = 0;
                 $response["message"] = "Inicio de sesión correcto XDDDDDDDDD";
                // $response["full_name"] = $userResponse->cNombres." ".$userResponse->cApellido1;
        //  }else{
        //      $response["status"] = 1;
         //     $response["message"] = "usuario o contraseña invalido ";
        //  } 
          echo  json_encode($response);

       /* $credentials = ['cCredUsuario' => $request->usuario, 'password' => $request->password];

        if ($request->modulo) {
            if (! $this->verificarAccesoModulo($request->usuario, $request->modulo)) {
                return response()->json(['error' => 'Forbidden'], 403);
            }
        }

        if (! $token = auth()->attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $samePass = $this->checkIfSamePassword(auth()->user());
        
        return $this->respondWithToken($token, $samePass);/
    }

   /* public function verificarAccesoModulo($credencial, $moduloId)
    {
        $modulos = \DB::select('exec [seg].[Sp_SEL_modulos_credencial] ?', array( $credencial ));

        $access = false;
        foreach ($modulos as $modulo) {
            if ($modulo->iModuloId == $moduloId) {
                $access = true;
                break;
            }
        }
        return $access;
    }*/

   

}
}
