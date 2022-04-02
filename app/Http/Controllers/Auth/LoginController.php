<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;


class LoginController extends Controller
{
   public function login(Request $request)
   {
       $cEmail = $request->cEmail;
       $cContraseña = $request->cContraseña;
       $rspt = Auth::attempt(['email' => $cEmail, 'password' => $cContraseña, 'state' => 'A']);

       if ($rspt) {
           return response()->json([
                'authUser' => Auth::user(),
                'code' => 200
           ]);
       }else{
           return response()->json([
            'code' => 401
           ]);
       } 
   }

   public function logout(Request $request)
   {
        Auth::logout();
        return response()->json([
            'code' => 204
           ]);
   }
}
