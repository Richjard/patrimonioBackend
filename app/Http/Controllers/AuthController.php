<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login']]);
    }

    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {
        $credentials = ['cCredUsuario' => $request->usuario, 'password' => $request->password];

        if ($request->modulo) {
            if (! $this->verificarAccesoModulo($request->usuario, $request->modulo)) {
                return response()->json(['error' => 'Forbidden'], 403);
            }
        }

        if (! $token = auth()->attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $samePass = $this->checkIfSamePassword(auth()->user());
        
        return $this->respondWithToken($token, $samePass);
    }

    public function verificarAccesoModulo($credencial, $moduloId)
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
    }

    /**
     * Establece el atributo cCredUsuario como usuario
     *
     * @return string
     */
    public function username()
    {
        return 'cCredUsuario';
    }

    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function me()
    {
        return response()->json(auth()->user());
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        auth()->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        return $this->respondWithToken(auth()->refresh());
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token, $samePass)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60,
            'passSameToUser' => $samePass
        ]);
    }

    protected function checkIfSamePassword($user)
    {
        if ($user->password == hash('sha1', $user->cCredUsuario)) {//modificado prueba
       // if ($user->password == "patri") {
            return true;
        } else {
            return false;
        }
    }
}
