<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\ImageSaver;
use App\Http\Controllers\Controller;
use App\Http\Requests\ProductCatalogRequest;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class ProductController extends Controller
{
    private ImageSaver $imageSaver;

    public function __construct(ImageSaver $imageSaver)
    {
        $this->imageSaver = $imageSaver;
    }

    /**
     * Показывает список всех товаров каталога
     *
     * @return View
     */
    public function index(): View
    {
        // корневые категории для возможности навигации
        $roots = Category::where('parent_id', 0)->get();
        $products = Product::paginate(5);
        return view('admin.product.index', compact('products', 'roots'));
    }

    /**
     * Показывает товары выбранной категории
     *
     * @param Category $category
     * @return View
     */
    public function category(Category $category): View
    {
        $products = $category->products()->paginate(5);
        return view('admin.product.category', compact('category', 'products'));
    }

    /**
     * Сохраняет новый товар в базу данных
     *
     * @param ProductCatalogRequest $request
     * @return RedirectResponse
     */
    public function store(ProductCatalogRequest $request): RedirectResponse
    {
        $data = $request->all();
        $data['image'] = $this->imageSaver->upload($request, null, 'product');
        $product = Product::create($data);
        return redirect()
            ->route('admin.product.show', ['product' => $product->id])
            ->with('success', 'Новый товар успешно создан');
    }

    /**
     * Показывает форму для создания товара
     *
     * @return View
     */
    public function create(): View
    {
        // все категории для возможности выбора родителя
        $items = Category::all();
        return view('admin.product.create', compact('items'));
    }

    /**
     * Обновляет товар каталога
     *
     * @param ProductCatalogRequest $request
     * @param Product $product
     * @return RedirectResponse
     */
    public function update(ProductCatalogRequest $request, Product $product): RedirectResponse
    {
        $data = $request->all();
        $data['image'] = $this->imageSaver->upload($request, $product, 'product');
        $product->update($data);
        return redirect()
            ->route('admin.product.show', ['product' => $product->id])
            ->with('success', 'Товар был успешно обновлен');
    }

    /**
     * Показывает страницу товара каталога
     *
     * @param Product $product
     * @return View
     */
    public function show(Product $product): View
    {
        return view('admin.product.show', compact('product'));
    }

    /**
     * Показывает форму для редактирования товара
     *
     * @param Product $product
     * @return View
     */
    public function edit(Product $product): View
    {
        // все категории для возможности выбора родителя
        $items = Category::all();
        return view('admin.product.edit', compact('product', 'items'));
    }

    /**
     * Удаляет товар каталога из базы данных
     *
     * @param Product $product
     * @return RedirectResponse
     */
    public function destroy(Product $product): RedirectResponse
    {
        $this->imageSaver->remove($product, 'product');
        $product->delete();
        return redirect()
            ->route('admin.category.index')
            ->with('success', 'Товар каталога успешно удален');
    }
}
