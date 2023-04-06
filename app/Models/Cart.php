<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Facades\Cookie;

/**
 * @property mixed $products
 * @method static findOrFail(array|string $cart_id)
 * @method static create()
 */
class Cart extends Model
{
    use HasFactory;

    /**
     * Возвращает количество позиций в корзине
     */
    public static function getCount(): int
    {
        $cart_id = request()->cookie('cart_id');
        if (empty($cart_id)) {
            return 0;
        }
        return self::getCart()->getProductsCount();
    }

    public static function getCart(): Cart
    {
        $cart_id = request()->cookie('cart_id');
        if (!empty($cart_id)) {
            try {
                $cart = Cart::findOrFail($cart_id);
            } catch (ModelNotFoundException) {
                $cart = Cart::create();
            }
        } else {
            $cart = Cart::create();
        }
        Cookie::queue('cart_id', $cart->id, 525600);
        return $cart;
    }

    /**
     * Возвращает конечную стоимость всех продуктов в корзине
     */

    public function getAmount() {
        $amount = 0.0;
        foreach ($this->products as $product) {
            $amount = $amount + $product->price * $product->pivot->quantity;
        }
        return $amount;
    }

    /**
     * Возвращает количество какого-то продукта в корзине
     */
    public function getProductsCount(): int
    {
        $count = 0;
        foreach ($this->products as $product) {
            $count += $product->pivot->quantity;
        }
        return $count;
    }

    /**
     * Увеличивает кол-во товара $id в корзине на величину $count
     */
    public function increase($id, $count = 1)
    {
        $this->change($id, $count);
    }

    /**
     * Изменяет количество товара $id в корзине на величину $count;
     * если товара еще нет в корзине — добавляет этот товар; $count
     * может быть как положительным, так и отрицательным числом
     */
    private function change($id, $count = 0)
    {
        if ($count == 0) {
            return;
        }
        // если товар есть в корзине — изменяем кол-во
        if ($this->products->contains($id)) {
            // получаем объект строки таблицы `basket_product`
            $pivotRow = $this->products()->where('product_id', $id)->first()->pivot;
            $quantity = $pivotRow->quantity + $count;
            if ($quantity > 0) {
                // обновляем количество товара $id в корзине
                $pivotRow->update(['quantity' => $quantity]);
            } else {
                // кол-во равно нулю — удаляем товар из корзины
                $pivotRow->delete();
            }
        } elseif ($count > 0) { // иначе — добавляем этот товар
            $this->products()->attach($id, ['quantity' => $count]);
        }
        // обновляем поле `updated_at` таблицы `baskets`
        $this->touch();
    }

    /**
     * Связь «многие ко многим» таблицы `carts` с таблицей `products`
     */
    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class)->withPivot('quantity');
    }

    /**
     * Уменьшает кол-во товара $id в корзине на величину $count
     */
    public function decrease($id, $count = 1)
    {
        $this->change($id, -1 * $count);
    }

    /**
     * Удаляет товар с идентификатором $id из корзины покупателя
     */
    public function remove($id)
    {
        // удаляем товар из корзины (разрушаем связь)
        $this->products()->detach($id);
        // обновляем поле `updated_at` таблицы `baskets`
        $this->touch();
    }
}
