<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class UserController extends Controller
{
    /**
     * Показывает список всех пользователей
     *
     * @return View
     */
    public function index(): View
    {
        $users = User::paginate(5);
        return view('admin.user.index', compact('users'));
    }

    public function ban(User $user): RedirectResponse
    {
        $user->banned = !$user->banned;
        $user->update();
        return back();
    }
}
