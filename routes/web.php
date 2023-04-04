<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\BrandController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\PageController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CatalogController;
use App\Http\Controllers\IndexController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

// маршрут для главной страницы без указания метода
Route::get('/', IndexController::class)->name('index');

Route::get('/page/{page:slug}', \App\Http\Controllers\PageController::class)->name('page.show');

Route::name('catalog.')->prefix('catalog')->group(function () {
    Route::get('index', [CatalogController::class, 'index'])->name('index');
    Route::get('category/{category:slug}', [CatalogController::class, 'category'])->name('category');
    Route::get('brand/{brand:slug}', [CatalogController::class, 'brand'])->name('brand');
    Route::get('product/{product:slug}', [CatalogController::class, 'product'])->name('product');
});

Route::name('catalog.')->prefix('catalog')->group(function () {
    Route::get('index', [CatalogController::class, 'index'])->name('index');
    Route::get('category/{slug}', [CatalogController::class, 'category'])->name('category');
    Route::get('brand/{slug}', [CatalogController::class, 'brand'])->name('brand');
    Route::get('product/{slug}', [CatalogController::class, 'product'])->name('product');
    Route::get('search', [CatalogController::class, 'search'])->name('search');
});

Route::get('/cart/index', [CartController::class, 'index'])->name('cart.index');
Route::get('/cart/checkout', [CartController::class, 'checkout'])->name('cart.checkout');
Route::post('/cart/add/{id}', [CartController::class, 'add'])
    ->where('id', '[0-9]+')
    ->name('cart.add');
Route::post('/cart/plus/{id}', [CartController::class, 'plus'])
    ->where('id', '[0-9]+')
    ->name('cart.plus');
Route::post('/cart/minus/{id}', [CartController::class, 'minus'])
    ->where('id', '[0-9]+')
    ->name('cart.minus');
Route::post('/cart/remove/{id}', [CartController::class, 'remove'])
    ->where('id', '[0-9]+')
    ->name('cart.remove');
Route::post('/cart/clear', [CartController::class, 'clear'])->name('cart.clear');
Route::post('/cart/save-order', [CartController::class, 'saveOrder'])->name('cart.save-order');
Route::get('/cart/success', [CartController::class, 'success'])->name('cart.success');
Route::post('/cart/profile', [CartController::class, 'profile'])->name('cart.profile');

Route::prefix('user')->group(function () {
    Auth::routes();
});

Route::middleware(['auth'])->prefix('user')->name('user.')->group(function () {
    // главная страница личного кабинета пользователя
    Route::get('index', [UserController::class, 'index'])->name('index');
    // CRUD-операции над профилями пользователя
    Route::resource('profile', ProfileController::class);
    // просмотр списка заказов в личном кабинете
    Route::get('order', [\App\Http\Controllers\OrderController::class, 'index'])->name('order.index');
    // просмотр отдельного заказа в личном кабинете
    Route::get('order/{order}', [\App\Http\Controllers\OrderController::class, 'show'])->name('order.show');
});

Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    // главная страница панели управления
    Route::get('index', AdminController::class)->name('index');
    // CRUD-операции над категориями каталога
    Route::resource('category', CategoryController::class);
    // CRUD-операции над брендами каталога
    Route::resource('brand', BrandController::class);
    // CRUD-операции над товарами каталога
    Route::resource('product', ProductController::class);
    // доп.маршрут для просмотра товаров категории
    Route::get('product/category/{category}', [ProductController::class, 'category'])->name('product.category');
    // просмотр и редактирование заказов
    Route::resource('order', OrderController::class, ['except' => [
        'create', 'store', 'destroy'
    ]]);
    Route::get('user', [\App\Http\Controllers\Admin\UserController::class, 'index'])->name('user.index');
    Route::get('user/ban/{user}', [\App\Http\Controllers\Admin\UserController::class, 'ban'])->name('user.ban');
    // CRUD-операции над страницами сайта
    Route::resource('page', PageController::class);
    // загрузка изображения из редактора
    Route::post('page/upload/image', [PageController::class, 'uploadImage'])
        ->name('page.upload.image');
    // удаление изображения в редакторе
    Route::delete('page/remove/image', [PageController::class, 'removeImage'])
        ->name('page.remove.image');
});
