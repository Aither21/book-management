<?php

namespace Tests\Feature;

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
        $response = $this->actingAs($this->user, 'sanctum')->get('/api/v1/book');

        $response->assertStatus(200);
        // 10ページ分の書籍レコード取得
        $this->assertCount(10, $response->json()['data']);
    }
}
