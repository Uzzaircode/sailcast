<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class RegistrationTest extends TestCase
{
    /** @test */

    use RefreshDatabase;

    public function generate_username_upon_registration(){


        $this->post('register', [

            'name' => 'Uzzair Baharudin',
            'email' => 'uzzairwebstudio@gmail.com',
            
            'password' => 'secret'

        ])
        ->assertRedirect();

        $this->assertDatabaseHas('users',[
            
            'username' => str_slug('Uzzair Baharudin')
        ]);
    }
}
