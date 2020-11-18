@if (!empty($products))
    <table>
        @foreach ($products as $id => $product)
            <tr class="with_border">
                <td valign="middle">
                    <p style="margin: 0 0px 0px 0px; width: 167px !important;" class="name">{{$product['name']}}</p>
                    {{-- <p style="width: 130px;" class="description">{{$product['description']}}</p> --}}
                </td>

                <td valign="middle">
                    <p style="white-space: nowrap; margin: 0 -50px 0 50px;" class="count">
                        <span style="cursor: pointer;" class="minus" data-url="{{route('minus', $id)}}">-</span>
                        <span style="font-size: 20px !important;" class="num">{{$product['count']}}</span>
                        <span>шт</span>
                        <span style="cursor: pointer;" class="plus" data-url="{{route('plus', $id)}}">+</span>
                    </p>
                </td>

                <!--<td valign="middle">-->
                <!--    <p style="width: 35px !important; text-align: right; margin: 0 !important; padding-left: 10px !important;" class="mass">{{$product['size']}}<span style="text-align: right !important;">{{$product['unit']}}</span></p>-->
                <!--</td>-->
                
                <td valign="middle">
                    <p class="fin_pr" style="text-align: right !important;">{{$product['price']}}<span>р</span></p>
                </td>
            </tr>
            
        @endforeach

        <tr id="finish_price">
            <td colspan="3">Итого</td>
            <td id="total_price" style="width: 100px; text-align: right;">{{$tottal_price}}<span>р</span></td>
        </tr>
    <table>

    <div class="delivery">
        <input type="checkbox" name="delivery" id="delivery-checkbox">
        <label for="delivery-checkbox">Самовывоз*</label>
    </div>
    <div id="btn-block">
        <p id="else">*минимальная сумма для доставки - 800р</p>
        <a class="red_button {{$tottal_price < 800 ? 'red_button-deactive' : ''}}" href="#">Продолжить</a>
    </div>
@else
    <p style="text-align: center; color: white;">Корзина пуста</p>
@endif

<input id="cart_count" type="hidden" value="{{$tottal_price}}">
