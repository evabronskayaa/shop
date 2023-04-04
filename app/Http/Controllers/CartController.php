<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Order;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class CartController extends Controller
{

    /**
     * Показывает корзину покупателя
     */
    public function index(): View
    {
        $products = Cart::getCart()->products;
        return view('cart.index', compact('products'));
    }

    /**
     * Форма оформления заказа
     *
     * @param Request $request
     * @return View
     */
    public function checkout(Request $request): View
    {
        $profile = null;
        $profiles = null;
        if (auth()->check()) { // если пользователь аутентифицирован
            $user = auth()->user();
            // ...и у него есть профили для оформления
            $profiles = $user->profiles;
            // ...и был запрошен профиль для оформления
            $prof_id = (int)$request->input('profile_id');
            if ($prof_id) {
                $profile = $user->profiles()->whereIdAndUserId($prof_id, $user->id)->first();
            }
        }
        return view('cart.checkout', compact('profiles', 'profile'));
    }

    /**
     * Добавляет товар с идентификатором $id в корзину
     */
    public function add(Request $request, $id): \Illuminate\Contracts\View\View|\Illuminate\Foundation\Application|Factory|Application|RedirectResponse
    {
        $cart = Cart::getCart();
        $quantity = $request->input('quantity') ?? 1;
        $cart->increase($id, $quantity);
        if (!$request->ajax()) {
            // выполняем редирект обратно на ту страницу,
            // где была нажата кнопка «В корзину»
            return back();
        }
        // в случае ajax-запроса возвращаем html-код корзины в правом
        // верхнем углу, чтобы заменить исходный html-код, потому что
        // теперь количество позиций будет другим
        $positions = $cart->getProductsCount() + 1;
        return view('cart.part.cart', compact('positions'));
    }

    /**
     * Увеличивает кол-во товара $id в корзине на единицу
     */
    public function plus($id): RedirectResponse
    {
        Cart::getCart()->increase($id);
        // выполняем редирект обратно на страницу корзины
        return redirect()->route('cart.index');
    }

    /**
     * Уменьшает кол-во товара $id в корзине на единицу
     */
    public function minus($id): RedirectResponse
    {
        Cart::getCart()->decrease($id);
        // выполняем редирект обратно на страницу корзины
        return redirect()->route('cart.index');
    }

    /**
     * Удаляет товар с идентификаторм $id из корзины
     */
    public function remove($id): RedirectResponse
    {
        Cart::getCart()->remove($id);
        // выполняем редирект обратно на страницу корзины
        return redirect()->route('cart.index');
    }

    /**
     * Полностью очищает содержимое корзины покупателя
     */
    public function clear(): RedirectResponse
    {
        Cart::getCart()->delete();
        // выполняем редирект обратно на страницу корзины
        return redirect()->route('cart.index');
    }

    /**
     * Сохранение заказа в БД
     * @throws ValidationException
     */
    public function saveOrder(Request $request): RedirectResponse
    {
        // проверяем данные формы оформления
        $this->validate($request, [
            'name' => 'required|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|max:255',
            'address' => 'required|max:255',
        ]);

        // валидация пройдена, сохраняем заказ
        $cart = Cart::getCart();
        $user_id = auth()->check() ? auth()->user()->id : null;
        $order = Order::create(
            $request->all() + ['amount' => $cart->getAmount(), 'user_id' => $user_id]
        );

        foreach ($cart->products as $product) {
            $order->items()->create([
                'product_id' => $product->id,
                'name' => $product->name,
                'price' => $product->price,
                'quantity' => $product->pivot->quantity,
                'cost' => $product->price * $product->pivot->quantity,
            ]);
        }

        // уничтожаем корзину
        $cart->delete();

        return redirect()
            ->route('cart.success')
            ->with('order_id', $order->id);
    }

    /**
     * Сообщение об успешном оформлении заказа
     */
    public function success(Request $request): \Illuminate\Contracts\View\View|\Illuminate\Foundation\Application|Factory|RedirectResponse|Application
    {
        if ($request->session()->exists('order_id')) {
            // сюда покупатель попадает сразу после успешного оформления заказа
            $order_id = $request->session()->pull('order_id');
            $order = Order::findOrFail($order_id);
            return view('cart.success', compact('order'));
        } else {
            // если покупатель попал сюда случайно, не после оформления заказа,
            // ему здесь делать нечего — отправляем на страницу корзины
            return redirect()->route('cart.index');
        }
    }

    /**
     * Возвращает профиль пользователя в формате JSON
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function profile(Request $request): JsonResponse
    {
        if (!$request->ajax()) {
            abort(404);
        }
        if (!auth()->check()) {
            return response()->json(['error' => 'Нужна авторизация!'], 404);
        }
        $user = auth()->user();
        $profile_id = (int)$request->input('profile_id');
        if ($profile_id) {
            $profile = $user->profiles()->whereIdAndUserId($profile_id, $user->id)->first();
            if ($profile) {
                return response()->json(['profile' => $profile]);
            }
        }
        return response()->json(['error' => 'Профиль не найден!'], 404);
    }
}
