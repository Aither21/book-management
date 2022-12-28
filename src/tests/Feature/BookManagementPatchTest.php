<?php

namespace Tests\Feature;

use App\Enums\BookManagementStatusType;
use App\Enums\UserType;
use App\Models\Book;
use App\Models\BookManagement;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BookManagementPatchTest extends TestCase
{
    use RefreshDatabase;

    private User $user;
    private User $adminUser;
    private Book $book;
    private BookManagement $bookManagement;

    public function setUp(): void
    {
        parent::setUp();
        $this->withoutMiddleware();
        $this->user = User::factory()->create();
        $this->adminUser = User::factory()->create(['is_admin' => UserType::ADMIN]);
        $this->book = Book::factory()->create();
        $this->bookManagement = BookManagement::factory()->create([
            'user_id' => $this->user->id,
            'book_id' => $this->book->id
        ]);
    }

    /**
     * 図書返却申請中を返却完了にステータスを更新する
     *
     * @return void
     */
    public function testUpdateBookManagementStatus()
    {
        $response = $this->actingAs(
            $this->adminUser,
            'sanctum'
        )->patch(
            '/api/v1/book-management/' . $this->book->id,
            [
                'status' => BookManagementStatusType::APPLYING_RETURN->value,
                'userId' => $this->user->id
            ]
        );
        $response->assertStatus(204);
        $this->assertDatabaseHas(
            BookManagement::class,
            [
                'user_id' => $this->bookManagement->user_id,
                'book_id' => $this->bookManagement->book_id,
                'status' => BookManagementStatusType::COMPLETE
            ]
        );
    }

    /**
     * 管理者でない場合
     *
     * @return void
     */
    public function testNotAdminUser()
    {
        $response = $this->actingAs(
            $this->user,
            'sanctum'
        )->patch(
            '/api/v1/book-management/' . $this->book->id,
            [
                'status' => BookManagementStatusType::APPLYING_RETURN->value,
                'userId' => $this->user->id
            ]
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
            'status' => BookManagementStatusType::APPLYING_RETURN->value,
            'userId' => $this->user->id
        ];
        $requestParam = array_replace($baseParam, $param);
        $response = $this->actingAs(
            $this->user,
            'sanctum'
        )->json(
            'PATCH',
            '/api/v1/book-management/' . $this->book->id,
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
                'status' => '',
                'userId' => ''
            ]
        ];
        yield 'statusが返却申請中以外' => [
            [
                'status' => BookManagementStatusType::IN_RENTAL->value
            ]
        ];
        yield 'statusが文字列' => [
            [
                'status' => 'しろたん'
            ]
        ];
        yield 'statusがnull' => [
            [
                'status' => null
            ]
        ];
        yield 'userIdが文字列' => [
            [
                'userId' => 'しろたん'
            ]
        ];
        yield 'userIdがnull' => [
            [
                'userId' => null
            ]
        ];
    }
}
