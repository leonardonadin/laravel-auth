<?php

namespace Tests\Feature\Auth;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class LoginTest extends TestCase
{
    use RefreshDatabase;

    private $user_verified;
    private $user_not_verified;

    private function createUser($attributes = [])
    {
        return \App\Models\User::factory()->create($attributes);
    }

    public function test_when_visit_login_page_then_can_see_login_page()
    {
        $response = $this->get('/login');

        $response->assertStatus(200);
    }

    public function test_when_visit_login_page_then_can_see_login_form()
    {
        $response = $this->get('/login');

        $response->assertSee('Login');
        $response->assertSee('E-mail');
        $response->assertSee('Senha');
    }

    public function test_when_login_with_valid_data_then_can_see_dashboard_page()
    {
        $user = $this->createUser([
            'password' => Hash::make('Password!123')
        ]);

        $response = $this->post('/login', [
            'login' => $user->email,
            'password' => 'Password!123',
        ]);

        $response->assertStatus(302);
        $response->assertRedirect('/app');

        $this->assertAuthenticated();
    }

    public function test_when_login_with_invalid_data_then_cannot_see_dashboard_page()
    {
        $user = $this->createUser([
            'password' => Hash::make('Password!123')
        ]);

        $response = $this->post('/login', [
            'login' => $user->email,
            'password' => 'password',
        ]);

        $response->assertStatus(302);
        $response->assertRedirect('/login');
        $response->assertSessionHasErrors('email');

        $this->assertGuest();
    }

    public function test_when_login_with_user_not_verified_then_cannot_see_dashboard_page()
    {
        $user = $this->createUser([
            'password' => Hash::make('Password!123'),
            'email_verified_at' => null,
        ]);

        $response = $this->post('/login', [
            'login' => $user->email,
            'password' => 'Password!123',
        ]);

        $response->assertStatus(302);
        $response->assertRedirect('/verify-email?email=' . urlencode($user->email));

        $this->assertGuest();
    }
}
