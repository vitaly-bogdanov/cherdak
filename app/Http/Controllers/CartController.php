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

        // условия скидки
        if ($_SESSION['cart']['tottal_price'] >= 700) {
            $_SESSION['cart']['delivery_price'] = 0;
        } else if ($_SESSION['cart']['tottal_price'] < 700) {
            $_SESSION['cart']['delivery_price'] = 150;
        }
		
        // отправляем общее число товаров
        return response()->json($_SESSION['cart']['tottal_count']);
    }
    
    public function view_cart()
    {
        session_start();

        if (!isset($_SESSION['cart']['products'])) {
            $_SESSION['cart']['products'] = [];
            $_SESSION['cart']['tottal_price'] = 0;
            $_SESSION['cart']['delivery_price'] = 0;
        }

        return view('site.cart', [
            'tottal_price' => $_SESSION['cart']['tottal_price'],
            'delivery_price' => $_SESSION['cart']['delivery_price'],
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

        // условия скидки
        if ($_SESSION['cart']['tottal_price'] >= 700) {
            $_SESSION['cart']['delivery_price'] = 0;
        } else if ($_SESSION['cart']['tottal_price'] < 700) {
            $_SESSION['cart']['delivery_price'] = 150;
        }

        return view('site.cart', [
            'tottal_price' => $_SESSION['cart']['tottal_price'],
            'delivery_price' => $_SESSION['cart']['delivery_price'],
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

        // условия скидки
        if ($_SESSION['cart']['tottal_price'] >= 700) {
            $_SESSION['cart']['delivery_price'] = 0;
        } else if ($_SESSION['cart']['tottal_price'] < 700) {
            $_SESSION['cart']['delivery_price'] = 150;
        }

        return view('site.cart', [
            'tottal_price' => $_SESSION['cart']['tottal_price'],
            'delivery_price' => $_SESSION['cart']['delivery_price'],
            'products' => $_SESSION['cart']['products'],
            'tottal_count' => $_SESSION['cart']['tottal_count']
        ]);
    }
    
    public static function getTottalCount()
    {
    		if(!isset($_SESSION)) {
    			session_start();
    			$_SESSION['cart']['tottal_count'] = 0;
    		}
    		return $_SESSION['cart']['tottal_count'];
    }

    public function sent_cart(Request $request)
    {
        session_start();

        // имя
        $name  = $request->name;

        // телефон и имя
        $phone = $request->phone;

        // адрес
        $adres = $request->adres;
        
        // комментарии
        $comments = $request->comments;

        // наличные или карта
        $maney = $request->cash;
        
        // стоимость доставки
        // $delivery_price = $request->delivery_price;
        
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
        $tottal_price = $_SESSION['cart']['tottal_price'] + $_SESSION['cart']['delivery_price'];
        $tottal_count = $_SESSION['cart']['tottal_count'];
        //Mail::to('kaliummati@gmail.com', 'Чердак')->send(new MeilCart($name, $phone, $adres, $maney, $manyback, $back, $products, $tottal_price, $tottal_count));
        
        Mail::send('mail', 
        [
            'id' => rand(100, 999),
            'name' => $name,
            'phone' => $phone,
            'adres' => $adres,
            'comments' => $comments,
            'maney' => $maney,
            // 'delivery_price' => $_SESSION['cart']['delivery_price'],
            'manyback' => $manyback,
            'back' => $back,
            'products' => $products,
            'tottal_price' => $tottal_price,
            'tottal_count' => $tottal_count
        ], function ($message) {
            $message->from('cherdak.khv@bk.ru', 'Пиццерия "Чердак"');
            $message->to('cherdak.khv@bk.ru', 'еуые')->subject('Сообщение с сайта "Чердак"');
            
        });

        unset($_SESSION['cart']);
    }
}
