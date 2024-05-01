<?php

namespace Tests\Feature\Auth;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserVerifyTest extends TestCase
{
    use RefreshDatabase;

    private $user;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = \App\Models\User::factory()->create([
            'email_verified_at' => null
        ]);
    }

    public function test_when_user_visit_verify_email_page_then_can_see_verify_email_page()
    {
        $response = $this->get('/verify-email?email=' . $this->user->email);

        $response->assertStatus(200);
    }

    public function test_when_user_visit_verify_email_page_then_can_see_verify_email_form()
    {
        $response = $this->get('/verify-email?email=' . $this->user->email);

        $response->assertSee('Verificar e-mail');
        $response->assertSee('Token');
    }

    public function test_when_user_send_verify_email_request_with_valid_data_then_can_see_login_page()
    {
        $userVerify = \App\Models\UserVerify::factory()->create([
            'email' => $this->user->email
        ]);

        $response = $this->post('/verify-email', [
            'email' => $this->user->email,
            'token' => $userVerify->token,
        ]);

        $response->assertStatus(302);
        $response->assertRedirect('/login');

        $this->assertDatabaseHas('users', [
            'email' => $this->user->email,
            'email_verified_at' => now(),
        ]);
    }

    public function test_when_user_send_verify_email_request_with_invalid_data_then_cannot_see_login_page()
    {
        $user = \App\Models\User::factory()->create([
            'email_verified_at' => null
        ]);

        $response = $this->post('/verify-email', [
            'email' => $user->email,
            'token' => 'invalid-token',
        ]);

        $response->assertStatus(302);
        $response->assertSessionHasAll([
            'success' => __('auth.verify_email_sent'),
        ]);

        $this->assertDatabaseHas('users', [
            'email' => $user->email,
            'email_verified_at' => null,
        ]);
    }
}
