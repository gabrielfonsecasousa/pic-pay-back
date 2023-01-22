<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function postAuthentication(string $provider){ 
        $providers = ['users','retailer'];
        if(!in_array($provider,$providers)){
            return response()->json(['errors' => ['main' => 'Wrong prodiver provided']], 422);
        }
        return 'o provider escolhido foi' . $provider;
    }
}
