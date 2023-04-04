<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @method static orderBy(string $string, string $string1)
 * @method static findOrFail(mixed $order_id)
 * @method static create(array $param)
 * @method static whereUserId($id)
 * @property mixed $id
 * @property mixed $user_id
 */
class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'email',
        'phone',
        'address',
        'comment',
        'amount',
        'status',
    ];

    public const STATUSES = [
        0 => 'Новый',
        1 => 'Обработан',
        2 => 'Оплачен',
        3 => 'Доставлен',
        4 => 'Завершен',
    ];

    /**
     * Связь «один ко многим» таблицы `orders` с таблицей `order_items`
     */
    public function items(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    /**
     * Преобразует дату и время создания заказа из UTC в Europe/Moscow
     *
     * @param $value
     * @return Carbon|false
     */
    public function getCreatedAtAttribute($value): bool|Carbon
    {
        return Carbon::createFromFormat('Y-m-d H:i:s', $value)->timezone('Europe/Moscow');
    }

    /**
     * Преобразует дату и время обновления заказа из UTC в Europe/Moscow
     *
     * @param $value
     * @return Carbon|false
     */
    public function getUpdatedAtAttribute($value): bool|Carbon
    {
        return Carbon::createFromFormat('Y-m-d H:i:s', $value)->timezone('Europe/Moscow');
    }
}
