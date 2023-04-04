<?php

namespace App\Http\Controllers;

use App\Models\Page;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PageController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param Request $request
     * @param Page $page
     * @return View
     */
    public function __invoke(Request $request, Page $page): View
    {
        return view('page.show', compact('page'));
    }
}
