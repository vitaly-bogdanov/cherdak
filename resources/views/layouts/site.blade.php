<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    {{-- Защита от csrf --}}
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Пиццерия "Чердак"</title>

    <link rel="stylesheet" href="{{URL::asset('css/main.min.css')}}">
</head>
<body>
    <header>
        <div id="top-line"></div>
        <div class="container">
            <div id="head">

                <div class="logo">
                    <img src="{{URL::asset('img/logo.png')}}" alt="logo">
                </div>

                <div id="nav-bar">
                    <div id="top-contacts">
                        <span><a href='tel:+74212776097' style='text-decoration:none; color:black;'>+7(4212) 77-60-97</a></span>
                        <span><a class="link" href="#s5" style='text-decoration:none; color:black;'>г. Хабаровск, ул. Королёва, 2</a></span>
                    </div>
                    <nav style="padding-left: 5%; padding-right: 5%;">
                        <a class="link" href="#scroll-menu">Меню</a>
                        <span>|</span>
                        <a class="link" href="#s4">Доставка</a>
                        <span>|</span>
                        <a class="link" href="#bot-contacts">Контакты</a>
                    </nav>
                </div>

            </div>
        </div>
    </header>

    <section id="s1">
        <div class="container">
            <div id="banner" data-lelt="{{URL::asset('img/pizza_left.png')}}" data-right="{{URL::asset('img/pizza_right.png')}}">
                <div class="owl-carousel owl-theme">
					
					<!-- Вывод баннеров -->
                    @foreach ($banners as $banner)
                        <img src="{{URL::asset('img/banners/' . $banner->img)}}" alt="{{$banner->name}}">
                    @endforeach
                
                </div>
            </div>
        </div>
    </section>

    <section id="s2">
        <div class="container">
            <div id="menu">
                <div class="block-head">
                    <span class="line-left"></span>
                    <h2 id="scroll-menu" class="text-mid">Меню</h2>
                    <span class="line-right"></span>
                </div>

                <div id="menu-btn">
                    <p id="open_menu">
                        Показать всё
                    </p>
                    <div id="links">

                        <!-- Выводим менею -->
                        @foreach ($menu as $item)
                            <a class="ajax-link link link" href="{{route('choice', ['id' => $item->id])}}" data-href="{{route('ajax_cart', $item->id)}}">
                                <span>{{$item->name}}</span>
                            </a> <br>
                        @endforeach

                    </div>
                </div>

                <div id="choice">

                    <!-- Выводим менею -->
                    @foreach ($menu as $item)
                        <a class="ajax-link element-menu" href="{{route('choice', ['id' => $item->id])}}" data-href="{{route('ajax_cart', $item->id)}}">
                            <span>{{$item->name}}</span>
                        </a>
                    @endforeach

                </div>

            </div>
        </div>
    </section>

    <section id="s3">
        <div class="container">
            <div id="content" style="margin-top: 0px;margin-bottom: 0;border-top: 2px dashed #582a12;padding-top: 0px;color: #582a12;font-size: 25px;text-align: center;font-family: RotondaCbold;">
                @yield('content')
            </div>
        </div>
    </section>


    <section id="s4">
        <div class="container">
            <div id="delivery">
                {{--<div class="block-head">--}}
                    {{--<span class="line-left"></span>--}}
                    {{--<h2 class="text-mid">Доставка</h2>--}}
                    {{--<span class="line-right"></span>--}}
                {{--</div>--}}
                <div id="terms">
                    <h4>Условия доставки</h4>
                    <p>Мы обслуживаем ограниченную территорию города. Стоимость доставки 150 рублей. При заказе от 700 рублей, доставка бесплатная. Уточнить возможность доставки на интересующий Вас адрес можно по карте города. Ну и конечно, заказ можно забрать самостоятельно.</p>
                    <p>Заказ можно будет оплатить наличными или банковской картой при получении. В случае оплаты наличными указывайте необходимость в сдаче, и с какой суммы.</p>
                    <p>Время доставки зависит от загруженности кухни и дорожной обстановки в городе на момент доставки. Среднее время доставки - 45 минут с момента оформления заказа. Если заявка делается на определенное время, погрешность при доставке составляет ±30 минут.</p>
                    <p>Заявки, поступившие в нерабочие часы пиццерии, будут обработаны не сразу. При заказе на сайте - наш менеджер свяжется с Вами по указанному в заявке номеру телефона для подтверждения заказа. Заказ будет принят в работу только после подтверждения Вами заказа.</p>
                </div>
            </div>
        </div>
    </section>

    <section id="s5">
        <div class="container">
            <div id="map">
                <div class="block-head">
                    <span class="line-left"></span>
                    <h2 class="text-mid">Территория доставки</h2>
                    <span class="line-right"></span>
                </div>
                <!--<iframe src="https://yandex.ru/map-widget/v1/-/CBRyUWFwGA" width="100%" height="660" frameborder="1" allowfullscreen="true" scroll="false"></iframe>-->
                <script type="text/javascript" charset="utf-8" async src="https://api-maps.yandex.ru/services/constructor/1.0/js/?um=constructor%3A2b4d42018dc1ef72f25c862bd0de5913ee19d85715d1cd21f7ddf334c263393d&amp;width=100%&amp;height=660&amp;margin-top:50px;&amp;lang=ru_RU&amp;scroll=false&amp;margin-top:50px"></script>
            </div>
        </div>
    </section>

    <footer>
        <div class="container">
            <div id="foot">
                <div class="logo">
                    <img src="{{URL::asset('img/logo.png')}}" alt="logo">
                </div>

                <div id="bot-contacts">
                    <p><a href="tel:+74212776097" style="text-decoration:none; color:black;">+7(4212) 77-60-97</a></p>
                    <p><a href="https://www.instagram.com/Cherdak.khv/">@Cherdak.khv</a></p>
                    <p><a href="mailto:cherdak.khv@bk.ru">cherdak.khv@bk.ru</a></p>
                    <p>680045, г. Хабаровск, <br> ул. Королёва, 2 (2 этаж)</p>
                </div>
                
                <div id="work">
                    <p>Режим работы доставки: <br> пн-чт, вскр - 11:00 до 22:30 <br> пт, сб - 11:00 до 23:30 <br> <!--сб - 12:00 до 01:00 <br> вскр - 12:00 до 23:00--></p>
                    <p>График работы кафе: <br> пн-чт, вскр - 11:00 до 23:00 <br> пт, сб - 11:00 до 00:00 <br> <!--сб - 12:00 до 01:00 <br> вскр - 12:00 до 23:00--></p>
                </div>
            </div>
        </div>
        <div id="bot-line">
            <span>© 2019 Пиццерия «Чердак»&nbsp;</span>
            <span>ИП Шамшин Антон Васильевич&nbsp;</span>
            <span>ИНН 272316491334</span>
        </div>
    </footer>

    <div id="overlay">
    
    </div>

    <div id="basket">
        <div id="buy">
            <div id="block">
                <div class="close">X</div>
                <p id="head-basket">Корзина</p>
                <div id="ordered_goods">
                    
                </div>
            </div>
        </div>
    </div>

    <div id="border1">
        <div id="border2">
            <div id="win">
                <div class="close">X</div>
                <form id="sent-request" action="{{route('sent_cart')}}" method="POST">
                    @csrf
                    <p class="request-head">Оставьте заявку</p>
                    <input type="text" name="name" placeholder="Имя*" required>
                    <input type="text" name="phone" placeholder="Телефон*" required>
                    <input type="text" name="adres" placeholder="Адрес*" required>
                    <input type="text" name="comments" placeholder="Комментарии">
                    <p class="request-head mrg-fix">Способ оплаты</p>

                    <input type="radio" name="cash" value="cash" id="cash1" checked>
                    <label for="cash1">Наличные</label> <br>

                    <input type="radio" name="cash" value="card" id="cash2">
                    <label for="cash2">Карта</label> <br>

                    <div id="ifcash">
                        <input type="radio" name="manyback" value="no" id="cash3" checked>
                        <label for="cash3">Без сдачи</label> <br>
        
                        <input type="radio" name="manyback" value="yes" id="cash4">
                        <label for="cash4"><span>Сдача с</span><input maxlength="4" name="sum" class="many" type="text"><span>руб.</span></label> <br>
                
                    </div>

                    <p id="conf">Нажимая кнопку «оформить заказ» я соглашаюсь с обработкой моих персональных данных в соответствии с <a href="{{URL::asset('politica.pdf')}}" target="_blank">политикой конфиденциальности</a>.</p>

                    <input style="outline: none;" type="submit" value="Отправить">

                </form>
            </div>
        </div>
    </div>

    <div id="fixed-basket" style="z-index: 999;" data-url="{{route('view_cart')}}">
        <img src="{{URL::asset('img/cart.png')}}" alt="cart">
        <div id="count">
            <span>{{$tottal_count}}</span>
        </div>
    </div>

    <script src="{{URL::asset('js/libs.min.js')}}"></script>
    <script src="{{URL::asset('js/common.min.js')}}"></script>
    <!-- Yandex.Metrika counter --> <script type="text/javascript" > (function(m,e,t,r,i,k,a){m[i]=m[i]||function(){(m[i].a=m[i].a||[]).push(arguments)}; m[i].l=1*new Date();k=e.createElement(t),a=e.getElementsByTagName(t)[0],k.async=1,k.src=r,a.parentNode.insertBefore(k,a)}) (window, document, "script", "https://mc.yandex.ru/metrika/tag.js", "ym"); ym(52340266, "init", { id:52340266, clickmap:true, trackLinks:true, accurateTrackBounce:true, webvisor:true }); </script> <!-- /Yandex.Metrika counter -->
</body>
</html>