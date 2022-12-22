<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * App\Models\BookManagement
 *
 * @property int $id 書籍管理ID
 * @property string $user_id ユーザーID
 * @property string $book_id 書籍ID
 * @property string $status 書籍レンタルステータス
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon $updated_at
 * @property-read \App\Models\Book|null $book
 * @property-read \App\Models\User|null $user
 * @method static \Illuminate\Database\Eloquent\Builder|BookManagement whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BookManagement whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BookManagement whereBookId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BookManagement whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BookManagement whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BookManagement whereUpdatedAt($value)
 * @method static \Database\Factories\BookManagementFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|BookManagement newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|BookManagement newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|BookManagement query()
 * @mixin \Eloquent
 */
class BookManagement extends Model
{
    use HasFactory;

    protected $table = 'book_managements';

    protected $fillable = [
        'user_id',
        'book_id',
        'status',
    ];

    /**
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @return BelongsTo
     */
    public function book(): BelongsTo
    {
        return $this->belongsTo(Book::class);
    }
}
