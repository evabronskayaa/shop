<?php

namespace App\Models;

use App\Helpers\LinguaStemRu;
use App\Helpers\ProductFilter;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;

/**
 * @property mixed $category_id
 * @property mixed $id
 * @method static where(string $string, mixed $id)
 * @method static create(array $data)
 * @method static paginate(int $int)
 * @method static whereIn(string $string, array $descendants)
 * @method static whereNew(true $true)
 * @method static whereHit(true $true)
 * @method static whereSale(true $true)
 * @method static categoryProducts(array $descendants)
 * @method static search(mixed $search)
 */
class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'name',
        'slug',
        'content',
        'image',
        'price',
        'new',
        'hit',
        'sale',
    ];

    /**
     * Связь «товар принадлежит» таблицы `products` с таблицей `categories`
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Связь «многие ко многим» таблицы `products` с таблицей `carts`
     */
    public function carts(): BelongsToMany
    {
        return $this->belongsToMany(Cart::class)->withPivot('quantity');
    }

    /**
     * Позволяет выбирать товары категории и всех ее потомков
     *
     * @param Builder $builder
     * @param integer $id
     * @return Builder
     */
    public function scopeCategoryProducts(Builder $builder, int $id): Builder
    {
        $descendants = Category::getAllChildren($id);
        $descendants[] = $id;
        return $builder->whereIn('category_id', $descendants);
    }

    /**
     * Позволяет фильтровать товары по нескольким условиям
     *
     * @param Builder $builder
     * @param ProductFilter $filters
     * @return Builder
     */
    public function scopeFilterProducts(Builder $builder, ProductFilter $filters): Builder
    {
        return $filters->apply($builder);
    }

    /**
     * Позволяет искать товары по заданным словам
     *
     * @param Builder $query
     * @param string $search
     * @return Builder
     */
    public function scopeSearch(Builder $query, string $search): Builder
    {
        // обрезаем поисковый запрос
        $search = iconv_substr($search, 0, 64);
        // удаляем все, кроме букв и цифр
        $search = preg_replace('#[^0-9a-zA-ZА-Яа-яёЁ]#u', ' ', $search);
        // сжимаем двойные пробелы
        $search = preg_replace('#\s+#u', ' ', $search);
        $search = trim($search);
        if (empty($search)) {
            return $query->whereNull('id'); // возвращаем пустой результат
        }
        // разбиваем поисковый запрос на отдельные слова
        $temp = explode(' ', $search);
        $words = [];
        $stemmer = new LinguaStemRu();
        foreach ($temp as $item) {
            if (iconv_strlen($item) > 3) {
                // получаем корень слова
                $words[] = $stemmer->stem_word($item);
            } else {
                $words[] = $item;
            }
        }
        $relevance = "IF (`products`.`name` LIKE '%" . $words[0] . "%', 2, 0)";
        $relevance .= " + IF (`products`.`content` LIKE '%" . $words[0] . "%', 1, 0)";
        $relevance .= " + IF (`categories`.`name` LIKE '%" . $words[0] . "%', 1, 0)";
        for ($i = 1; $i < count($words); $i++) {
            $relevance .= " + IF (`products`.`name` LIKE '%" . $words[$i] . "%', 2, 0)";
            $relevance .= " + IF (`products`.`content` LIKE '%" . $words[$i] . "%', 1, 0)";
            $relevance .= " + IF (`categories`.`name` LIKE '%" . $words[$i] . "%', 1, 0)";
        }

        $query->join('categories', 'categories.id', '=', 'products.category_id')
            ->select('products.*', DB::raw($relevance . ' as relevance'))
            ->where('products.name', 'like', '%' . $words[0] . '%')
            ->orWhere('products.content', 'like', '%' . $words[0] . '%')
            ->orWhere('categories.name', 'like', '%' . $words[0] . '%');
        for ($i = 1; $i < count($words); $i++) {
            $query = $query->orWhere('products.name', 'like', '%' . $words[$i] . '%');
            $query = $query->orWhere('products.content', 'like', '%' . $words[$i] . '%');
            $query = $query->orWhere('categories.name', 'like', '%' . $words[$i] . '%');;
        }
        $query->orderBy('relevance', 'desc');
        return $query;
    }
}
