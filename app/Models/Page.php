<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Route;

/**
 * @property mixed $children
 * @property mixed $id
 * @property mixed $content
 * @method static where(string $string, int $int)
 * @method static create(array $all)
 */
class Page extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'content',
        'parent_id',
    ];

    /**
     * Если мы в панели управления — страница будет получена из
     * БД по id, если в публичной части сайта — то по slug
     *
     * @return string
     */
    public function getRouteKeyName(): string
    {
        $current = Route::currentRouteName();
        if ('page.show' == $current) {
            return 'slug'; // мы в публичной части сайта
        }
        return 'id'; // мы в панели управления
    }

    /**
     * Связь «один ко многим» таблицы `pages` с таблицей `pages`
     *
     * @return HasMany
     */
    public function children(): HasMany
    {
        return $this->hasMany(Page::class, 'parent_id');
    }

    /**
     * Связь «страница принадлежит» таблицы `pages` с таблицей `pages`
     *
     * @return BelongsTo
     */
    public function parent(): BelongsTo
    {
        return $this->belongsTo(Page::class);
    }
}
