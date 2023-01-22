<?php

namespace Tests\Feature\tests\app\Http\Controllers;

use App\Models\Retailer;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Symfony\Component\HttpFoundation\Request;
use Tests\TestCase;
use TheSeer\Tokenizer\Exception;

class AuthControllerTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_example()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }
    
    public function testUserShouldNotAuthenticateWrongProvider(){
        $payload = [
            'email' => 'picpay@outlook.com',
            'password' => 'picpay123',
        ];
        $request = $this->post(route('authenticate', ['provider' => 'deixa-o-sub']), $payload);
        $request->assertStatus(422);
        $request->assertJson(['errors' => ['main' => 'Wrong prodiver provided']], 422); 
    }
    public function testUserShouldBeDeniedIfNotRegistered(){ 
        $payload = [
            'email' => 'picpay@outlook.com',
            'password' => 'picpay123',
        ]; 
        $request = $this->post(route('authenticate', ['provider' => 'user']), $payload); 
        $request->assertStatus(401);
        $request->assertJson(['errors'=>['main'=>'Wrong credencials']]);
        
    }
     
}
