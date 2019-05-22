<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Sailcast\User;
use Tests\TestCase;

class LoginTest extends TestCase
{
    use RefreshDatabase;

    /** @test */

    public function correct_response_returned_after_successful_login()
    {
        $user = factory(User::class)->create();

        $this->postJson('/login', [

            'email' => $user->email,
            'password' => 'password',

        ])
            ->assertStatus(200)
            ->assertJson([
                'status' => 'ok',
            ])
            ->assertSessionHas('success', 'Logged in successfully');

    }

    /** @test */

    public function user_will_receives_correct_message_upon_login_invalid_credentials()
    {
        $user = factory(User::class)->create();

        $this->postJson('/login', [

            'email' => $user->email,
            'password' => 'wrongPassword',

        ])
            ->assertStatus(422)
            ->assertJson([
                'message' => 'These credentials do not match our records',
            ]);
    }

}
