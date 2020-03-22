<?php

namespace Tests\Feature\Auth;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class RegisterControllerTest extends TestCase
{
    public function testRegisterSuccessfully()
    {
        $register = [
            'name' => 'Hertzer',
            'email' => 'hertzer@hertzer.com.br',
            'password' => '123456',
            'c_password' => '123456'
        ];

        $this->json('POST', 'api/auth/register', $register)
            ->assertStatus(200)
            ->assertJsonStructure([
                'success' => [
                    'token',
                ]
            ]);
    }

    public function testRequireNameEmailAndPassword()
    {
        $this->json('POST', 'api/auth/register')
            ->assertStatus(422)
            ->assertJson([
                'error' => [
                    'name' => ['The name field is required.'],
                    'email' => ['The email field is required.'],
                    'password' => ['The password field is required.'],
                    'c_password' => ['The c password field is required.'],
                ]
            ]);
    }

    public function testRequirePasswordConfirmation()
    {
        $register = [
            'name' => 'hertzer',
            'email' => 'hertzer@hertzer.com.br',
            'password' => '123456',
            'c_password' => '1'
        ];

        $this->json('POST', 'api/auth/register', $register)
            ->assertStatus(422)
            ->assertJson([
                'error' => [
                    'c_password' => ['The c password and password must match.']
                ]
            ]);
    }
}
