<?php

namespace App\Http\Controllers;

use App\Models\Retailer;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use TheSeer\Tokenizer\Exception;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContractsContract;

class AuthController extends Controller
{
    public function postAuthentication(string $provider, Request $request)
    {
        $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required',
        ]);
        $providers = ['user', 'retailer'];
        if (!in_array($provider, $providers)) {
            return response()->json(['errors' => ['main' => 'Wrong prodiver provided']], 422);
        }
        $selectProvider = $this->getProvider($provider);
        $model = $selectProvider->where('email', '=', $request->input('email'))->first();
        if (!$model) {
            return response()->json(['errors' => ['main' => 'Wrong credencials']], 401);
        }
        if (!Hash::check($request->input('password'), $model->password)) {
            return response()->json(['errors' => ['main' => 'Wrong credencials']], 401);
        }
        $token = $model->createToken($selectProvider);
        return response()->json([
            'access_token' => $token->accessToken,
            'expires_at' => $token->token->expires_at,
            'provider' => $provider,
        ]);
    }



    public function getProvider(string $provider): AuthenticatableContractsContract
    {
        if ($provider == 'user') {
            return new User();
        } else if ($provider == 'retailer') {
            return new Retailer();
        } else {
            throw new Exception('Provider not found');
        }
    }
}