<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;


class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $name = fake()->realText(rand(40, 50));
        return [
            'category_id' => rand(1, 4),
            'name' => $name,
            'content' => fake()->realText(rand(400, 500)),
            'slug' => Str::slug($name),
            'price' => rand(1000, 2000),
        ];
    }
}
