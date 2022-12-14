<?php

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
        Schema::create('book_managements', function (Blueprint $table) {
            $table->id()->comment('書籍管理ID');
            $table->foreignId('user_id')->comment('ユーザーID')->constrained('users')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignId('book_id')->comment('書籍ID')->constrained('books')->cascadeOnDelete()->cascadeOnUpdate();
            $table->tinyInteger('status')->comment('書籍レンタルステータス');
            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP'));
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('book_managements');
    }
};
