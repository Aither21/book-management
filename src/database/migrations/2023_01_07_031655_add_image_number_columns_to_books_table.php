<?php

use App\Models\Book;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('books', function (Blueprint $table) {
            $table->string('image_number', 100)
                ->after('author')
                ->nullable();
        });

        $this->updateBooks();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('books', function (Blueprint $table) {
            $table->dropColumn('image_number');
        });
    }

    private function updateBooks()
    {
        $imageNumbers = [
            '4798052582',
            '4798059072',
            '4873115655',
            'B08XBNGYVH',
            '4798063738'
        ];

        DB::transaction(function () use ($imageNumbers) {
            for ($i = 1; $i <= count($imageNumbers); $i++) {
                $book = Book::find($i);
                $book->image_number = $imageNumbers[$i - 1];
                $book->save();
            }
        });
    }
};
