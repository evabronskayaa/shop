<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class OrderController extends Controller
{
    /**
     * Просмотр списка заказов
     *
     * @return View
     */
    public function index(): View
    {
        $orders = Order::orderBy('status', 'asc')->paginate(5);
        $statuses = Order::STATUSES;
        return view('admin.order.index', compact('orders', 'statuses'));
    }

    /**
     * Просмотр отдельного заказа
     *
     * @param Order $order
     * @return View
     */
    public function show(Order $order): View
    {
        $statuses = Order::STATUSES;
        return view('admin.order.show', compact('order', 'statuses'));
    }

    /**
     * Форма редактирования заказа
     *
     * @param Order $order
     * @return View
     */
    public function edit(Order $order): View
    {
        $statuses = Order::STATUSES;
        return view('admin.order.edit', compact('order', 'statuses'));
    }

    /**
     * Обновляет заказ покупателя
     *
     * @param Request $request
     * @param Order $order
     * @return RedirectResponse
     */
    public function update(Request $request, Order $order): RedirectResponse
    {
        $order->update($request->all());
        return redirect()
            ->route('admin.order.show', ['order' => $order->id])
            ->with('success', 'Заказ был успешно обновлен');
    }
}
