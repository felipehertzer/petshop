<?php

namespace Tests\Feature\Auth;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Auth;

class LoginControllerTest extends TestCase
{
    public function testRequireEmailAndLogin()
    {
        $this->json('POST', 'api/auth/login')
            ->assertStatus(422)
            ->assertJson([
                'error' => [
                    'email' => ['The email field is required.'],
                    'password' => ['The password field is required.']
                ]
            ]);

    }

    public function testUserLoginSuccessfully()
    {
        $user = ['email' => 'felipe@hertzer.com.br', 'password' => '123456'];
        $this->json('POST', 'api/auth/login', $user)
            ->assertStatus(200)
            ->assertJsonStructure([
                'success' => [
                    'token'
                ]
            ]);
    }
}
