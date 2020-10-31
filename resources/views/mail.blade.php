<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Сообщение с сайта "Чердак"</title>
    <style>
        table {
            border-collapse: collapse;
            border: 1px solid black;
        }
        td {
            padding: 5px;
            border: 1px solid black;
        }
        th {
            border: 1px solid black;
        }
        p {
            margin-top: 5px;
            margin-bottom: 5px;
        }
    </style>
</head>
<body>
    <p><strong>ID заказа: {{$id}}</strong></p>
    <p>Имя заказчика: {{$name}}</p>
    <p>Телефон: <a href="tel:{{$phone}}">{{$phone}}</a></p>
    <p>Адрес: {{$adres}}</p>
    <p>Кмментарии: {{$comments}}</p>
    <p>Сумма заказа: {{$tottal_price}} р.</p>
    <p>Стоимость доставки: {{$_SESSION['cart']['delivery_price']}} р.</p>
    @if ($maney == 'cash') 
        <p>Способ оплаты: наличные</p>
        @if ($back != 0) 
            <p>Сдача с {{$back}} р.</p>
        @else
            <p>Без сдачи</p>
        @endif
    @elseif ($maney == 'card')
        <p>Способ оплаты: карта</p>
    @endif

    <table>
        <tr>
            <th>Категория</th>
            <th>Наименование</th>
            <th>Цена за ед.</th>
            <th>Вес</th>
            <th>Количество</th>
        </tr>
        @foreach ($products as $product)
            <tr>
                <td>{{$product['category']}}</td>
                <td>{{$product['name']}}</td>
                <td>{{$product['price']}}р.</td>
                <td>{{$product['size'] . $product['unit']}}</td>
                <td>{{$product['count'] . 'ед'}}</td>
            </tr>
        @endforeach
    </table>
</body>
</html>