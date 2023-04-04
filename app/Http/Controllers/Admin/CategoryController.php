<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\ImageSaver;
use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryCatalogRequest;
use App\Models\Category;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

class CategoryController extends Controller
{
    private ImageSaver $imageSaver;

    public function __construct(ImageSaver $imageSaver)
    {
        $this->imageSaver = $imageSaver;
    }

    /**
     * Показывает список всех категорий
     *
     * @return View
     */
    public function index(): View
    {
        $items = Category::all();
        return view('admin.category.index', compact('items'));
    }

    /**
     * Сохраняет новую категорию в базу данных
     *
     * @param CategoryCatalogRequest $request
     * @return RedirectResponse
     */
    public function store(CategoryCatalogRequest $request): RedirectResponse
    {
        $data = $request->all();
        $data['image'] = $this->imageSaver->upload($request, null, 'category');
        $category = Category::create($data);
        return redirect()
            ->route('admin.category.show', ['category' => $category->id])
            ->with('success', 'Новая категория успешно создана');
    }

    /**
     * Показывает форму для создания категории
     *
     * @return View
     */
    public function create(): View
    {
        // все категории для возможности выбора родителя
        $items = Category::all();
        return view('admin.category.create', compact('items'));
    }

    /**
     * Показывает страницу категории
     *
     * @param Category $category
     * @return View
     */
    public function show(Category $category): View
    {
        return view('admin.category.show', compact('category'));
    }

    /**
     * Показывает форму для редактирования категории
     *
     * @param Category $category
     * @return View
     */
    public function edit(Category $category): View
    {
        // все категории для возможности выбора родителя
        $items = Category::all();
        return view('admin.category.edit', compact('category', 'items'));
    }

    /**
     * Обновляет категорию каталога
     *
     * @param CategoryCatalogRequest $request
     * @param Category $category
     * @return RedirectResponse
     */
    public function update(CategoryCatalogRequest $request, Category $category): RedirectResponse
    {
        $data = $request->all();
        $data['image'] = $this->imageSaver->upload($request, $category, 'category');
        $category->update($data);
        return redirect()
            ->route('admin.category.show', ['category' => $category->id])
            ->with('success', 'Категория была успешно исправлена');
    }

    /**
     * Удаляет категорию каталога
     *
     * @param Category $category
     * @return RedirectResponse
     */
    public function destroy(Category $category): RedirectResponse
    {
        if ($category->children->count()) {
            $errors[] = 'Нельзя удалить категорию с дочерними категориями';
        }
        if ($category->products->count()) {
            $errors[] = 'Нельзя удалить категорию, которая содержит товары';
        }
        if (!empty($errors)) {
            return back()->withErrors($errors);
        }
        $this->imageSaver->remove($category, 'category');
        $category->delete();
        return redirect()
            ->route('admin.category.index')
            ->with('success', 'Категория каталога успешно удалена');
    }
}
