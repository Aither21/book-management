<?php

namespace Tests\Feature;

use App\Enums\SortType;
use App\Models\Book;
use App\Models\BookManagement;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BookGetListTest extends TestCase
{
    use RefreshDatabase;

    private User $user;

    public function setUp(): void
    {
        parent::setUp();
        $this->withoutMiddleware();
        $this->user = User::factory()->create();
        $book = Book::factory()->create();
        Book::factory(20)->create();
        BookManagement::factory()->create([
            'user_id' => $this->user->id,
            'book_id' => $book->id
        ]);
    }

    /**
     * 図書一覧取得API、正常系
     *
     * @return void
     */
    public function testGetBooks()
    {
        $params = http_build_query(['sort' => SortType::ASC->value]);
        $response = $this->actingAs($this->user, 'sanctum')->json(
            'GET',
            '/api/v1/book?' . $params
        )->assertOk();

        // 10件分の書籍レコード取得
        $this->assertCount(10, $response->json()['data']);
    }

    /**
     * 図書一覧取得API降順、正常系
     *
     * @return void
     */
    public function testGetSortDescBooks()
    {
        $afterBook = Book::factory()->create();
        $params = http_build_query(['sort' => SortType::DESC->value]);
        $response = $this->actingAs($this->user, 'sanctum')->json(
            'GET',
            '/api/v1/book?' . $params
        )->assertOk();

        // 後に登録された図書の取得
        $this->assertSame(
            $afterBook->id,
            $response->json()['data'][0]['id']
        );
    }

    /**
     * 図書一覧取得API検索、正常系
     *
     * @return void
     */
    public function testGetSearchBooks()
    {
        $seachBookName = Book::factory()->create(['name' => 'sirotan']);
        $seachBookAuthor = Book::factory()->create(['name' => 'sirotan']);
        $seachBookCompany = Book::factory()->create(['name' => 'sirotan']);
        $params = http_build_query([
            'sort' => SortType::ASC->value,
            'freeword' => 'sirotan'
        ]);
        $response = $this->actingAs($this->user, 'sanctum')->json(
            'GET',
            '/api/v1/book?' . $params
        )->assertOk();

        // 3件分の書籍レコード取得
        $this->assertCount(3, $response->json()['data']);
        $this->assertSame(
            $seachBookName->id,
            $response->json()['data'][0]['id']
        );
        $this->assertSame(
            $seachBookAuthor->id,
            $response->json()['data'][1]['id']
        );
        $this->assertSame(
            $seachBookCompany->id,
            $response->json()['data'][2]['id']
        );
    }
}
