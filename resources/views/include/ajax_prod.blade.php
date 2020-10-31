@if ($category->products->isEmpty())
    <div class="block-head">
        <span class="line-left"></span>
            <h2 class="text-mid">Пусто...</h2>
        <span class="line-right"></span>
    </div>
@else
    <div class="block-head">
        <span class="line-left"></span>
            <h2 class="text-mid">{{$category->name}}</h2>
        <span class="line-right"></span>
    </div>
@endif

<div id="products">
    
    @foreach ($category->products as $product)
        
        <div class="product">
            <div class="price">
                <span>{{$product->price}}</span>
                <span>руб.</span>
            </div>
            <img src="{{URL::asset('img/products/' . $product->img)}}" alt="{{$product->name}}">
            <h3 style="height: 58px;">{{$product->name}}</h3>
            <div class="description">
                <span>{{$product->description}}</span>
            </div>
            <div style="" class="size">
            <span>{{$product->size . $product->unit}}</span>
            </div>
            <div 
                class="basket"
                data-category="{{$category->name}}"
                data-id="{{$product->id}}"
                data-name="{{$product->name}}"
                data-description="{{$product->description}}"
                data-price="{{$product->price}}"
                data-size="{{$product->size}}"
                data-unit="{{$product->unit}}"
                data-url={{route('add_to_cart')}}
            >
                <span>В корзину</span>
            </div>
        </div>

    @endforeach

</div>
