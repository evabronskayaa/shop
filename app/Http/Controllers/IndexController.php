<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\View\View;

class IndexController extends Controller
{
    public function __invoke(Request $request): View
    {
        $new = Product::whereNew(true)->latest()->limit(3)->get();
        $hit = Product::whereHit(true)->latest()->limit(3)->get();
        $sale = Product::whereSale(true)->latest()->limit(3)->get();
        return view('index', compact('new', 'hit', 'sale'));
    }
}
