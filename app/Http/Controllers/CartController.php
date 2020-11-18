<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Mail\MeilCart;
use Illuminate\Support\Facades\Mail;

class CartController extends Controller
{
    /**
     * Добавляем товар в корзину
     * @return array
     * 
     */
    public function add_to_cart(Request $request)
    {
        session_start();

        if (!isset($_SESSION['cart']['products'][$request->id])) {
            // если данного товара нет в корзине - создаем его
            $_SESSION['cart']['products'][$request->id] = [
                'category' => $request->category,
                'name' => $request->name,
                'description' => $request->description,
                'price' => $request->price,
                'size' => $request->size,
                'unit' => $request->unit,
                'count' => 1
            ];
        } else {
            // если есть - увеличиваем на единицу его количество
            $_SESSION['cart']['products'][$request->id]['count']++;
        }

        // общее число товаров
        if (!isset($_SESSION['cart']['tottal_count'])) {
            // если товаров нет вообще - создаем переменную и присваиваем единуцу
            $_SESSION['cart']['tottal_count'] = 1;
        } else {
            // если товары есть - увеличиваем на единицу
            $_SESSION['cart']['tottal_count']++;
        }

        // общая цена
        if (!isset($_SESSION['cart']['tottal_price'])) {
            // если цены нет вообще - создаем переменную и присваеваем ей цену товара
            $_SESSION['cart']['tottal_price'] = $request->price;
        } else {
            // если цена есть - складываем с ней цену нового товара
            $_SESSION['cart']['tottal_price'] += $request->price;
        }

        return response()->json($_SESSION['cart']['tottal_price']);
    }
    
    public function view_cart()
    {
        session_start();

        if (!isset($_SESSION['cart']['products'])) {
            $_SESSION['cart']['products'] = [];
            $_SESSION['cart']['tottal_price'] = 0;
        }

        return view('site.cart', [
            'tottal_price' => $_SESSION['cart']['tottal_price'],
            'products' => $_SESSION['cart']['products'],
            'tottal_count' => $_SESSION['cart']['tottal_count']
        ]);
    }

    /**\
     * Обработка нажатия кнопки +
     */
    public function plus($id)
    {
        session_start();

        $_SESSION['cart']['products'][$id]['count']++;
        $_SESSION['cart']['tottal_count']++;
        $_SESSION['cart']['tottal_price'] += $_SESSION['cart']['products'][$id]['price'];

        return view('site.cart', [
            'tottal_price' => $_SESSION['cart']['tottal_price'],
            'products' => $_SESSION['cart']['products'],
            'tottal_count' => $_SESSION['cart']['tottal_count']
        ]);
    }

    public function minus($id)
    {
        session_start();
        $_SESSION['cart']['products'][$id]['count']--;
        $_SESSION['cart']['tottal_price'] -= $_SESSION['cart']['products'][$id]['price'];
        if ($_SESSION['cart']['products'][$id]['count'] == 0) {
            unset($_SESSION['cart']['products'][$id]);
        }
        
        $_SESSION['cart']['tottal_count']--;

        return view('site.cart', [
            'tottal_price' => $_SESSION['cart']['tottal_price'],
            'products' => $_SESSION['cart']['products'],
            'tottal_count' => $_SESSION['cart']['tottal_count']
        ]);
    }
    
    public static function getTottalCount()
    {
        if ($_SESSION['cart']) {} else {
            session_start();
        }
        return $_SESSION['cart']['tottal_count'];
    }

    public static function getTottalPrice()
    {
        if ($_SESSION['cart']) {} else {
            session_start();
        }
        return $_SESSION['cart']['tottal_price'];
    }

    public function sent_cart(Request $request)
    {
        try {
            if ($request->delivery == '0') {
                $this->sendCartWithoutDelivery($request);
            } else if ($request->delivery == '1') {
                $this->sendCartWithDelivery($request);
            }
        } catch(Exeption $e) {
            return response()->json($e);
        }
        
    }

    private function sendCartWithDelivery($request) {

        session_start();

        $name  = $request->name; // имя
        $phone = $request->phone; // телефон и имя
        $comment = $request->comment;

        $products = $_SESSION['cart']['products'];
        $tottal_price = $_SESSION['cart']['tottal_price'];
        $tottal_count = $_SESSION['cart']['tottal_count'];

        unset($_SESSION['cart']);
        Mail::send('mail2', 
        [
            'id' => rand(100, 999),
            'name' => $name,
            'phone' => $phone,
            'products' => $products,
            'comment' => $comment,
            'tottal_price' => $tottal_price,
            'tottal_count' => $tottal_count
        ], function ($message) {
            $message->from('cherdak.khv@bk.ru', 'Пиццерия "Чердак"');
            $message->to('cherdak.khv@bk.ru', 'еуые')->subject('Сообщение с сайта "Чердак"');
        });
    }

    private function sendCartWithoutDelivery($request) {

        session_start();

        $name  = $request->name; // имя
        $phone = $request->phone; // телефон и имя
        $adres = $request->adres; // адрес
        $comment = $request->comment; // комментарии
        $maney = $request->cash; // наличные или карта
        $kvartira = $request->kvartira;
        $podezd = $request->podezd;
        $etag = $request->etag;
        $domophone = $request->domophone;

        if ($maney == 'cash') {
            $manyback = $request->manyback; 
            if ($manyback == "yes") {
                // сдача с суммы
                $back = $request->sum;
            } else if ($manyback == "no") {
                // без сдачи
                $back = 0;
            }
        } else if ($maney == 'card') {
            // без сдачи
            $back = 0;
            $manyback = 0; 
        }

        $products = $_SESSION['cart']['products'];
        $tottal_price = $_SESSION['cart']['tottal_price'];
        $tottal_count = $_SESSION['cart']['tottal_count'];
        unset($_SESSION['cart']);
        Mail::send('mail', 
        [
            'id' => rand(100, 999),
            'name' => $name,
            'phone' => $phone,
            'adres' => $adres,
            'comment' => $comment,
            'maney' => $maney,
            'manyback' => $manyback,
            'podezd' => $podezd,
            'etag' => $etag,
            'kvartira' => $kvartira,
            'domophone' => $domophone,
            'back' => $back,
            'products' => $products,
            'tottal_price' => $tottal_price,
            'tottal_count' => $tottal_count
        ], function ($message) {
            $message->from('cherdak.khv@bk.ru', 'Пиццерия "Чердак"');
            $message->to('cherdak.khv@bk.ru', 'еуые')->subject('Сообщение с сайта "Чердак"');
        });

    }
}
