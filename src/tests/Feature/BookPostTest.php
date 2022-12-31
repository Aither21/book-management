<?php

namespace Tests\Feature;

use App\Enums\UserType;
use App\Models\Book;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BookPostTest extends TestCase
{
    use RefreshDatabase;

    private User $user;

    private User $adminUser;

    public function setUp(): void
    {
        parent::setUp();
        $this->withoutMiddleware();
        $this->user = User::factory()->create();
        $this->adminUser = User::factory()->create(['is_admin' => UserType::ADMIN->value]);
    }

    /**
     * 図書新規作成
     *
     * @return void
     */
    public function testGenerateBook()
    {
        $request = [
            'name' => 'this world',
            'author' => 'sirotan',
            'company' => 'google',
        ];
        $response = $this->actingAs(
            $this->adminUser,
            'sanctum'
        )->post(
            '/api/v1/book',
            $request
        );
        $response->assertStatus(204);
        $this->assertDatabaseHas(
            Book::class,
            [
                'name' => $request['name'],
                'author' => $request['author'],
                'company' => $request['company']
            ]
        );
    }

    /**
     * 管理者でない場合,403
     *
     * @return void
     */
    public function testNotAdminUser()
    {
        $request = [
            'name' => 'this world',
            'author' => 'sirotan',
            'company' => 'google',
        ];
        $response = $this->actingAs(
            $this->user,
            'sanctum'
        )->post(
            '/api/v1/book',
            $request
        );
        $response->assertStatus(403);
        $this->assertSame(
            ['message' => '権限がありません。'],
            $response->json()
        );
    }

    /**
     * リクエストエラー
     *
     * @dataProvider dataProviderParam
     * @return void
     */
    public function testRequest422(array $param)
    {
        $baseParam = [
            'name' => 'this world',
            'author' => 'sirotan',
            'company' => 'google',
        ];
        $requestParam = array_replace($baseParam, $param);
        $response = $this->actingAs(
            $this->user,
            'sanctum'
        )->json(
            'POST',
            '/api/v1/book',
            $requestParam
        );
        $response->assertStatus(422);
    }

    /**
     * @return iterable
     */
    public function dataProviderParam(): iterable
    {
        yield 'データが無い' => [
            [
                'name' => '',
                'author' => '',
                'company' => ''
            ]
        ];
        yield 'nameが151文字以上' => [
            [
                'name' => str_repeat('a', 151)
            ]
        ];
        yield 'nameが51文字以上(日本語)' => [
            [
                'name' => str_repeat('あ', 51)
            ]
        ];
        yield 'nameがbool' => [
            [
                'name' => false
            ]
        ];
        yield 'nameがnull' => [
            [
                'name' => null
            ]
        ];
        yield 'authorが100文字以上' => [
            [
                'author' => str_repeat('a', 101)
            ]
        ];
        yield 'authorが30文字以上(日本語)' => [
            [
                'author' => str_repeat('あ', 31)
            ]
        ];
        yield 'authorがbool' => [
            [
                'author' => false
            ]
        ];
        yield 'authorがnull' => [
            [
                'author' => null
            ]
        ];
        yield 'companyが10文字以上' => [
            [
                'company' => str_repeat('a', 11)
            ]
        ];
        yield 'companyが10文字(日本語)' => [
            [
                'company' => str_repeat('あ', 11)
            ]
        ];
        yield 'companyがbool' => [
            [
                'company' => false
            ]
        ];
        yield 'companyがnull' => [
            [
                'company' => null
            ]
        ];
    }
}
