<ul role="list">
    <form action="/catalog" method="get" class="filterCatalog">
        <li>
            <div class="filter-dropdown" x-data="{filter: '', close:{{(request()->has('typeOfTransmission'))? 'true' : 'false'}}}">
                <div class="filter-dropdown__top" @click="filterDropdown1 = !filterDropdown1" :class="{'active': filterDropdown1 === true}">
                    <p>Тип редуктора</p>
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
                <ul role="list" class="filter-dropdown__list" id="filter1" x-show="filterDropdown1 === true" x-collapse.duration.500ms>
                    @foreach($attr1 as $attr)
                    <li>
                        <label>
                            <input type="radio" style="display: none" value="{{$attr->id}}" name="typeOfTransmission" {{isset($_GET['typeOfTransmission'])?$_GET['typeOfTransmission']==$attr->id?'checked':'':''}}>
                            @php
                            $disabled = false;
                            if(isset($_GET['locationOfAxes'])){

                            foreach($attr->locations as $location){
                            $disabled = true;
                            if($location->id == $_GET['locationOfAxes']){
                            $disabled = false;
                            break;
                            }
                            }
                            }

                            @endphp
                            <button type="button" aria-label="button" @click="filter !=={{$loop->iteration}} ?filter = {{$loop->iteration}}: filter = null, close = true" :class="{'active': filter === {{$loop->iteration}}}" {{$disabled?'disabled':''}}>{{$attr->name}}</button>
                        </label>
                    </li>
                    @endforeach
                </ul>
            </div>
        </li>
        <li>
            <div class="filter-dropdown" x-data="{filter: '', close:{{(request()->has('locationOfAxes'))? 'true' : 'false'}}}">
                <div class="filter-dropdown__top" @click="filterDropdown2 = !filterDropdown2" :class="{'active': filterDropdown2 === true}">
                    <p>Расположение осей</p>
                    <ul class="filter-dropdown__icon-list" role="list">

                        <svg class="filter-dropdown__clear-list-icon " :class="close ? 'active' : ''" width="16" height="16" viewBox="0 0 36 36" fill="none" xmlns="http://www.w3.org/2000/svg" @click="filter = '', close = false" :class="{'active': filter !== ''}">
                            <path d="M30.0003 4.66666C30.3685 4.29847 30.9655 4.29847 31.3337 4.66666C31.7018 5.03485 31.7018 5.6318 31.3337 5.99998L6.00055 31.3331C5.63236 31.7013 5.03541 31.7013 4.66723 31.3331C4.29904 30.9649 4.29904 30.368 4.66722 29.9998L30.0003 4.66666Z" fill="#07012E" />
                            <path d="M31.3333 29.9998C31.7015 30.368 31.7015 30.965 31.3333 31.3332C30.9652 31.7014 30.3682 31.7014 30 31.3332L4.66692 6.00006C4.29873 5.63187 4.29873 5.03493 4.66692 4.66674C5.03511 4.29855 5.63205 4.29855 6.00024 4.66674L31.3333 29.9998Z" fill="#07012E" />
                        </svg>
                        <svg class="filter-dropdown__arrow-icon" width="16" height="16" viewBox="0 0 28 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <rect width="19.2237" height="1.20148" transform="matrix(0.728345 -0.685211 0.728345 0.685211 13.1235 13.1724)" fill="#07012E" />
                            <rect width="19.2237" height="1.20148" transform="matrix(0.728345 0.685211 -0.728345 0.685211 0.875 0.00390625)" fill="#07012E" />
                        </svg>
                    </ul>
                </div>
                <ul role="list" class="filter-dropdown__list" id="filter2" x-show="filterDropdown2 === true" x-collapse.duration.500ms>
                    @foreach($attr4 as $attr)
                    @php
                    $disabled = false;
                    if(isset($_GET['typeOfTransmission'])){

                    foreach($attr->categories as $categotyLoc){
                    $disabled = true;
                    if($categotyLoc->id == $_GET['typeOfTransmission']) {
                    $disabled = false;
                    break;
                    }
                    }
                    }

                    @endphp
                    <li>
                        <label>
                            <input type="radio" style="display: none" value="{{$attr->id}}" name="locationOfAxes" {{isset($_GET['locationOfAxes'])?$_GET['locationOfAxes']==$attr->id?'checked':'':''}}>
                            <button type="button" aria-label="button" @click="filter !=={{$loop->iteration}} ?filter = {{$loop->iteration}}: filter = null, close = true" :class="{'active': filter === {{$loop->iteration}}}" {{$disabled?'disabled':''}}>{{$attr->name}}</button>
                        </label>
                    </li>
                    @endforeach
                </ul>
            </div>
        </li>
        <li>
            <div class="filter-dropdown" x-data="{filter: ''}">
                <div class="filter-dropdown__top" @click="filterDropdown3 = !filterDropdown3" :class="{'active': filterDropdown3 === true}">
                    <p>Передаточное отношение</p>
                    @if(request()->has('gearRatio'))
                    @php
                    $gearRatio = explode(';',request()->get('gearRatio'));
                    $active = 'active';
                    if($gearRatio[0] == $gearRatioRange["min"] && $gearRatio[1]==$gearRatioRange["max"]){
                    $active = '';
                    }
                    @endphp
                    @else
                    @php
                    $active = '';
                    @endphp
                    @endif
                    <ul class="filter-dropdown__icon-list" role="list">
                        <svg class="filter-dropdown__clear-list-icon filter-dropdown__clear-list-icon--range-slider {{$active}}" width="16" height="16" viewBox="0 0 36 36" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M30.0003 4.66666C30.3685 4.29847 30.9655 4.29847 31.3337 4.66666C31.7018 5.03485 31.7018 5.6318 31.3337 5.99998L6.00055 31.3331C5.63236 31.7013 5.03541 31.7013 4.66723 31.3331C4.29904 30.9649 4.29904 30.368 4.66722 29.9998L30.0003 4.66666Z" fill="#07012E" />
                            <path d="M31.3333 29.9998C31.7015 30.368 31.7015 30.965 31.3333 31.3332C30.9652 31.7014 30.3682 31.7014 30 31.3332L4.66692 6.00006C4.29873 5.63187 4.29873 5.03493 4.66692 4.66674C5.03511 4.29855 5.63205 4.29855 6.00024 4.66674L31.3333 29.9998Z" fill="#07012E" />
                        </svg>
                        <svg class="filter-dropdown__arrow-icon" width="16" height="16" viewBox="0 0 28 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <rect width="19.2237" height="1.20148" transform="matrix(0.728345 -0.685211 0.728345 0.685211 13.1235 13.1724)" fill="#07012E" />
                            <rect width="19.2237" height="1.20148" transform="matrix(0.728345 0.685211 -0.728345 0.685211 0.875 0.00390625)" fill="#07012E" />
                        </svg>
                    </ul>
                </div>
                <ul role="list" class="filter-dropdown__list" id="filter3" x-show="filterDropdown3 === true" x-collapse.duration.500ms>
                    <li>

                        <input type="text" class="js-range-slider" name="gearRatio" value="" data-type="double" data-min="{{$gearRatioRange["min"]}}" data-max="{{$gearRatioRange["max"]}}" data-from="{{isset($gearRatio)?$gearRatio[0]:$gearRatioRange["min"]}}" data-to="{{isset($gearRatio)?$gearRatio[1]:$gearRatioRange["max"]}}" />
                        <div class="range-slider-values">
                            <p>От<input type="number" class="range-slider-min-value" value="{{request()->has('gearRatio')?$gearRatio[0]:$gearRatioRange["min"]}}"></p>
                            <p>До<input type="number" class="range-slider-max-value" value="{{request()->has('gearRatio')?$gearRatio[1]:$gearRatioRange["max"]}}"></p>
                        </div>

                    </li>
                </ul>
            </div>
        </li>
        <li>
            <div class="filter-dropdown" x-data="{filter: ''}">
                <div class="filter-dropdown__top" @click="filterDropdown4 = !filterDropdown4" :class="{'active': filterDropdown4 === true}">
                    <p>Крутящий момент Н*м</p>
                    @if(request()->has('torque'))
                        @php
                            $torque = explode(';',request()->get('torque'));
                            $active = 'active';
                            if($torque[0] == $torqueRange["min"] && $torque[1]== $torqueRange["max"]){
                            $active = '';
                            }
                        @endphp
                    @else
                        @php
                            $active = '';
                        @endphp
                    @endif
                    <ul class="filter-dropdown__icon-list" role="list">
                        <svg class="filter-dropdown__clear-list-icon filter-dropdown__clear-list-icon--range-slider {{$active}}" width="16" height="16" viewBox="0 0 36 36" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M30.0003 4.66666C30.3685 4.29847 30.9655 4.29847 31.3337 4.66666C31.7018 5.03485 31.7018 5.6318 31.3337 5.99998L6.00055 31.3331C5.63236 31.7013 5.03541 31.7013 4.66723 31.3331C4.29904 30.9649 4.29904 30.368 4.66722 29.9998L30.0003 4.66666Z" fill="#07012E" />
                            <path d="M31.3333 29.9998C31.7015 30.368 31.7015 30.965 31.3333 31.3332C30.9652 31.7014 30.3682 31.7014 30 31.3332L4.66692 6.00006C4.29873 5.63187 4.29873 5.03493 4.66692 4.66674C5.03511 4.29855 5.63205 4.29855 6.00024 4.66674L31.3333 29.9998Z" fill="#07012E" />
                        </svg>
                        <svg class="filter-dropdown__arrow-icon" width="16" height="16" viewBox="0 0 28 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <rect width="19.2237" height="1.20148" transform="matrix(0.728345 -0.685211 0.728345 0.685211 13.1235 13.1724)" fill="#07012E" />
                            <rect width="19.2237" height="1.20148" transform="matrix(0.728345 0.685211 -0.728345 0.685211 0.875 0.00390625)" fill="#07012E" />
                        </svg>
                    </ul>
                </div>
                <ul role="list" class="filter-dropdown__list" id="filter4" x-show="filterDropdown4 === true" x-collapse.duration.500ms>
                    <li>
                        <input type="text" class="js-range-slider" name="torque" value="" data-type="double" data-min="{{$torqueRange["min"]}}" data-max="{{$torqueRange["max"]}}" data-from="{{isset($torque)?$torque[0]: $torqueRange["min"]}}" data-to="{{isset($torque)?$torque[1]: $torqueRange["max"]}}" />
                        <div class="range-slider-values">
                            <p>От<input type="number" class="range-slider-min-value" id="range-slider-min-value-torque" value="{{isset($torque)?$torque[0]: $torqueRange["min"]}}"></p>
                            <p>До<input type="number" class="range-slider-max-value" id="range-slider-max-value-torque" value="{{isset($torque)?$torque[1]: $torqueRange["max"]}}"></p>
                        </div>
                    </li>
                </ul>
            </div>
        </li>
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
