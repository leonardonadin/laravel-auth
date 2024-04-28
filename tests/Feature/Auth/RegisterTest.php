<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class RegisterTest extends TestCase
{
    use RefreshDatabase;

    public function test_when_visit_register_page_then_can_see_register_page()
    {
        $response = $this->get('/site/register');

        $response->assertStatus(200);
    }

    public function test_when_visit_register_page_then_can_see_register_form()
    {
        $response = $this->get('/site/register');

        $response->assertSee('Registre');
        $response->assertSee('Nome');
        $response->assertSee('E-mail');
        $response->assertSee('Senha');
    }

    public function test_when_register_with_valid_data_then_can_see_verify_email_page()
    {
        $response = $this->post('/site/register', [
            'name' => 'John Doe',
            'email' => 'email@email.com',
            'phone' => '1234567890',
            'password' => 'Password!123',
            'password_confirmation' => 'Password!123',
        ]);

        $response->assertStatus(302);
        $response->assertRedirect('/site/verify-email?email=email%40email.com');

        $this->assertDatabaseHas('users', [
            'name' => 'John Doe',
            'email' => 'email@email.com',
            'phone' => '1234567890',
        ]);
    }
}
