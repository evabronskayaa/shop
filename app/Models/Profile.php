<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property mixed $user_id
 * @property mixed $id
 * @method static create(array $all)
 */
class Profile extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'title',
        'name',
        'email',
        'phone',
        'address',
        'comment',
    ];

    /**
     * Связь «профиль принадлежит» таблицы `profiles` с таблицей `users`
     *
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
