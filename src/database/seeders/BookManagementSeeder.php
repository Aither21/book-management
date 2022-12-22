<?php

namespace Database\Seeders;

use App\Models\Book;
use App\Models\BookManagement;
use App\Models\User;
use DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BookManagementSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $admin = User::whereName('admin')->first();
        $this->generateBooks();
        $book = Book::whereAuthor('掌田津耶乃')->first();
        BookManagement::create([
            'user_id' => $admin->id,
            'book_id' => $book->id,
            'status' => 1
        ]);
    }

    private function generateBooks()
    {
        $recodes = collect(
            [

                [
                    'PHPフレームワーク Laravel入門',
                    '掌田津耶乃'
                ],
                [
                    'PHPフレームワーク Laravel実践開発',
                    '掌田津耶乃'
                ],
                [
                    'リーダブルコード より良いコードを書くためのシンプルで実践的なテクニック',
                    'ダスティン・ボズウェル / トレバー・フーシェ'
                ],
                [
                    'React.js & Next.js超入門',
                    '掌田津耶乃'
                ],
                [
                    'Vue.js & Nuxt.js超入門',
                    '掌田津耶乃'
                ]
            ]
        );
        $recodes->eachSpread(function ($name, $author) {
            Book::create([
                'name' => $name,
                'author' => $author,
                'company' => 'KITU'
            ]);
        });
    }
}
