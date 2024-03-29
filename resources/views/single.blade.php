@extends('main')
@section('head')
@php
$motor_meta=[];
$meta = json_decode($product->metas);
if($meta==null){
$motor_meta['title']='';
$motor_meta['description']='';
$motor_meta['alt']='';
$motor_meta['keywords']='';
}else{
$motor_meta['title']= $meta->meta_title;
$motor_meta['description']=$meta->meta_description;
$motor_meta['keywords']=$meta->meta_keywords;
$motor_meta['alt']=$meta->meta_alt;

}
$motor_meta['name']=$product->name;
$motor_meta['canonical']=$product->canonical;
$motor_meta['slug']=$product->slug;
$meta = '';
@endphp

@include('parts.head',['meta'=>$meta],['motor_meta'=>$motor_meta])
@endsection
@section('content')
@include('js.order-conf')
<script type="module">
    import Swiper from "{{asset('js/swiper.min.js')}}";

    const productCardGalleryThumbs = new Swiper(".product-card__gallery-thumbs", {
        spaceBetween: 20,
        slidesPerView: 5,
        watchSlidesProgress: true,
        breakpoints: {
            768: {
                spaceBetween: 0
            }
        }
    });

    const productCardGalleryMain = new Swiper(".product-card__gallery-main", {
        spaceBetween: 10,
        thumbs: {
            swiper: productCardGalleryThumbs,
        },
    });

    const productCardSeriesSlider = new Swiper(".product-card__series-slider", {
        init: false,
        loop: true,
        navigation: {
            nextEl: '.product-card__series-slider-button-next',
            prevEl: '.product-card__series-slider-button-prev',
        },
        breakpoints: {
            768: {
                slidesPerView: 2,
                spaceBetween: 48,
            },
            1024: {
                slidesPerView: 3,
                spaceBetween: 10,
            },
            1440: {
                slidesPerView: 4,
                spaceBetween: 20,
            },
        }
    })

    if (window.innerWidth >= 768) {
        productCardSeriesSlider.init();
    }

    function toggleHeaderOrderBtnClassOnScroll() {
        const headerOrderBtn = document.querySelector('.header__order-btn');

        window.addEventListener('scroll', () => {
            // console.log(window.pageYOffset + 'px');

            if (window.pageYOffset >= 700) {
                headerOrderBtn.classList.add('active');
            } else {
                headerOrderBtn.classList.remove('active');
            }
        })
    }

    toggleHeaderOrderBtnClassOnScroll();
</script>
<main>
    <nav class="breadcrumbs">
        <div class="container">
            <ul role="list">
                <li><a href="/">Главная</a></li>
                <li><a href="/catalog">Каталог</a></li>
                <li><a href="/catalog?typeOfTransmission={{$category->id}}">{{$category->name}}</a></li>
                <li><a href="/catalog?typeOfTransmission={{$category->id}}&series={{$product->series->name}}">{{$product->series->name}}</a></li>
                <li><a href="#">{{$product->name}}</a></li>
            </ul>
        </div>
    </nav>
    <section class="product-card">
        <div class="container">
            <h1 class="title title-h2 product-card__title">
                <a class="previous-page-link" href="javascript:history.go(-1)">
                    <svg width="18" height="32" data-aos="fade-up" data-aos-easing="linear" data-aos-delay="250">
                        <use xlink:href="{{asset('resources/svgSprites/svgSprite.svg#product-title-arrow')}}"></use>
                    </svg>
                </a>
                {{$product->name}}
            </h1>
            <div class="product-card__grid">
                <div class="product-card__main">
                    <div class="product-card__gallery" data-aos="fade-in" data-aos-delay="200">
                        <div class="product-card__gallery-main swiper">
                            <ul class="swiper-wrapper" role="list">
                                <li class="swiper-slide">
                                    <img loading="lazy" decoding="async" src="{{asset('storage/'.$product->firstImage())}}" alt="{{$product->name}}" width="328" height="220">
                                </li>
                                @foreach($product->images as $image)
                                <li class="swiper-slide">
                                    <img loading="lazy" decoding="async" src="{{asset('storage/'.$image)}}" alt="{{$product->name}}" width="328" height="220">
                                </li>
                                @endforeach

                            </ul>
                        </div>
                        <div class="product-card__gallery-thumbs swiper">
                            <ul class="swiper-wrapper" role="list">
                                <li class="swiper-slide">
                                    <img loading="lazy" decoding="async" src="{{asset('storage/'.$product->firstImage())}}" alt="{{$product->name}}" width="50" height="50">
                                </li>
                                @foreach($product->images as $image)

                                <li class="swiper-slide">
                                    <img loading="lazy" decoding="async" src="{{asset('storage/'.$image)}}" alt="{{$product->name}}" width="50" height="50">
                                </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                    <button class="primary-btn order-btn order-btn--adaptive" type="button" @click="orderForm = true">Запросить</button>
                </div>
                <aside class="product-card__aside">
                    <details class="product-card__details">
                        <summary>
                            <div class="product-card__details-title">
                                <h3>Тип передачи</h3>
                                <h4>{{$category->name}}</h4>
                            </div>
                            <svg width="16" height="16">
                                <use xlink:href="{{asset('resources/svgSprites/svgSprite.svg#icon-dropdown')}}"></use>
                            </svg>
                        </summary>
                        <ul role="list">
                            @foreach($product->details() as $name => $value)
                                <li><p>{{$name}}</p><span>{{$value}}</span></li>
                            @endforeach

                        </ul>
                    </details>
                    <ul role="list" class="product-card__list">
                    @foreach($product->details() as $name => $value)
                            <li><p>{{$name}}</p><span>{{$value}}</span></li>
                    @endforeach
                    </ul>
                    <button class="primary-btn order-btn order-btn--desktop" type="button" @click="orderForm = true">Запросить</button>
                </aside>
            </div>

            @if($product->productsFromSeries()->isNotEmpty())
            <div class="product-card__series-slider-wrapper">
                <h3 class="product-card__series-slider-title">Редукторы этой серии</h3>
                <div class="swiper-button-prev product-card__series-slider-button-prev">
                    <svg width="19" height="41">
                        <use xlink:href="{{asset('resources/svgSprites/svgSprite.svg#icon-slider-left')}}"></use>
                    </svg>
                </div>
                <div class="swiper-button-next product-card__series-slider-button-next">
                    <svg width="19" height="41">
                        <use xlink:href="{{asset('resources/svgSprites/svgSprite.svg#icon-slider-right')}}"></use>
                    </svg>
                </div>
                <div class="product-card__series-slider swiper">
                    <ul role="list" class="swiper-wrapper product-card__series-slider-list">
                        @forelse($product->productsFromSeries() as $one)
                        <li class="swiper-slide product-card__series-slider-list-item">
                            <a href="/catalog/{{$one->category->slug}}/{{$one->slug}}" class="product-card__series-slider-link">
                                <h4 class="product-card__series-slider-list-title">{{$one->name}}</h4>
                                <img loading="lazy" decoding="async" src="{{asset('storage/images/products/'.$one->image)}}" alt="image" width="111" height="120" class="product-card__series-slider-img">
                            </a>
                        </li>
                        @empty
                        @endforelse
                    </ul>
                </div>
            </div>
            @endif

            <div class="product-card__info">
                <ul class="product-card__tabs" role="list">
                    <li @click="toggleProductCardTabs(event,'productCardDescr')" class="active">
                        <h3>Описание</h3>
                    </li>
                    @if($product->product_characteristics != null)
                    <li @click="toggleProductCardTabs(event,'productCardChars')">
                        <h3>Характеристики</h3>
                    </li>
                    @endif
                    <li @click="toggleProductCardTabs(event,'productCardSizes')">
                        <h3>Размеры</h3>
                    </li>
                    <li @click="toggleProductCardTabs(event,'productCardQuestionAnswer')">
                        <h3>Вопрос-ответ</h3>
                    </li>
                </ul>
                <div class="product-card-info product-card__descr" id="productCardDescr" style="max-height: 100%;">
                        {!! $product->description !!}
                </div>
                @if($product->product_characteristics != null)

                <div class="product-card-info product-card__chars product-card__sizes" id="productCardChars">
                        {!! $product->product_characteristics !!}
                </div>
                @endif
                @if(!empty($product->dimensions))
                <div class="product-card-info product-card__sizes" id="productCardSizes">
                    @if(isset($product->dimensions->reducer))
                        <h4>Чертеж редуктора</h4>
                    <div class="product-card__sizes-big-svg">
                        {{$product->getSvg($product->dimensions->reducer)}}
                    </div>
                    @endif
                    @if(isset($product->dimensions->shafts))
                        <h4>Присоединительные размеры входных и выходных валов:</h4>
                        <ul role="list" class="product-card__sizes-list">
                        @foreach($product->dimensions->shafts as $dimension)
                            <li>
                                <h4>{{$dimension->title}}</h4>
                                {{$product->getSvg($dimension->content)}}
                            </li>
                        @endforeach
                        </ul>
                    @endif
                    @if(isset($product->dimensions->buildOptions))
                        <h4>Варианты сборки</h4>
                        <div class="product-card__sizes-big-svg">
                            {{$product->getSvg($product->dimensions->buildOptions)}}
                        </div>
                    @endif
                </div>
                @endif
                <div class="product-card-info product-card__question-answer" id="productCardQuestionAnswer">
                    <div class="product-card__question-answer-top">
                        <h3>Нужно больше информации?</h3>
                        <p>Напишите свой вопрос и наши менеджеры свяжутся с Вами в максимально короткое время.</p>
                    </div>
                    <div>
                        <form action="/send-form/reducer" class="request-form" method="post" id="quest">
                            @csrf
                            @php
                            $attributes = []
                            @endphp
                            <fieldset>
                                <div class="request-form__input-group">
                                    <label for="name">Ваше имя</label>
                                    <div class="form-controls-wrapper request-form__form-controls-wrapper">
                                        <input type="text" name="name" id="name" placeholder="Иван" required>
                                        <input type="hidden" name="id" value="{{$product->id}}">
                                        <?php
                                        echo '<input type="hidden" name="link" value="http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] . '">'
                                        ?>
                                        <svg class="icon-error" width="28" height="28">
                                            <use xlink:href="{{asset('resources/svgSprites/svgSprite.svg#icon-error')}}"></use>
                                        </svg>
                                        <svg class="icon-correct" width="28" height="28">
                                            <use xlink:href="{{asset('resources/svgSprites/svgSprite.svg#icon-correct')}}"></use>
                                        </svg>
                                    </div>
                                </div>
                                <div class="request-form__input-group">
                                    <label for="email">Ваш e-mail</label>
                                    <div class="form-controls-wrapper request-form__form-controls-wrapper">
                                        <input type="email" name="email" id="email" placeholder="ivan@mail.ru" required>
                                        <svg class="icon-error" width="28" height="28">
                                            <use xlink:href="{{asset('resources/svgSprites/svgSprite.svg#icon-error')}}"></use>
                                        </svg>
                                        <svg class="icon-correct" width="28" height="28">
                                            <use xlink:href="{{asset('resources/svgSprites/svgSprite.svg#icon-correct')}}"></use>
                                        </svg>
                                    </div>
                                </div>
                                <div class="request-form__input-group">
                                    <label for="textarea">Задайте вопрос</label>
                                    <div class="form-controls-wrapper request-form__form-controls-wrapper">
                                        <textarea name="textarea" id="textarea" placeholder="Введите текст" required></textarea>
                                    </div>
                                </div>
{{--                                {!! Captcha::display($attributes) !!}--}}
                                <button type="submit" class="secondary-btn request-form__submit-btn">Задать вопрос</button>
                            </fieldset>
                        </form>
                    </div>
                    <nav class="product-card-answers-list">
                        <h3>Ответы</h3>
                        <ul role="list">

                            @foreach($quest as $one)
                            @if(isset($one->status))
                            @if($one->status->name == 'Отвечено' && !empty($one->answer))
                            <li>
                                <div class="product-card-answers-list__top">
                                    <p>{{$one->name}}</p>
                                    <time datetime="2022-04-25">{{$one->created_at}}</time>
                                </div>
                                <p class="product-card-answers-list__text">
                                    {{$one->question}}
                                </p>
                                <div class="product-card-answers-list__answer">
                                    <p>Ответ:</p>
                                    <span> {{$one->answer}}</span>
                                </div>
                            </li>
                            @endif @endif

                            @endforeach
                        </ul>
                    </nav>
                    <ul class="pagination product-card-answers-list__pagination" role="list">
                        {{$quest->links('vendor.pagination.semantic-ui')}}
                    </ul>

                </div>
            </div>
        </div>
    </section>
    <script>
        function toggleProductCardTabs(evt, tab) {
            let productCardsInfo, productCardTabs, currentTab;
            productCardsInfo = document.querySelectorAll(".product-card-info");
            productCardTabs = document.querySelectorAll(".product-card__tabs li");
            currentTab = document.getElementById(tab);

            productCardsInfo.forEach(element => {
                element.style.maxHeight = null;
            });

            productCardTabs.forEach(element => {
                element.className = element.className.replace("active", "");
            });

            currentTab.style.maxHeight = "fit-content";
            // console.log(currentTab.getElementsByTagName('ul')[0].offsetHeight + "px")
            evt.currentTarget.className += "active";
        }
    </script>

</main>
<div class="order-form" :class="{'active': orderForm === true}" x-data="{@for($i=0;$i<count($configurator->fields());$i++)
 activateNextStep{{$i}}: false, showTooltip{{$i}}: false, listAttributeName{{$i}}: '', listAttributeValue{{$i}}: '',
 @endfor nextStep: false,  showTooltip1: true, showTooltip2: true, activateCheckbox: false }">
    <div class="order-form__content" data-simplebar>
        <form action="/makeOrder" id="makeOrder" method="post">
{{--            <textarea style="display: none" name="details" id="" cols="30" rows="10">{{$product->adminDetails()}}</textarea>--}}
            <input type="hidden" name="product_name" value="{{$product->name}}">
            <input type="hidden" name="product_id" value="{{$product->id}}">
            @csrf
            <div class="order-form__step-page order-form__step-page-1" x-data="{ showFields: true }">
                <div class="order-form__step-top">
                    <p class="order-form__step">Шаг 1 из 2</p>
                    <svg @click="orderForm = false" width="36" height="36">
                        <use xlink:href="{{asset('resources/svgSprites/svgSprite.svg#icon-exit')}}"></use>
                    </svg>
                </div>
                <h3 class="title title-h3 users-conf-name">{{$product->name}};</h3>
                <fieldset>
                    @foreach($configurator->fields() as $field)


                        {{$field->render()}}
                    @endforeach
                    <div class="order-form__accept-label">
                        <input type="checkbox" name="accept" id="accept">
                        <label for="accept" @click="activateCheckbox = true;nextStep = true">Отметьте, если не знаете, что выбрать.</label>
                    </div>
                    <button type="button" id="nextStep" class="primary-btn order-form__submit-btn order-form__next-step-btn disable" x-bind:class="{ 'active':  @for($i=0;$i<count($configurator->fields());$i++)
 activateNextStep{{$i}} === true @if($i!=count($configurator->fields())-1) && @endif
 @endfor}" @click="showTooltip1 = false;showTooltip2 = false;nextStep = true">Следующий шаг</button>
                    <!-- <button type="button" id="nextStep" class="primary-btn order-form__submit-btn order-form__next-step-btn" @click="showTooltip1 = false;showTooltip2 = false;nextStep = true" x-show="activateCheckbox === true">Следующий шаг</button> -->
                </fieldset>
            </div>
            <div class="order-form__step-page order-form__step-page-2" :class="{'active': nextStep === true}">
                <div class="order-form__step-top">
                    <p class="order-form__step order-form__step-2" @click="nextStep = false;activateCheckbox = false">
                        <svg width="18" height="36">
                            <use xlink:href="{{asset('resources/svgSprites/svgSprite.svg#product-title-arrow')}}"></use>
                        </svg>Шаг 2 из 2
                    </p>
                    <svg @click="orderForm = false" width="36" height="36">
                        <use xlink:href="{{asset('resources/svgSprites/svgSprite.svg#icon-exit')}}"></use>
                    </svg>
                </div>
                <h2 class="title title-h2">Отправить заявку</h2>
                <h3 class="title title-h3 users-conf-name">{{$product->name}};</h3>
                <fieldset>
                    <div class="order-form__product-dropdown" x-data="{selectDropdownList: '',toggleDropdownList: false}">
                        <div class="order-form__product-dropdown-top" @click="toggleDropdownList = !toggleDropdownList">
                            <div class="order-form__product-dropdown-title">
                                <p>Тип передачи</p>
                                <span>{{$category->name}}</span>
                            </div>
                            <div class="modalable">

                            </div>

                            <svg :class="{'active': toggleDropdownList}" width="16" height="16">
                                <use xlink:href="{{asset('resources/svgSprites/svgSprite.svg#icon-dropdown')}}"></use>
                            </svg>
                        </div>
                        <ul role="list" class="order-form__product-dropdown-list" id="users-list" x-ref="selectDropdownList" x-bind:style="toggleDropdownList === true ? 'height: ' + $refs.selectDropdownList.scrollHeight + 'px' : ''" :class="{'active': toggleDropdownList === true}">
                            @foreach($product->details() as $name => $value)
                            <li>
                                <p>{{$name}}</p>
                                <span>{{$value}}</span>
                            </li>
                            @endforeach
{{--                            <li>--}}
{{--                                <p>Количество передаточных ступеней</p>--}}
{{--                                <span>{{ $product->numberOfTransferStages===null? 'Не указано':$product->numberOfTransferStages->name}}</span>--}}
{{--                            </li>--}}
{{--                            <li>--}}
{{--                                <p>Передаточное отношение</p>--}}
{{--                                <span></span>--}}
{{--                            </li>--}}
{{--                            <li>--}}
{{--                                <p>Вариант сборки</p>--}}
{{--                                <span></span>--}}
{{--                            </li>--}}
{{--                            <li>--}}
{{--                                <p>Вал входной</p>--}}
{{--                                <span></span>--}}
{{--                            </li>--}}
{{--                            <li>--}}
{{--                                <p>Вал выходной</p>--}}
{{--                                <span></span>--}}
{{--                            </li>--}}
                        </ul>
                    </div>
                    <div class="order-form__input-group">
                        <label for="orderFormName">ФИО
                            <svg width="8" height="8">
                                <use xlink:href="{{asset('resources/svgSprites/svgSprite.svg#required-icon')}}"></use>
                            </svg>
                        </label>
                        <div class="form-controls-wrapper order-form__form-controls-wrapper">
                            <input type="text" name="user_name" id="orderFormName" placeholder="Ваше имя" required>
                            <svg class="icon-error" width="28" height="28">
                                <use xlink:href="{{asset('resources/svgSprites/svgSprite.svg#icon-error')}}"></use>
                            </svg>
                            <svg class="icon-correct" width="28" height="28">
                                <use xlink:href="{{asset('resources/svgSprites/svgSprite.svg#icon-correct')}}"></use>
                            </svg>
                        </div>
                    </div>
                    <div class="order-form__input-group">
                        <label for="orderFormMail">E-mail
                            <svg width="8" height="8">
                                <use xlink:href="{{asset('resources/svgSprites/svgSprite.svg#required-icon')}}"></use>
                            </svg>
                        </label>
                        <div class="form-controls-wrapper order-form__form-controls-wrapper">
                            <input type="text" name="user_email" id="orderFormMail" placeholder="ivan@mail.ru" required>
                            <svg class="icon-error" width="28" height="28">
                                <use xlink:href="{{asset('resources/svgSprites/svgSprite.svg#icon-error')}}"></use>
                            </svg>
                            <svg class="icon-correct" width="28" height="28">
                                <use xlink:href="{{asset('resources/svgSprites/svgSprite.svg#icon-correct')}}"></use>
                            </svg>
                        </div>
                    </div>
                    <div class="order-form__input-group">
                        <label for="orderFormTel">Телефон</label>
                        <div class="form-controls-wrapper order-form__form-controls-wrapper">
                            <input type="text" name="user_phone" id="orderFormTel" placeholder="8-999-99-99-99" required>
                            <svg class="icon-error" width="28" height="28">
                                <use xlink:href="{{asset('resources/svgSprites/svgSprite.svg#icon-error')}}"></use>
                            </svg>
                            <svg class="icon-correct" width="28" height="28">
                                <use xlink:href="{{asset('resources/svgSprites/svgSprite.svg#icon-correct')}}"></use>
                            </svg>
                        </div>
                    </div>
                    <div class="order-form__input-group" style="padding-bottom:0;">
                        <label for="textarea">Комментарий</label>
                        <div class="form-controls-wrapper order-form__form-controls-wrapper">
                            <textarea name="user_comment" id="textarea" placeholder="Введите текст"></textarea>
                        </div>
                    </div>
                    <div class="order-form__accept-label order-form__accept-label--policy">
                        <input type="checkbox" name="acceptPolicy" id="acceptPolicy" required>
                        <label for="acceptPolicy"><a href="#">Подтверждаю согласие с политикой конфиденциальности</a></label>
                    </div>
{{--                    {!! Captcha::display($attributes) !!}--}}
                    <button type="submit" class="primary-btn order-form__submit-btn" @click="console.log('click')">Отправить заявку</button>
                </fieldset>
            </div>
        </form>
    </div>
</div>
@endsection
