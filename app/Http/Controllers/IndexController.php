<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\View\View;

class IndexController extends Controller
{
    public function __invoke(Request $request): View
    {
        $roots = Category::where('parent_id', 0)->get();
        return view('catalog.index', compact('roots'));
    }
}
