<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AuthenticationTest extends TestCase
{
  use RefreshDatabase;

  private User $user;

  public function setUp(): void
  {
    parent::setUp();
    $this->withoutMiddleware();
    $this->user = User::factory()->create();
  }

  /** @test ログインAPIテスト、正常系 */
  // TODO fortifyでAPI認証テストする方法を確認
  // public function users_can_authenticate_using_the_login_screen()
  // {
  //   $response = $this->json('POST','/api/login', [
  //     'email' => $this->user->email,
  //     'password' => 'password',
  //   ]);

  //   $this->assertAuthenticated();
  //   $response->assertRedirect(RouteServiceProvider::HOME);
  // }

  /** @test ログインAPIテスト、異常系 */
  public function test_users_can_not_authenticate_with_invalid_password()
  {
    $user = User::factory()->create();

    $response = $this->post('/api/login', [
      'email' => $this->user->email,
      'password' => 'wrong-password',
    ]);

    $this->assertGuest();
  }

  /**
   * api/user（ユーザーの取得）のテスト
   *
   * @return void
   */
  public function testApiUser()
  {
    $response = $this->actingAs($this->user, 'sanctum')->get('/api/user');

    $this->assertSame(
      [
        'id' => $this->user->id,
        'name' => $this->user->name,
        'email' => $this->user->email,
        'company' => $this->user->company,
        'createdAt' => Carbon::parse($this->user->created_at)->format('Y-m-d H:i:s'),
        'updatedAt' => Carbon::parse($this->user->updated_at)->format('Y-m-d H:i:s'),
        'isAdmin' => false
      ],
      $response->json()['data']
    );
  }
}
