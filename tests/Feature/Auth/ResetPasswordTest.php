<?php

namespace Tests\Feature\Auth;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Password;
use Tests\TestCase;

class ResetPasswordTest extends TestCase
{
    use RefreshDatabase;

    private $user;
    private $token;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = \App\Models\User::factory()->create();
        $this->token = Password::createToken($this->user);
    }

    public function test_when_user_visit_reset_password_page_then_can_see_reset_password_page()
    {
        $response = $this->get('/site/reset-password/' . $this->token);

        $response->assertStatus(200);
    }

    public function test_when_user_visit_reset_password_page_then_can_see_reset_password_form()
    {
        $response = $this->get('/site/reset-password/' . $this->token);

        $response->assertSee('Redefinir senha');
        $response->assertSee('E-mail');
        $response->assertSee('Senha');
    }

    public function test_when_user_send_reset_password_request_with_valid_data_then_can_see_login_page()
    {
        $response = $this->post('/site/reset-password/' . $this->token, [
            'email' => $this->user->email,
            'password' => 'Password!123',
            'password_confirmation' => 'Password!123'
        ]);

        $response->assertStatus(302);
        $response->assertRedirect('/site/login');

        $this->assertDatabaseMissing('password_reset_tokens', [
            'email' => $this->user->email,
        ]);
    }
}
