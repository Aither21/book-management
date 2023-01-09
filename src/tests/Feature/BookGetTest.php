<?php

namespace Tests\Feature;

use App\Enums\BookManagementStatusType;
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
    public function testGetBook()
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
                'imageUrl' => 'https://images-na.ssl-images-amazon.com/images/P/' . $this->book->image_number . '.09.LZZZZZZZ',
                'company' => $this->book->company,
                'createdAt' => Carbon::parse($this->book->created_at)->format('Y-m-d'),
                'status' => $this->bookManagement->status,
                'userId' => $this->user->id,
                'userName' => $this->user->name
            ],
            $response->json()['data']
        );
    }

    /**
     * 図書取得API、ステータスが最新のレコードである
     *
     * @return void
     */
    public function testGetBookManagementOrderByDesc()
    {
        $user = User::factory()->create();
        $bookManagement = BookManagement::factory()->create([
            'user_id' => $user->id,
            'book_id' => $this->book->id,
            'status' => BookManagementStatusType::COMPLETE->value
        ]);

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
                'imageUrl' => 'https://images-na.ssl-images-amazon.com/images/P/' . $this->book->image_number . '.09.LZZZZZZZ',
                'company' => $this->book->company,
                'createdAt' => Carbon::parse($this->book->created_at)->format('Y-m-d'),
                'status' => $bookManagement->status,
                'userId' => $user->id,
                'userName' => $user->name
            ],
            $response->json()['data']
        );
    }

    /**
     * 図書取得API、図書IDと同じレコードを取得する
     *
     * @return void
     */
    public function testGetBookId()
    {
        $book = Book::factory()->create();

        $response = $this->actingAs(
            $this->user,
            'sanctum'
        )->get('/api/v1/book/' . $book->id);

        $response->assertStatus(200);
        $this->assertSame(
            [
                'id' => $book->id,
                'name' => $book->name,
                'author' => $book->author,
                'imageUrl' => 'https://images-na.ssl-images-amazon.com/images/P/' . $book->image_number . '.09.LZZZZZZZ',
                'company' => $book->company,
                'createdAt' => Carbon::parse($book->created_at)->format('Y-m-d'),
                'status' => null,
                'userId' => null,
                'userName' => null
            ],
            $response->json()['data']
        );
    }
}
