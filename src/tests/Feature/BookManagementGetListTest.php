<?php

namespace Tests\Feature;

use App\Enums\BookManagementStatusType;
use App\Enums\SortType;
use App\Enums\UserType;
use App\Models\Book;
use App\Models\BookManagement;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BookManagementGetListTest extends TestCase
{
    use RefreshDatabase;

    private User $user;
    private User $adminUser;
    private Book $book;

    public function setUp(): void
    {
        parent::setUp();
        $this->withoutMiddleware();
        $this->user = User::factory()->create();
        $this->adminUser = User::factory()->create(['is_admin' => UserType::ADMIN->value]);
        $this->book = Book::factory()->create();
    }

    /**
     * 図書一覧取得API、正常系
     *
     * @return void
     */
    public function testGetBookManagements()
    {
        BookManagement::factory(20)->create([
            'user_id' => $this->user->id,
            'book_id' => $this->book->id,
            'status' => BookManagementStatusType::APPLYING_RENTAL->value
        ]);

        BookManagement::factory(20)->create([
            'user_id' => $this->user->id,
            'book_id' => $this->book->id,
            'status' => BookManagementStatusType::IN_RENTAL->value
        ]);

        BookManagement::factory(20)->create([
            'user_id' => $this->user->id,
            'book_id' => $this->book->id,
            'status' => BookManagementStatusType::APPLYING_RETURN->value
        ]);

        BookManagement::factory(20)->create([
            'user_id' => $this->user->id,
            'book_id' => $this->book->id,
            'status' => BookManagementStatusType::COMPLETE->value
        ]);

        BookManagement::factory(20)->create([
            'user_id' => $this->user->id,
            'book_id' => $this->book->id,
            'status' => BookManagementStatusType::RENTAL_REJECTION->value
        ]);

        $params = http_build_query(['sort' => SortType::ASC->value]);
        $response = $this->actingAs($this->adminUser, 'sanctum')->json('GET', '/api/v1/book-management?' . $params)->assertOk();
        // 10ページ分の書籍返却申請レコード取得
        $this->assertCount(10, $response->json()['data']);
        // 合計の取得件数、全て
        $this->assertSame(100, $response->json()['meta']['total']);

        $response = $this->actingAs($this->adminUser, 'sanctum')
            ->json('GET', '/api/v1/book-management?' . $params, ['status' => BookManagementStatusType::APPLYING_RENTAL->value])->assertOk();
        // 合計の取得件数、貸出申請
        $this->assertSame(20, $response->json()['meta']['total']);

        $response = $this->actingAs($this->adminUser, 'sanctum')
            ->json('GET', '/api/v1/book-management?' . $params, ['status' => BookManagementStatusType::IN_RENTAL->value])->assertOk();
        // 合計の取得件数、貸出中
        $this->assertSame(20, $response->json()['meta']['total']);

        $response = $this->actingAs($this->adminUser, 'sanctum')
            ->json('GET', '/api/v1/book-management?' . $params, ['status' => BookManagementStatusType::APPLYING_RETURN->value])->assertOk();
        // 合計の取得件数、返却申請
        $this->assertSame(20, $response->json()['meta']['total']);

        $response = $this->actingAs($this->adminUser, 'sanctum')
            ->json('GET', '/api/v1/book-management?' . $params, ['status' => BookManagementStatusType::COMPLETE->value])->assertOk();
        // 合計の取得件数、完了
        $this->assertSame(20, $response->json()['meta']['total']);

        $response = $this->actingAs($this->adminUser, 'sanctum')
            ->json('GET', '/api/v1/book-management?' . $params, ['status' => BookManagementStatusType::RENTAL_REJECTION->value])->assertOk();
        // 合計の取得件数、貸出却下
        $this->assertSame(20, $response->json()['meta']['total']);
    }

    public function testGetSearchBooks()
    {
        $seachBookName = Book::factory()->create(['name' => 'sirotan']);
        BookManagement::factory()->create([
            'user_id' => $this->user->id,
            'book_id' => $seachBookName->id,
            'status' => BookManagementStatusType::APPLYING_RENTAL->value
        ]);
        $seachBookAuthor = Book::factory()->create(['name' => 'sirotan']);
        BookManagement::factory()->create([
            'user_id' => $this->user->id,
            'book_id' => $seachBookAuthor->id,
            'status' => BookManagementStatusType::IN_RENTAL->value
        ]);
        $seachBookCompany = Book::factory()->create(['name' => 'sirotan']);
        $seachBookManagement = BookManagement::factory()->create([
            'user_id' => $this->user->id,
            'book_id' => $seachBookCompany->id,
            'status' => BookManagementStatusType::COMPLETE->value
        ]);
        $params = http_build_query([
            'sort' => SortType::ASC->value,
            'freeword' => 'sirotan',
            'status' => BookManagementStatusType::COMPLETE->value
        ]);
        $response = $this->actingAs($this->adminUser, 'sanctum')->json(
            'GET',
            '/api/v1/book-management?' . $params
        )->assertOk();

        // 1件分の書籍レコード取得
        $this->assertCount(1, $response->json()['data']);
        $this->assertSame(
            $seachBookManagement->id,
            $response->json()['data'][0]['id']
        );
    }
}
