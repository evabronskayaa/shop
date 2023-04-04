<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property mixed $id
 * @property mixed $children
 * @property mixed $products
 * @property mixed $image
 * @method static create(array $all)
 * @method static where(string $string, $id)
 */
class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'parent_id',
        'name',
        'slug',
        'content',
        'image',
    ];

    /**
     * Возвращает список корневых категорий каталога товаров
     */
    public static function roots()
    {
        return self::where('parent_id', 0)->with('children')->get();
    }

    /**
     * Возвращает список всех категорий каталога в виде дерева
     */
    public static function hierarchy()
    {
        return self::where('parent_id', 0)->with('descendants')->get();
    }

    /**
     * Проверяет, что переданный идентификатор id может быть родителем
     * этой категории; что категорию не пытаются поместить внутрь себя
     */
    public function validParent($id): bool
    {
        $id = (integer)$id;
        // получаем идентификаторы всех потомков текущей категории
        $ids = $this->getAllChildren($this->id);
        $ids[] = $this->id;
        return !in_array($id, $ids);
    }

    /**
     * Возвращает всех потомков категории с идентификатором $id
     */
    public static function getAllChildren($id): array
    {
        // получаем прямых потомков категории с идентификатором $id
        $children = self::where('parent_id', $id)->with('children')->get();
        $ids = [];
        foreach ($children as $child) {
            $ids[] = $child->id;
            // для каждого прямого потомка получаем его прямых потомков
            if ($child->children->count()) {
                $ids = array_merge($ids, self::getAllChildren($child->id));
            }
        }
        return $ids;
    }

    /**
     * Связь «один ко многим» таблицы `categories` с таблицей `categories`
     */
    public function children(): HasMany
    {
        return $this->hasMany(Category::class, 'parent_id');
    }

    /**
     * Связь «один ко многим» таблицы `categories` с таблицей `products`
     */
    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }

    /**
     * Связь «один ко многим» таблицы `categories` с таблицей `categories`, но
     * позволяет получить не только дочерние категории, но и дочерние-дочерние
     */
    public function descendants(): HasMany
    {
        return $this->hasMany(Category::class, 'parent_id')->with('descendants');
    }
}
