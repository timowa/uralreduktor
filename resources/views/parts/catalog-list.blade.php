<ul class="catalog-list" role="list">
    @php
    $it = 0;

    @endphp
    @foreach($products as $product)
    @php
    $it++;
    if($it==4){
    $it=1;
    }
    @endphp
    <li data-aos="fade-in" data-aos-delay="{{$it*200}}" data-aos-once="true">
    <a href="{{route('productPage',[$product->category->slug,$product->slug])}}" class="catalog-card__link"></a>
        <figure class="catalog-card">
            <div class="catalog-card__main">
                <div class="catalog-card__top">
                    <picture>
                        <img src="{{asset('storage/'.$product->firstImage())}}" loading="lazy" decoding="async" width="328" height="264">
                    </picture>
                    <figcaption>
                    <h3 class="title title-h3">{{$product->name}}</h3>
                   </figcaption>
                    <ul class="catalog-card__descr catalog-card__descr--pos-abs">
                        @foreach($product->details() as $name => $value)
                            <li><p>{{$name}}</p><span>{{$value}}</span></li>
                        @endforeach
                    </ul>
                </div>
{{--                 <div class="catalog-card__link-btn-wrapper">--}}
{{--                    <a href="{{route('productPage',[$product->category->slug,$product->slug])}}" class="secondary-btn catalog-card__link-btn">Подробнее</a>--}}
{{--                </div>--}}
            </div>
            <div class="catalog-card__aside">
                <ul class="catalog-card__descr">
                    @foreach($product->details() as $name => $value)
                        <li><p>{{$name}}</p><span>{{$value}}</span></li>
                    @endforeach
                </ul>
            </div>
        </figure>
    </li>
    @endforeach
</ul>
