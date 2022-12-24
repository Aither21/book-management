<?php

namespace Tests\Feature;

use App\Models\Book;
use App\Models\BookManagement;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BookGetTest extends TestCase
{
    use RefreshDatabase;

    private User $user;
    private Book $book;
    private BookManagement $bookManagement;

    public function setUp(): void
    {
        parent::setUp();
        $this->withoutMiddleware();
        $this->user = User::factory()->create();
        $this->book = Book::factory()->create();
        $this->bookManagement = BookManagement::factory()->create([
            'user_id' => $this->user->id,
            'book_id' => $this->book->id
        ]);
    }

    /**
     * 図書取得API、正常系
     *
     * @return void
     */
    public function test GetBook()
    {
        $response = $this->actingAs(
            $this->user,
            'sanctum'
        )->get('/api/v1/book/' . $this->book->id);

        $response->assertStatus(200);
        $this->assertSame(
            [
                'id' => $this->book->id,
                'name' => $this->book->name,
                'author' => $this->book->author,
                'company' => $this->book->company,
                'createdAt' => Carbon::parse($this->book->created_at)->format('Y-m-d'),
                'status' => $this->bookManagement->status,
                'userName' => $this->user->name
            ],
            $response->json()['data']
        );
    }
}
