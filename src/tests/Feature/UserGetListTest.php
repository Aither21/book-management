<?php

namespace Tests\Feature;

use App\Enums\UserType;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserGetListTest extends TestCase
{
    use RefreshDatabase;

    private User $adminUser;

    public function setUp(): void
    {
        parent::setUp();
        $this->withoutMiddleware();
        $this->adminUser = User::factory()->create(['is_admin' => UserType::ADMIN->value]);
    }

    /**
     * ユーザー一覧取得API、正常系
     *
     * @return void
     */
    public function testGetUsers()
    {
        User::factory(100)->create();

        $response = $this->actingAs($this->adminUser, 'sanctum')->json(
            'GET',
            '/api/v1/users'
        )->assertOk();

        // 100件分のユーザーレコード取得
        $this->assertCount(100, $response->json()['data']);
    }
}
