<?php

namespace Tests\Feature\Auth;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ForgotPasswordTest extends TestCase
{
    use RefreshDatabase;

    public function test_when_user_visit_forgot_password_page_then_can_see_forgot_password_page()
    {
        $response = $this->get('/site/forgot-password');

        $response->assertStatus(200);
    }

    public function test_when_user_visit_forgot_password_page_then_can_see_forgot_password_form()
    {
        $response = $this->get('/site/forgot-password');

        $response->assertSee('Esqueceu sua senha?');
        $response->assertSee('E-mail');
    }

    public function test_when_user_send_forgot_password_request_with_valid_data_then_can_see_forgot_password_page()
    {
        $user = \App\Models\User::factory()->create();

        $response = $this->post('/site/forgot-password', [
            'email' => $user->email,
        ]);

        $response->assertStatus(302);
        $response->assertRedirect('/site/forgot-password');

        $this->assertDatabaseHas('password_reset_tokens', [
            'email' => $user->email,
        ]);
    }

    public function test_when_user_send_forgot_password_request_with_invalid_data_then_cannot_see_forgot_password_page()
    {
        $response = $this->post('/site/forgot-password', [
            'email' => 'invalid-email',
        ]);

        $response->assertStatus(302);
        $response->assertSessionHasErrors('email');
    }
}
