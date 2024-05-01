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
        $response = $this->get('/register');

        $response->assertStatus(200);
    }

    public function test_when_visit_register_page_then_can_see_register_form()
    {
        $response = $this->get('/register');

        $response->assertSee('Cadastr');
        $response->assertSee('Nome');
        $response->assertSee('E-mail');
        $response->assertSee('Senha');
    }

    public function test_when_register_with_valid_data_then_can_see_verify_email_page()
    {
        $response = $this->post('/register', [
            'name' => 'John Doe',
            'email' => 'email@email.com',
            'phone' => '1234567890',
            'password' => 'Password!123',
            'password_confirmation' => 'Password!123',
            'accepted_terms' => 'on',
        ]);

        $response->assertStatus(302);
        $response->assertRedirect('/verify-email?email=email%40email.com');

        $this->assertDatabaseHas('users', [
            'name' => 'John Doe',
            'email' => 'email@email.com',
            'phone' => '1234567890',
        ]);
    }

    public function test_when_has_user_registered_with_email_then_cannot_register_with_same_email()
    {
        $user_registered = \App\Models\User::factory()->create();

        $response = $this->post('/register', [
            'name' => 'John Tester',
            'email' => $user_registered->email,
            'phone' => '1234567890',
            'password' => 'Password!123',
            'password_confirmation' => 'Password!123',
        ]);

        $response->assertStatus(302);
        $response->assertSessionHasErrors('email');

        $this->assertDatabaseMissing('users', [
            'name' => 'John Tester',
            'email' => $user_registered->email,
            'phone' => '1234567890',
        ]);
    }

    public function test_when_register_with_blank_name_then_cannot_register()
    {
        $response = $this->post('/register', [
            'name' => '',
            'email' => 'email@email.com',
            'phone' => '1234567890',
            'password' => 'Password!123',
            'password_confirmation' => 'Password!123',
        ]);

        $response->assertStatus(302);
        $response->assertSessionHasErrors('name');

        $this->assertDatabaseMissing('users', [
            'email' => 'email@email.com'
        ]);
    }
}
