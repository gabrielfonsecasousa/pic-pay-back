<?php

namespace Tests\Feature\tests\app\Http\Controllers;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AuthControllerTest extends TestCase
{
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
        $request = $this->post(route('authenticate', ['provider' => 'deixa-o-sub']));
        $request->assertStatus(422); 
        $request->assertJson(['errors' => ['main' => 'Wrong prodiver provided']], 422); 
    }
}
