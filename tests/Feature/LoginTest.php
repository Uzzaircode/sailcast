<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Sailcast\User;


class LoginTest extends TestCase
{
    use RefreshDatabase;

    
    
    public function test_user_will_receives_correct_message_upon_login_invalid_credentials(){

        $user = factory(User::class)->create();

        $this->postJson('/login',[

            'email' => $user->email,
            'password' => 'wrongPassword'

        ])
        ->assertStatus(422)
        ->assertJson([
            'message' => 'These credentials do not match our records'
        ]);
    }

}
