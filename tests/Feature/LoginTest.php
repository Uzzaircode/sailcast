<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Sailcast\User;
use Tests\TestCase;

class LoginTest extends TestCase
{
    use RefreshDatabase;

    public function __construct()
    {

        $this->newUser = factory(User::class)->create();

    }

    /** @test */

    public function correct_response_returned_after_successful_login()
    {

        $this->postJson('/login', [

            'email' => $this->newUser->email,
            'password' => 'secret',

        ])
            ->assertStatus(200)
            ->assertJson([
                'status' => 'OK',
            ])
            ->assertSessionHas('success');

    }

    /** @test */

    public function user_will_receives_correct_message_upon_login_invalid_credentials()
    {

        $this->postJson('/login', [

            'email' => $this->newUser->email,
            'password' => 'wrongPassword',

        ])
            ->assertStatus(422)
            ->assertJson([
                'message' => 'These credentials do not match our records',
            ]);
    }

}
