<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AuthenticationTest extends TestCase
{
  use RefreshDatabase;

  /** @test ログインAPIテスト、正常系 */
  public function users_can_authenticate_using_the_login_screen()
  {
    $user = User::factory()->create();

    $response = $this->post('/api/login', [
      'email' => $user->email,
      'password' => 'password',
    ]);

    $this->assertAuthenticated();
    $response->assertRedirect(RouteServiceProvider::HOME);
  }

  /** @test ログインAPIテスト、異常系 */
  public function test_users_can_not_authenticate_with_invalid_password()
  {
    $user = User::factory()->create();

    $this->post('/api/login', [
      'email' => $user->email,
      'password' => 'wrong-password',
    ]);

    $this->assertGuest();
  }
}
