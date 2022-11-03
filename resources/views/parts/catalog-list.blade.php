
<div class="catalog__main" x-data="{series: false}">
    @if(request()->has('typeOfTransmission'))
    <h1 class="title title-h2 catalog-title"><svg width="68" height="48">
            <use xlink:href="{{asset('resources/svgSprites/svgSprite.svg#'.$categories->where("id",request()->get("typeOfTransmission"))->first()->icon)}}"></use>
        </svg>{{$categories->where('id',request()->get('typeOfTransmission'))->first()->name}}</h1>
    @endif
    <div class="catalog__main-btn-group">
        @if(request()->has('typeOfTransmission'))
        <button class="catalog-series-btn" type="button" @click="series = !series">
            <svg class="catalog-series-btn__gear-icon" width="20" height="20">
                <use xlink:href="{{asset('resources/svgSprites/svgSprite.svg#gear-icon')}}"></use>
            </svg>
            <span>Серии</span>
            <svg viewBox="0 0 36 36" fill="none" xmlns="http://www.w3.org/2000/svg" class="catalog-series-btn__exit-icon" width="14" height="14" x-show="series === true" style="display: none;">
                <path d="M30.0003 4.66666C30.3685 4.29847 30.9655 4.29847 31.3337 4.66666C31.7018 5.03485 31.7018 5.6318 31.3337 5.99998L6.00055 31.3331C5.63236 31.7013 5.03541 31.7013 4.66723 31.3331C4.29904 30.9649 4.29904 30.368 4.66722 29.9998L30.0003 4.66666Z" fill="#77738C"></path>
                <path d="M31.3333 29.9998C31.7015 30.368 31.7015 30.965 31.3333 31.3332C30.9652 31.7014 30.3682 31.7014 30 31.3332L4.66692 6.00006C4.29873 5.63187 4.29873 5.03493 4.66692 4.66674C5.03511 4.29855 5.63205 4.29855 6.00024 4.66674L31.3333 29.9998Z" fill="#77738C"></path>
            </svg>
            <svg class="catalog-series-btn__dropdown-icon" width="16" height="16" x-bind:class="{ 'active': series === true }">
                <use xlink:href="{{asset('resources/svgSprites/svgSprite.svg#icon-dropdown')}}"></use>
            </svg>
        </button>
        @endif
        <button class="filter-btn catalog-filter-btn" type="button" @click="filter = true"><svg width="68" height="48">
                <use xlink:href="{{asset('resources/svgSprites/svgSprite.svg#filter-btn-icon')}}"></use>
            </svg>Фильтры</button>
    </div>
    @if(request()->has('typeOfTransmission'))
    <nav class="catalog__series-list-nav" x-ref="catalogSeriesList" x-bind:style="series === true ? 'height: ' + $refs.catalogSeriesList.scrollHeight + 'px' : ''" :class="{'active': series === true}">
        <form action="#" class="catalog__series-list-form">
            <fieldset class="catalog__series-list-fieldset">
                <template x-if="true">
                    <ul role="list" class="catalog__series-list" x-data="{toggleBtn: {{(request()->has('series'))?$series->get($_GET['series']):'null'}}}">
                        @php
                        $items = [];
                        @endphp
                        @forelse($series as $value=>$key)
                            @php
                                if(preg_match('#^[aA-zZаА-яЯ_]+[aA-zZаА-яЯ0-9_]+$#', $value)){
                                    $item = $value;
                                }else{
                                    $item = 'item'.$key;
                                }
                                if(array_search($item,$items)){
                                    $item.='1';
                                }
                                $items[] = $item;

                            @endphp
                        <li class="catalog__series-list-item">
                            <input type="radio" name="series" value="{{$value}}" id="series-list-item-{{$key}}" class="catalog__series-list-radio" x-ref="{{$item}}">
                            <button type="button" aria-label="button" class="catalog__choice-series-btn active" x-on:click.self="toggleBtn = {{$key}}; $refs.{{$item}}.checked = true" x-bind:class="{ 'active': toggleBtn === {{$key}} }">
                                <span x-on:click.self="toggleBtn = {{$key}}; $refs.{{$item}}.checked = true">{{$value}}</span>
                                <svg class="catalog__choice-series-clear-icon" x-show="toggleBtn === {{$key}}" x-on:click.self="toggleBtn = {{$key}}; $refs.{{$item}}.checked = true" width="14" height="14" viewBox="0 0 36 36" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M30.0003 4.66666C30.3685 4.29847 30.9655 4.29847 31.3337 4.66666C31.7018 5.03485 31.7018 5.6318 31.3337 5.99998L6.00055 31.3331C5.63236 31.7013 5.03541 31.7013 4.66723 31.3331C4.29904 30.9649 4.29904 30.368 4.66722 29.9998L30.0003 4.66666Z" fill="#77738C" />
                                    <path d="M31.3333 29.9998C31.7015 30.368 31.7015 30.965 31.3333 31.3332C30.9652 31.7014 30.3682 31.7014 30 31.3332L4.66692 6.00006C4.29873 5.63187 4.29873 5.03493 4.66692 4.66674C5.03511 4.29855 5.63205 4.29855 6.00024 4.66674L31.3333 29.9998Z" fill="#77738C" />
                                </svg>
                            </button>
                        </li>
                        @empty
                        @endforelse
                    </ul>
                </template>
            </fieldset>
        </form>
    </nav>
    @endif
    <nav class="filter filter--mobile" :class="{'active': filter === true}" x-data="{filterDropdown1: false, filterDropdown2: false, filterDropdown3: false, filterDropdown4: false }">
        <button class="filter__close-btn filter__close-btn--mobile" type="button" @click="filter = false">
            <!-- <svg width="20" height="28" class="filter__close-btn-icon filter__close-btn-icon--mobile">
                            <use xlink:href="{{asset('resources/svgSprites/svgSprite.svg#catalog-filter-arrow')}}"></use>
                            </svg> -->
            <svg width="36" height="36" class="filter__close-btn-icon filter__close-btn-icon--tablet">
                <use xlink:href="{{asset('resources/svgSprites/svgSprite.svg#icon-exit')}}"></use>
            </svg>
        </button>
        <button class="filter__close-btn filter__close-btn--tablet" type="button" @click="filter = false">
            <svg width="36" height="36" class="filter__close-btn-icon filter__close-btn-icon--tablet">
                <use xlink:href="{{asset('resources/svgSprites/svgSprite.svg#icon-exit')}}"></use>
            </svg>
        </button>
{{--        <div class="container">--}}
{{--            <ul role="list">--}}
{{--                <form action="/catalog" method="get" class="filterCatalogMobile">--}}
{{--                    <li>--}}
{{--                        <div class="filter-dropdown" x-data="{filter: '', close:{{(request()->has('typeOfTransmission'))? 'true' : 'false'}}}">--}}
{{--                            <div class="filter-dropdown__top" @click="filterDropdown1 = !filterDropdown1" :class="{'active': filterDropdown1 === true}">--}}
{{--                                <p>Тип редуктора</p>--}}
{{--                                <ul class="filter-dropdown__icon-list" role="list">--}}
{{--                                    <a href="javascript:void(0)">--}}
{{--                                        <svg class="filter-dropdown__clear-list-icon " :class="close ? 'active' : ''" width="16" height="16" viewBox="0 0 36 36" fill="none" xmlns="http://www.w3.org/2000/svg" @click="filter = '', close = false" :class="{'active': filter !== ''}">--}}
{{--                                            <path d="M30.0003 4.66666C30.3685 4.29847 30.9655 4.29847 31.3337 4.66666C31.7018 5.03485 31.7018 5.6318 31.3337 5.99998L6.00055 31.3331C5.63236 31.7013 5.03541 31.7013 4.66723 31.3331C4.29904 30.9649 4.29904 30.368 4.66722 29.9998L30.0003 4.66666Z" fill="#07012E" />--}}
{{--                                            <path d="M31.3333 29.9998C31.7015 30.368 31.7015 30.965 31.3333 31.3332C30.9652 31.7014 30.3682 31.7014 30 31.3332L4.66692 6.00006C4.29873 5.63187 4.29873 5.03493 4.66692 4.66674C5.03511 4.29855 5.63205 4.29855 6.00024 4.66674L31.3333 29.9998Z" fill="#07012E" />--}}
{{--                                        </svg>--}}
{{--                                    </a>--}}
{{--                                    <svg class="filter-dropdown__arrow-icon" width="16" height="16" viewBox="0 0 28 14" fill="none" xmlns="http://www.w3.org/2000/svg">--}}
{{--                                        <rect width="19.2237" height="1.20148" transform="matrix(0.728345 -0.685211 0.728345 0.685211 13.1235 13.1724)" fill="#07012E" />--}}
{{--                                        <rect width="19.2237" height="1.20148" transform="matrix(0.728345 0.685211 -0.728345 0.685211 0.875 0.00390625)" fill="#07012E" />--}}
{{--                                    </svg>--}}
{{--                                </ul>--}}
{{--                            </div>--}}
{{--                            <ul role="list" class="filter-dropdown__list" id="filter1" x-show="filterDropdown1 === true" x-collapse.duration.500ms>--}}
{{--                                @foreach($attr1 as $attr)--}}
{{--                                    <li>--}}
{{--                                        <label>--}}
{{--                                            <input type="radio" style="display: none" value="{{$attr->id}}" name="typeOfTransmission" {{isset($_GET['typeOfTransmission'])?$_GET['typeOfTransmission']==$attr->id?'checked':'':''}}>--}}
{{--                                            @php--}}
{{--                                                $disabled = false;--}}
{{--                                                if(isset($_GET['locationOfAxes'])){--}}

{{--                                                foreach($attr->locations as $location){--}}
{{--                                                $disabled = true;--}}
{{--                                                if($location->id == $_GET['locationOfAxes']){--}}
{{--                                                $disabled = false;--}}
{{--                                                break;--}}
{{--                                                }--}}
{{--                                                }--}}
{{--                                                }--}}

{{--                                            @endphp--}}
{{--                                            <button type="button" aria-label="button" @click="filter !=={{$loop->iteration}} ?filter = {{$loop->iteration}}: filter = null, close = true" :class="{'active': filter === {{$loop->iteration}}}" {{$disabled?'disabled':''}}>{{$attr->name}}</button>--}}
{{--                                        </label>--}}
{{--                                    </li>--}}
{{--                                @endforeach--}}
{{--                            </ul>--}}
{{--                        </div>--}}
{{--                    </li>--}}
{{--                    <li>--}}
{{--                        <div class="filter-dropdown" x-data="{filter: '', close:{{(request()->has('locationOfAxes'))? 'true' : 'false'}}}">--}}
{{--                            <div class="filter-dropdown__top" @click="filterDropdown2 = !filterDropdown2" :class="{'active': filterDropdown2 === true}">--}}
{{--                                <p>Расположение осей</p>--}}
{{--                                <ul class="filter-dropdown__icon-list" role="list">--}}

{{--                                    <svg class="filter-dropdown__clear-list-icon " :class="close ? 'active' : ''" width="16" height="16" viewBox="0 0 36 36" fill="none" xmlns="http://www.w3.org/2000/svg" @click="filter = '', close = false" :class="{'active': filter !== ''}">--}}
{{--                                        <path d="M30.0003 4.66666C30.3685 4.29847 30.9655 4.29847 31.3337 4.66666C31.7018 5.03485 31.7018 5.6318 31.3337 5.99998L6.00055 31.3331C5.63236 31.7013 5.03541 31.7013 4.66723 31.3331C4.29904 30.9649 4.29904 30.368 4.66722 29.9998L30.0003 4.66666Z" fill="#07012E" />--}}
{{--                                        <path d="M31.3333 29.9998C31.7015 30.368 31.7015 30.965 31.3333 31.3332C30.9652 31.7014 30.3682 31.7014 30 31.3332L4.66692 6.00006C4.29873 5.63187 4.29873 5.03493 4.66692 4.66674C5.03511 4.29855 5.63205 4.29855 6.00024 4.66674L31.3333 29.9998Z" fill="#07012E" />--}}
{{--                                    </svg>--}}
{{--                                    <svg class="filter-dropdown__arrow-icon" width="16" height="16" viewBox="0 0 28 14" fill="none" xmlns="http://www.w3.org/2000/svg">--}}
{{--                                        <rect width="19.2237" height="1.20148" transform="matrix(0.728345 -0.685211 0.728345 0.685211 13.1235 13.1724)" fill="#07012E" />--}}
{{--                                        <rect width="19.2237" height="1.20148" transform="matrix(0.728345 0.685211 -0.728345 0.685211 0.875 0.00390625)" fill="#07012E" />--}}
{{--                                    </svg>--}}
{{--                                </ul>--}}
{{--                            </div>--}}
{{--                            <ul role="list" class="filter-dropdown__list" id="filter2" x-show="filterDropdown2 === true" x-collapse.duration.500ms>--}}
{{--                                @foreach($attr4 as $attr)--}}
{{--                                    @php--}}
{{--                                        $disabled = false;--}}
{{--                                        if(isset($_GET['typeOfTransmission'])){--}}

{{--                                        foreach($attr->categories as $categotyLoc){--}}
{{--                                        $disabled = true;--}}
{{--                                        if($categotyLoc->id == $_GET['typeOfTransmission']) {--}}
{{--                                        $disabled = false;--}}
{{--                                        break;--}}
{{--                                        }--}}
{{--                                        }--}}
{{--                                        }--}}

{{--                                    @endphp--}}
{{--                                    <li>--}}
{{--                                        <label>--}}
{{--                                            <input type="radio" style="display: none" value="{{$attr->id}}" name="locationOfAxes" {{isset($_GET['locationOfAxes'])?$_GET['locationOfAxes']==$attr->id?'checked':'':''}}>--}}
{{--                                            <button type="button" aria-label="button" @click="filter !=={{$loop->iteration}} ?filter = {{$loop->iteration}}: filter = null, close = true" :class="{'active': filter === {{$loop->iteration}}}" {{$disabled?'disabled':''}}>{{$attr->name}}</button>--}}
{{--                                        </label>--}}
{{--                                    </li>--}}
{{--                                @endforeach--}}
{{--                            </ul>--}}
{{--                        </div>--}}
{{--                    </li>--}}

{{--                    <li>--}}
{{--                        <div class="filter-dropdown" x-data="{filter: ''}">--}}
{{--                            <div class="filter-dropdown__top" @click="filterDropdown3 = !filterDropdown3" :class="{'active': filterDropdown3 === true}">--}}
{{--                                <p>Передаточное отношение</p>--}}
{{--                                @if(request()->has('gearRatio'))--}}
{{--                                    @php--}}
{{--                                        $gearRatio = explode(';',request()->get('gearRatio'));--}}
{{--                                        $active = 'active';--}}
{{--                                        if($gearRatio[0] == $gearRatioRange["min"] && $gearRatio[1]==$gearRatioRange["max"]){--}}
{{--                                        $active = '';--}}
{{--                                        }--}}
{{--                                    @endphp--}}
{{--                                @else--}}
{{--                                    @php--}}
{{--                                        $active = '';--}}
{{--                                    @endphp--}}
{{--                                @endif--}}
{{--                                <ul class="filter-dropdown__icon-list" role="list">--}}
{{--                                    <svg class="filter-dropdown__clear-list-icon filter-dropdown__clear-list-icon--range-slider {{$active}}" width="16" height="16" viewBox="0 0 36 36" fill="none" xmlns="http://www.w3.org/2000/svg">--}}
{{--                                        <path d="M30.0003 4.66666C30.3685 4.29847 30.9655 4.29847 31.3337 4.66666C31.7018 5.03485 31.7018 5.6318 31.3337 5.99998L6.00055 31.3331C5.63236 31.7013 5.03541 31.7013 4.66723 31.3331C4.29904 30.9649 4.29904 30.368 4.66722 29.9998L30.0003 4.66666Z" fill="#07012E" />--}}
{{--                                        <path d="M31.3333 29.9998C31.7015 30.368 31.7015 30.965 31.3333 31.3332C30.9652 31.7014 30.3682 31.7014 30 31.3332L4.66692 6.00006C4.29873 5.63187 4.29873 5.03493 4.66692 4.66674C5.03511 4.29855 5.63205 4.29855 6.00024 4.66674L31.3333 29.9998Z" fill="#07012E" />--}}
{{--                                    </svg>--}}
{{--                                    <svg class="filter-dropdown__arrow-icon" width="16" height="16" viewBox="0 0 28 14" fill="none" xmlns="http://www.w3.org/2000/svg">--}}
{{--                                        <rect width="19.2237" height="1.20148" transform="matrix(0.728345 -0.685211 0.728345 0.685211 13.1235 13.1724)" fill="#07012E" />--}}
{{--                                        <rect width="19.2237" height="1.20148" transform="matrix(0.728345 0.685211 -0.728345 0.685211 0.875 0.00390625)" fill="#07012E" />--}}
{{--                                    </svg>--}}
{{--                                </ul>--}}
{{--                            </div>--}}
{{--                            <ul role="list" class="filter-dropdown__list" id="filter3" x-show="filterDropdown3 === true" x-collapse.duration.500ms>--}}
{{--                                <li>--}}

{{--                                    <input type="text" class="js-range-slider" name="gearRatio" value="" data-type="double" data-min="{{$gearRatioRange["min"]}}" data-max="{{$gearRatioRange["max"]}}" data-from="{{isset($gearRatio)?$gearRatio[0]:$gearRatioRange["min"]}}" data-to="{{isset($gearRatio)?$gearRatio[1]:$gearRatioRange["max"]}}" />--}}
{{--                                    <div class="range-slider-values">--}}
{{--                                        <p>От<input type="number" class="range-slider-min-value" value="{{request()->has('gearRatio')?$gearRatio[0]:$gearRatioRange["min"]}}"></p>--}}
{{--                                        <p>До<input type="number" class="range-slider-max-value" value="{{request()->has('gearRatio')?$gearRatio[1]:$gearRatioRange["max"]}}"></p>--}}
{{--                                    </div>--}}

{{--                                </li>--}}
{{--                            </ul>--}}
{{--                        </div>--}}
{{--                    </li>--}}
{{--                    <li>--}}
{{--                        <div class="filter-dropdown" x-data="{filter: ''}">--}}
{{--                            <div class="filter-dropdown__top" @click="filterDropdown4 = !filterDropdown4" :class="{'active': filterDropdown4 === true}">--}}
{{--                                <p>Крутящий момент Н*м</p>--}}
{{--                                @if(request()->has('torque'))--}}
{{--                                    @php--}}
{{--                                        $torque = explode(';',request()->get('torque'));--}}
{{--                                        $active = 'active';--}}
{{--                                        if($torque[0] == $torqueRange["min"] && $torque[1]== $torqueRange["max"]){--}}
{{--                                        $active = '';--}}
{{--                                        }--}}
{{--                                    @endphp--}}
{{--                                @else--}}
{{--                                    @php--}}
{{--                                        $active = '';--}}
{{--                                    @endphp--}}
{{--                                @endif--}}
{{--                                <ul class="filter-dropdown__icon-list" role="list">--}}
{{--                                    <svg class="filter-dropdown__clear-list-icon filter-dropdown__clear-list-icon--range-slider {{$active}}" width="16" height="16" viewBox="0 0 36 36" fill="none" xmlns="http://www.w3.org/2000/svg">--}}
{{--                                        <path d="M30.0003 4.66666C30.3685 4.29847 30.9655 4.29847 31.3337 4.66666C31.7018 5.03485 31.7018 5.6318 31.3337 5.99998L6.00055 31.3331C5.63236 31.7013 5.03541 31.7013 4.66723 31.3331C4.29904 30.9649 4.29904 30.368 4.66722 29.9998L30.0003 4.66666Z" fill="#07012E" />--}}
{{--                                        <path d="M31.3333 29.9998C31.7015 30.368 31.7015 30.965 31.3333 31.3332C30.9652 31.7014 30.3682 31.7014 30 31.3332L4.66692 6.00006C4.29873 5.63187 4.29873 5.03493 4.66692 4.66674C5.03511 4.29855 5.63205 4.29855 6.00024 4.66674L31.3333 29.9998Z" fill="#07012E" />--}}
{{--                                    </svg>--}}
{{--                                    <svg class="filter-dropdown__arrow-icon" width="16" height="16" viewBox="0 0 28 14" fill="none" xmlns="http://www.w3.org/2000/svg">--}}
{{--                                        <rect width="19.2237" height="1.20148" transform="matrix(0.728345 -0.685211 0.728345 0.685211 13.1235 13.1724)" fill="#07012E" />--}}
{{--                                        <rect width="19.2237" height="1.20148" transform="matrix(0.728345 0.685211 -0.728345 0.685211 0.875 0.00390625)" fill="#07012E" />--}}
{{--                                    </svg>--}}
{{--                                </ul>--}}
{{--                            </div>--}}
{{--                            <ul role="list" class="filter-dropdown__list" id="filter4" x-show="filterDropdown4 === true" x-collapse.duration.500ms>--}}
{{--                                <li>--}}

{{--                                    <input type="text" class="js-range-slider" name="torque" value="" data-type="double" data-min="{{$torqueRange["min"]}}" data-max="{{$torqueRange["max"]}}" data-from="{{isset($torque)?$torque[0]: $torqueRange["min"]}}" data-to="{{isset($torque)?$torque[1]: $torqueRange["max"]}}" />--}}
{{--                                    <div class="range-slider-values">--}}
{{--                                        <p>От<input type="number" class="range-slider-min-value" id="range-slider-min-value-torque" value="{{isset($torque)?$torque[0]:$torqueRange["min"]}}"></p>--}}
{{--                                        <p>До<input type="number" class="range-slider-max-value" id="range-slider-max-value-torque" value="{{isset($torque)?$torque[1]:$torqueRange["max"]}}"></p>--}}
{{--                                    </div>--}}

{{--                                </li>--}}
{{--                            </ul>--}}
{{--                        </div>--}}
{{--                    </li>--}}
{{--                    <li>--}}
{{--                        <a href="{{request()->url()}}" class="filter__clear-btn" type="button" style="text-decoration: none;"><svg width="16" height="16">--}}
{{--                                <use xlink:href="{{asset('resources/svgSprites/svgSprite.svg#clear-filter-icon')}}"></use>--}}
{{--                            </svg>Удалить фильтры</a>--}}
{{--                    </li>--}}

{{--                      <li>--}}
{{--                        <button type="button" class="filter__submit-btn">Применить</button>--}}
{{--                    </li>--}}

{{--                </form>--}}
{{--            </ul>--}}

{{--        </div>--}}
    </nav>

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
        <a href="/{{$product->category->slug}}/{{$product->slug}}" class="catalog-card__link"></a>
            <figure class="catalog-card">
                <div class="catalog-card__main">
                    <div class="catalog-card__top">
                        <picture>
                            <img src="{{asset('storage/'.$product->firstImage())}}" loading="lazy" decoding="async" alt="{{$product->name.' | '.$product->alt}}" width="328" height="264">
                        </picture>
                        <figcaption>
                        <h3 class="title title-h3">{{$product->name}}</h3>
                       </figcaption>
                        <ul class="catalog-card__descr catalog-card__descr--pos-abs">
                            @foreach($product->details() as $name => $value)
                                <li><p>{{$name}}</p><span>{{$value}}</span></li>
                            @endforeach
{{--                            {{$product->details()}}--}}
                        </ul>
                    </div>
                    <!-- <div class="catalog-card__link-btn-wrapper">
                        <a href="/catalog/{{$product->category->slug}}/{{$product->slug}}" class="secondary-btn catalog-card__link-btn">Подробнее</a>
                    </div> -->
                </div>
                <div class="catalog-card__aside">
                    <ul class="catalog-card__descr">
                        @foreach($product->details() as $name => $value)
                            <li><p>{{$name}}</p><span>{{$value}}</span></li>
                        @endforeach
{{--                        {{$product->details()}}--}}
                    </ul>
                </div>
            </figure>
        </li>

        @endforeach

    </ul>
{{--        @if($products->total() == 0)--}}
{{--            <div class="no-catalog-products-message">--}}
{{--                <p>По заданным фильтрам нет редукторов</p>--}}
{{--                <img loading="lazy" decoding="async" src="{{asset('uploads/no-catalog-products-img.png')}}" alt="image" width="308" height="249">--}}
{{--            </div>--}}
{{--        @endif--}}
    <ul class="pagination catalog-pagination" role="list">
        {{$products->withQueryString()->links('vendor.pagination.semantic-ui')}}
    </ul>

    <script>
        {{--var disabled_locations = [] = {{(request() -> has('typeOfTransmission')) ? $categories -> where('id', request() -> get('typeOfTransmission')) -> first() -> locations -> pluck('id'): '[]'}};--}}
        {{--var disabled_types = [] = {{(request() -> has('locationOfAxes')) ? $categories -> where('id', request() -> get('locationOfAxes')) -> first() -> locations -> pluck('id'): '[]'}};--}}

        // $('#filter1 li').each(function() {
        //
        //     var input = $(this).find('input'),
        //         button = $(this).find('button');
        //     if ($.inArray(parseInt(input.val()), disabled_types) !== -1) {
        //         button.prop('disabled', false)
        //     } else {
        //         button.prop('disabled', true)
        //
        //     }
        // })

        // $('#filter2 li').each(function() {
        //
        //     var input = $(this).find('input'),
        //         button = $(this).find('button');
        //     if ($.inArray(parseInt(input.val()), disabled_locations) !== -1) {
        //         button.prop('disabled', false)
        //     } else {
        //         button.prop('disabled', true)
        //
        //     }
        // })
    </script>
</div>
