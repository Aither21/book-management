<?php

namespace Tests\Feature;

use App\Enums\BookManagementStatusType;
use App\Models\Book;
use App\Models\BookManagement;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BookManagementPutTest extends TestCase
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
     * 図書レンタル中を返却申請中にステータスを更新する
     *
     * @return void
     */
    public function testUpdateBookManagementStatus()
    {
        $response = $this->actingAs(
            $this->user,
            'sanctum'
        )->put(
            '/api/v1/book-management/' . $this->book->id,
            ['status' => BookManagementStatusType::IN_RENTAL->value]
        );
        $response->assertStatus(204);
        $this->assertDatabaseHas(
            BookManagement::class,
            [
                'user_id' => $this->bookManagement->user_id,
                'book_id' => $this->bookManagement->book_id,
                'status' => BookManagementStatusType::APPLYING_RETURN->value
            ]
        );
    }

    /**
     * 図書レンタル申請
     *
     * @return void
     */
    public function testGenerateBookManagement()
    {
        // セットアップした図書のステータスを完了にする
        $this->bookManagement->status = BookManagementStatusType::COMPLETE;
        $this->bookManagement->save();

        $response = $this->actingAs(
            $this->user,
            'sanctum'
        )->put(
            '/api/v1/book-management/' . $this->book->id
        );
        $response->assertStatus(204);
        $this->assertDatabaseHas(
            BookManagement::class,
            [
                'user_id' => $this->bookManagement->user_id,
                'book_id' => $this->bookManagement->book_id,
                'status' => BookManagementStatusType::IN_RENTAL->value
            ]
        );
    }

    /**
     * 他のユーザーがレンタル中の図書を貸出申請した場合、401
     *
     * @return void
     */
    public function testOtherUserRentalBook()
    {
        // セットアップした図書を他のユーザーにする
        $otherUser = User::factory()->create();
        $this->bookManagement->user_id = $otherUser->id;
        $this->bookManagement->save();

        $response = $this->actingAs(
            $this->user,
            'sanctum'
        )->put(
            '/api/v1/book-management/' . $this->book->id
        );
        $response->assertStatus(401);
        $this->assertSame(
            ['message' => 'この図書は他のユーザーがレンタル中です。'],
            $response->json()
        );
    }

    /**
     * ステータスをリクエストしていない場合、401
     *
     * @return void
     */
    public function testNoRequestStatus()
    {
        $response = $this->actingAs(
            $this->user,
            'sanctum'
        )->put(
            '/api/v1/book-management/' . $this->book->id
        );
        $response->assertStatus(401);
        $this->assertSame(
            ['message' => 'リクエストが不正です。'],
            $response->json()
        );
    }
}
