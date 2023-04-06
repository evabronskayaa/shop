<?php

namespace App\Http\Controllers;

use App\Models\Profile;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;
use Illuminate\Support\Facades\DB;

class ProfileController extends Controller
{
    /**
     * Показывает список всех профилей
     *
     * @return View
     */
    public function index(): View
    {
        $profiles = auth()->user()->profiles()->paginate(4);
        return view('user.profile.index', compact('profiles'));
    }

    /**
     * Сохраняет новый профиль в базу данных
     *
     * @param Request $request
     * @return RedirectResponse
     * @throws ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        // проверяем данные формы профиля
        $this->validate($request, [
            'user_id' => 'in:' . auth()->user()->id,
            'title' => 'required|max:255',
            'name' => 'required|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|max:255',
            'address' => 'required|max:255',
        ]);
        // валидация пройдена, создаем профиль
        $profile = Profile::create($request->all());
        return redirect()
            ->route('user.profile.show', ['profile' => $profile->id])
            ->with('success', 'Новый профиль успешно создан');
    }

    /**
     * Показывает форму для создания профиля
     *
     * @return View
     */
    public function create(): View
    {
        return view('user.profile.create');
    }

    /**
     * Показывает информацию о профиле
     *
     * @param Profile $profile
     * @return View
     */
    public function show(Profile $profile): View
    {
        if ($profile->user_id !== auth()->user()->id) {
            abort(404); // это чужой профиль
        }
        return view('user.profile.show', compact('profile'));
    }

    /**
     * Показывает форму для редактирования профиля
     *
     * @param Profile $profile
     * @return View
     */
    public function edit(Profile $profile): View
    {
        if ($profile->user_id !== auth()->user()->id) {
            abort(404);
        }
        return view('user.profile.edit', compact('profile'));
    }

    /**
     * Обновляет профиль (запись в таблице БД)
     *
     * @param Request $request
     * @param Profile $profile
     * @return RedirectResponse
     * @throws ValidationException
     */
    public function update(Request $request, Profile $profile): RedirectResponse
    {
        // проверяем данные формы профиля
        $this->validate($request, [
            'user_id' => 'in:' . auth()->user()->id,
            'title' => 'required|max:255',
            'name' => 'required|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|max:255',
            'address' => 'required|max:255',
        ]);
        // валидация пройдена, обновляем профиль
        $profile->update($request->all());
        return redirect()
            ->route('user.profile.show', ['profile' => $profile->id])
            ->with('success', 'Профиль был успешно отредактирован');
    }

    /**
     * Удаляет профиль (запись в таблице БД)
     *
     * @param Profile $profile
     * @return RedirectResponse
     */
    public function destroy(Profile $profile): RedirectResponse
    {
        if ($profile->user_id !== auth()->user()->id) {
            abort(404); // это чужой профиль
        }
        $profile->delete();
        return redirect()
            ->route('user.profile.index')
            ->with('success', 'Профиль был успешно удален');
    }
}
