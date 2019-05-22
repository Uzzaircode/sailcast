<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Mail;

class RegistrationTest extends TestCase
{
    /** @test */

    use RefreshDatabase;

    /** @test */

    public function guest_should_be_able_to_see_registration_page(){

        $this->get('register')->assertStatus(200)->assertSee('Register');

    }


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

    /**
     * @test
     */
    
     public function send_email_to_new_user_upon_registration(){


        Mail::fake();
        
        $this->post('register', [

            'name' => 'Uzzair Baharudin',
            'email' => 'uzzairwebstudio@gmail.com',
            
            'password' => 'secret'

        ])
        ->assertRedirect();


     }
}
