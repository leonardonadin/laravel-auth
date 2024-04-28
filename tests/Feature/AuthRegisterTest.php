<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AuthRegisterTest extends TestCase
{
    use RefreshDatabase;

    public function test_when_visit_register_page_then_can_see_register_page()
    {
        $response = $this->get('/register');

        $response->assertStatus(200);
    }

    public function test_when_visit_register_page_then_can_see_register_form()
    {
        $response = $this->get('/register');

        $response->assertSee('Register');
        $response->assertSee('Name');
        $response->assertSee('Email');
        $response->assertSee('Password');
        $response->assertSee('Confirm Password');
        $response->assertSee('Register');
    }

    public function test_when_register_with_valid_data_then_can_see_verify_email_page()
    {
        $response = $this->post('/register', [
            'name' => 'John Doe',
            'email' => 'email@email.com',
            'phone' => '1234567890',
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);

        $response->assertStatus(200);
        $response->assertSee('Verify Email');
        $response->assertSee('We have sent you an email with a verification link.');

        $this->assertDatabaseHas('users', [
            'name' => 'John Doe',
            'email' => 'email@email.com',
            'phone' => '1234567890',
        ]);
    }
}
