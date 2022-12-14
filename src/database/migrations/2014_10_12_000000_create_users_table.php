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
        Schema::create('users', function (Blueprint $table) {
            $table->id()->comment('ユーザーID');
            $table->string('name', 150)->comment('ユーザー名');
            $table->string('email', 256)->unique()->comment('メールアドレス');
            $table->timestamp('email_verified_at')->nullable()->comment('仮登録許可期限');
            $table->string('password')->comment('パスワード');
            $table->rememberToken()->comment('トークン');
            $table->string('company', 10)->comment('会社名');
            $table->boolean('is_admin')->default(false)->comment('管理者フラグ');
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
        Schema::dropIfExists('users');
    }
};
