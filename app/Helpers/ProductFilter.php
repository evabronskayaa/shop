<?php

namespace App\Helpers;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class ProductFilter
{

    private Builder $builder;
    private Request $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function apply($builder): Builder
    {
        $this->builder = $builder;
        foreach ($this->request->query() as $filter => $value) {
            if (method_exists($this, $filter)) {
                $this->$filter($value);
            }
        }
        return $this->builder;
    }

    private function price($value): void
    {
        if (in_array($value, ['min', 'max'])) {
            $products = $this->builder->get();
            $count = $products->count();
            if ($count > 1) {
                $max = $this->builder->get()->max('price'); // цена самого дорогого товара
                $min = $this->builder->get()->min('price'); // цена самого дешевого товара
                $avg = ($min + $max) * 0.5;
                if ($value == 'min') {
                    $this->builder->where('price', '<=', $avg);
                } else {
                    $this->builder->where('price', '>=', $avg);
                }
            }
        }
    }

    private function new($value): void
    {
        if ('yes' == $value) {
            $this->builder->where('new', true);
        }
    }

    private function hit($value): void
    {
        if ('yes' == $value) {
            $this->builder->where('hit', true);
        }
    }

    private function sale($value): void
    {
        if ('yes' == $value) {
            $this->builder->where('sale', true);
        }
    }
}
