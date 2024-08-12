<input type="hidden" name="" value="{{ cartTotal() }}" id="cart_total">
<input type="hidden" name="" value="{{count(Cart::content())}}" id="cart_product_count">
@foreach (Cart::content() as $cartProduct)
    <li>
        <div class="menu_cart_img">
            <img src="{{ asset('storage/' . $cartProduct->options->product_info['image']) }}" alt="menu"
                class="img-fluid w-100">
        </div>
        <div class="menu_cart_text">
            <a class="title"
                href="{{ route('product.detail', $cartProduct->options->product_info['slug']) }}">{!! $cartProduct->name !!}</a>
            <p class="size">quantity: {{ $cartProduct->qty }}</p>
            <p class="size">{{ @$cartProduct->options->product_size['name'] }}</p>
            @foreach ($cartProduct->options->product_options as $option)
                <span class="extra">{{ $option['name'] }}</span>
            @endforeach
            <p class="price">{{ currencyPosition($cartProduct->price) }}</p>
        </div>
        <span class="del_icon" onclick="removeProductFormSidebar('{{$cartProduct->rowId}}')"><i class="fal fa-times"></i></span>
    </li>
@endforeach
