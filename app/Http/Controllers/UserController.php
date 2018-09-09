<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

/**
 * Class UserController
 * @package App\Http\Controllers
 */
class UserController extends Controller {

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function authenticate(Request $request) {

        $this->validate($request, [
            'email' => 'required',
            'password' => 'required'
        ]);

        $user = User::where('email', $request->input('email'))->first();

        if (Hash::check($request->input('password'), $user->password)) {
            $apikey = base64_encode(str_random(40));
            User::where('email', $request->input('email'))->update(['api_key' => "$apikey"]);

            return response()->json(['api_key' => $apikey]);
        } else {

            return response()->json(['status' => 'fail'], 401);
        }
    }

    /**
     * Return the account information of the authenticated user
     * @return \Illuminate\Http\JsonResponse
     */
    public function account() {
        $user = Auth::user();
        
        if (!is_null($user)) {
            return response()->json($user);
        } else {                
             return response()->json(['status' => 'fail'], 401);
        }
    }

}
