<ul role="list">
    <form action="/catalog" method="get" class="filterCatalog">
        @for($i = 1;$i<=2;$i++)
        <li>
            <div class="filter-dropdown" x-data="{filter{{$i}}: '', close:{{(request()->has('typeOfTransmission'))? 'true' : 'false'}}}">
                <div class="filter-dropdown__top" @click="filterDropdown{{$i}} = !filterDropdown{{$i}}" :class="{'active': filterDropdown{{$i}} === true}">
                    <p>{{$filter[$i]['name']}}</p>
                    <ul class="filter-dropdown__icon-list" role="list">
                        <a href="javascript:void(0)">
                            <svg class="filter-dropdown__clear-list-icon " :class="close ? 'active' : ''" width="16" height="16" viewBox="0 0 36 36" fill="none" xmlns="http://www.w3.org/2000/svg" @click="filter = '', close = false" :class="{'active': filter !== ''}">
                                <path d="M30.0003 4.66666C30.3685 4.29847 30.9655 4.29847 31.3337 4.66666C31.7018 5.03485 31.7018 5.6318 31.3337 5.99998L6.00055 31.3331C5.63236 31.7013 5.03541 31.7013 4.66723 31.3331C4.29904 30.9649 4.29904 30.368 4.66722 29.9998L30.0003 4.66666Z" fill="#07012E" />
                                <path d="M31.3333 29.9998C31.7015 30.368 31.7015 30.965 31.3333 31.3332C30.9652 31.7014 30.3682 31.7014 30 31.3332L4.66692 6.00006C4.29873 5.63187 4.29873 5.03493 4.66692 4.66674C5.03511 4.29855 5.63205 4.29855 6.00024 4.66674L31.3333 29.9998Z" fill="#07012E" />
                            </svg>
                        </a>
                        <svg class="filter-dropdown__arrow-icon" width="16" height="16" viewBox="0 0 28 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <rect width="19.2237" height="1.20148" transform="matrix(0.728345 -0.685211 0.728345 0.685211 13.1235 13.1724)" fill="#07012E" />
                            <rect width="19.2237" height="1.20148" transform="matrix(0.728345 0.685211 -0.728345 0.685211 0.875 0.00390625)" fill="#07012E" />
                        </svg>
                    </ul>
                </div>
                <ul role="list" class="filter-dropdown__list" id="filter{{$i}}" x-show="filterDropdown{{$i}} === true" x-collapse.duration.500ms>
                        @foreach($filter[$i]['options'] as $key=>$value)
                    <li>
                        <label>
                            <input type="radio" style="display: none" value="{{$value}}" data-slug="{{$key}}" name="{{$filter[$i]['slug']}}" {{isset($_GET[$filter[$i]['slug']])?$_GET[$filter[$i]['slug']]==$key?'checked':'':''}}>

                            <button type="button" aria-label="button" @click="filter{{$i}} !=={{$loop->iteration}} ?filter{{$i}} = {{$loop->iteration}}: filter{{$i}} = null, close = true" :class="{'active': filter{{$i}} === {{$loop->iteration}}}"

                            >{{$value}}</button>
                        </label>
                    </li>
                    @endforeach
                </ul>
            </div>
        </li>
        @endfor
            @for($i = 3;$i<=4;$i++)
        <li>
            <div class="filter-dropdown" x-data="{filter{{$i}}: ''}">
                <div class="filter-dropdown__top" @click="filterDropdown{{$i}} = !filterDropdown{{$i}}" :class="{'active': filterDropdown{{$i}} === true}">
                    <p>{{$filter[$i]['name']}}</p>
                    <ul class="filter-dropdown__icon-list" role="list">
                        <svg class="filter-dropdown__clear-list-icon filter-dropdown__clear-list-icon--range-slider active" width="16" height="16" viewBox="0 0 36 36" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M30.0003 4.66666C30.3685 4.29847 30.9655 4.29847 31.3337 4.66666C31.7018 5.03485 31.7018 5.6318 31.3337 5.99998L6.00055 31.3331C5.63236 31.7013 5.03541 31.7013 4.66723 31.3331C4.29904 30.9649 4.29904 30.368 4.66722 29.9998L30.0003 4.66666Z" fill="#07012E" />
                            <path d="M31.3333 29.9998C31.7015 30.368 31.7015 30.965 31.3333 31.3332C30.9652 31.7014 30.3682 31.7014 30 31.3332L4.66692 6.00006C4.29873 5.63187 4.29873 5.03493 4.66692 4.66674C5.03511 4.29855 5.63205 4.29855 6.00024 4.66674L31.3333 29.9998Z" fill="#07012E" />
                        </svg>
                        <svg class="filter-dropdown__arrow-icon" width="16" height="16" viewBox="0 0 28 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <rect width="19.2237" height="1.20148" transform="matrix(0.728345 -0.685211 0.728345 0.685211 13.1235 13.1724)" fill="#07012E" />
                            <rect width="19.2237" height="1.20148" transform="matrix(0.728345 0.685211 -0.728345 0.685211 0.875 0.00390625)" fill="#07012E" />
                        </svg>
                    </ul>
                </div>
                <ul role="list" class="filter-dropdown__list" id="filter{{$i}}" x-show="filterDropdown{{$i}} === true" x-collapse.duration.500ms>
                    <li>

                        <input type="text" class="js-range-slider" name="{{$filter[$i]['slug']}}" value="" data-type="double" data-min="{{$filter[$i]['min']}}" data-max="{{$filter[$i]['max']}}" data-from="{{isset($filter[$i])?$filter[$i]['id']:$filter[$i]['min']}}" data-to="{{isset($filter[$i])?$filter[$i]['name']:$filter[$i]['max']}}" />
                        <div class="range-slider-values">
                            <p>От<input type="number" class="range-slider-min-value" value="{{request()->has($filter[$i]['slug'])?$filter[$i]['id']:$filter[$i]['min']}}"></p>
                            <p>До<input type="number" class="range-slider-max-value" value="{{request()->has($filter[$i]['slug'])?$filter[$i]['name']:$filter[$i]['max']}}"></p>
                        </div>

                    </li>
                </ul>
            </div>
        </li>
            @endfor
        <li>
            <a href="{{request()->url()}}" class="filter__clear-btn" type="button" style="text-decoration: none;"><svg width="16" height="16">
                    <use xlink:href="{{asset('resources/svgSprites/svgSprite.svg#clear-filter-icon')}}"></use>
                </svg>Удалить фильтры</a>
        </li>

        <!--   <li>
            <button type="button" class="filter__submit-btn">Применить</button>
        </li>  -->

    </form>
</ul>
