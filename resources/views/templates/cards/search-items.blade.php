@forelse($products as $product)
<li class="header-search-menu__item">
    <a href="{{$product->href}}">
        <picture>
            <img src="{{asset('storage/images/products/'.$product->image)}}" loading="lazy" decoding="async" alt="image" width="48" height="48">
        </picture>
        <h3>{{$product->name}}</h3>
    </a>
</li>
@empty
    <li class="header-search-menu__item">
        <p>Ничего не найдено</p>
    </li>
@endforelse
