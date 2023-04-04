<?php

namespace App\Rules;

use App\Models\Category;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class CategoryParent implements ValidationRule
{
    private Category $category;

    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct(Category $category) {
        $this->category = $category;
    }
    /**
     * Run the validation rule.
     *
     * @param string $attribute
     * @param mixed $value
     * @param Closure $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (!$this->category->validParent($value)) {
            $fail('validation.custom.parent_id.invalid')->translate();
        }
    }
}
