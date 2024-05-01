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
        $response = $this->get('/forgot-password');

        $response->assertStatus(200);
    }

    public function test_when_user_visit_forgot_password_page_then_can_see_forgot_password_form()
    {
        $response = $this->get('/forgot-password');

        $response->assertSee('Recuperar senha');
        $response->assertSee('E-mail');
    }

    public function test_when_user_send_forgot_password_request_with_valid_data_then_can_see_forgot_password_page()
    {
        $user = \App\Models\User::factory()->create();

        $response = $this->post('/forgot-password', [
            'login' => $user->email,
        ]);

        $response->assertStatus(302);
        $response->assertRedirect('/forgot-password');

        $this->assertDatabaseHas('password_reset_tokens', [
            'email' => $user->email,
        ]);
    }

    public function test_when_user_send_forgot_password_request_with_invalid_data_then_can_see_forgot_password_page()
    {
        $response = $this->post('/forgot-password', [
            'login' => 'invalid-email',
        ]);

        $response->assertStatus(302);
        $response->assertSessionHasAll([
            'success' => __('auth.password_reset_link_sent'),
        ]);
    }
}
