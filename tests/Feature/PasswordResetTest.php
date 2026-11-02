<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class PasswordResetTest extends TestCase
{
    use DatabaseTransactions;

    public function test_user_can_request_a_password_reset_and_set_a_new_password(): void
    {
        Notification::fake();

        $user = User::create([
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'password' => 'old-password',
        ]);

        $this->post(route('password.email'), [
            'email' => $user->email,
        ])->assertRedirect()
            ->assertSessionHas('status');

        Notification::assertSentTo($user, ResetPassword::class);

        $notification = Notification::sent($user, ResetPassword::class)->first();

        $this->get(route('password.reset', [
            'token' => $notification->token,
            'email' => $user->email,
        ]))->assertOk()
            ->assertSee('Atur Ulang Password');

        $this->post(route('password.update'), [
            'token' => $notification->token,
            'email' => $user->email,
            'password' => 'new-password',
            'password_confirmation' => 'new-password',
        ])->assertRedirect(route('login'))
            ->assertSessionHas('status');

        $this->assertTrue(Hash::check('new-password', $user->fresh()->password));
        $this->assertDatabaseMissing('password_resets', ['email' => $user->email]);
    }

    public function test_reset_link_request_does_not_disclose_unknown_email_addresses(): void
    {
        $this->post(route('password.email'), [
            'email' => 'unknown@example.com',
        ])->assertRedirect()
            ->assertSessionHas('status');
    }
}
