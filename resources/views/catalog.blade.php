@extends('main')
@section('head')
    @include('parts.head',['meta'=>$meta])
@endsection
@section('content')
    <script src="{{asset('js/ion.rangeSlider.min.js')}}"></script>
    <main>
        <nav class="breadcrumbs">
            <div class="container">
                <ul role="list">
                    <li><a href="/">Главная</a></li>
                    <li><a href=/catalog>Каталог</a></li>
                </ul>
            </div>
        </nav>
        <script>
            $(document).ready(function(){
                $('body').on('click','.filter-dropdown__list li button',function(){
                    $(this).closest('label').find('input[type="radio"]').prop('checked',true);
                })
                $('body').on('click','.filter-dropdown__clear-list-icon',function(){
                    $(this).closest('.filter-dropdown').find('input[type="radio"]').prop('checked',false);
                })
                $('.filter__clear-btn').on('click',function(){
                    $(this).closest('form').find('input[type="radio"]').prop('checked',false);
                    $(this).closest('form').find('.magic-hover.magic-hover__square').removeClass('active');
                })
                $('input[type="radio"]').each(function(){
                    if($(this).is(':checked')){
                        $(this).closest('label').find('button').addClass('active')
                    }
                })
            })

        </script>
        <section class="catalog">
            <div class="container catalog__container">
                <aside class="catalog__aside">
                    <nav class="filter filter--desktop" x-data="{filterDropdown1: $persist(''), filterDropdown2: $persist(''), filterDropdown3: $persist(''), filterDropdown4: $persist('') }">

                        @include('templates.filters.catalog',['filter'=>$pageFilter])

                    </nav>

                </aside>
                <div class="catalog__main">
                    <div class="catalog__main-btn-group">
                        <button class="filter-btn catalog-filter-btn" type="button" @click="filter = true"><svg width="68" height="48">
                                <use xlink:href="{{asset('resources/svgSprites/svgSprite.svg#filter-btn-icon')}}"></use>
                            </svg>Фильтры</button>
                    </div>
                    @include('templates.filters.catalog-mobile')
                    @include('parts.catalog-list')
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

            </div>
        </section>
        <script>
    $(document).ready(function () {

        $.urlParam = function(name){
        var results = new RegExp('[\?&]' + name + '=([^&#]*)').exec(window.location.href);
        if(results!=null)
        return results[1] || 0;
        else return 0
    }
    $('.filterCatalogMobile #filter1 button').on('click',function(){
        $('.filterCatalogMobile #filter2 input:checked').prop('checked',false)
    })
    $('.filter__submit-btn').on('click',function(e){
        e.preventDefault()
        var form = $(this).closest('form'),
            krutyaschiiMoment = form.find('input[name="krutyaschii-moment"]'),
            gearRatioRange = krutyaschiiMoment.val().split(';'),
            gearRatioMaxValue= krutyaschiiMoment.attr('data-max'),
            gearRatioMinValue= krutyaschiiMoment.attr('data-min'),
            peredatochnoeOtnoshenie = form.find('input[name="peredatochnoe-otnoshenie"]'),
            torqueRange = peredatochnoeOtnoshenie.val().split(';'),
            torqueMaxValue = peredatochnoeOtnoshenie.attr('data-max'),
            torqueMinValue = peredatochnoeOtnoshenie.attr('data-min'),
            tipPeredachiValue = form.find('input[name="tip-peredachi"]:checked').val();
        console.log(tipPeredachiValue)
        if(gearRatioRange[0] == gearRatioMinValue && gearRatioRange[1] == gearRatioMaxValue){
            krutyaschiiMoment.prop('disabled',true)
        }
        if(torqueRange[0] == torqueMinValue && torqueRange[1] == torqueMaxValue){
            peredatochnoeOtnoshenie.prop('disabled',true)
        }
        if($.urlParam('tip-peredachi') != tipPeredachiValue && $.urlParam('tip-peredachi') !=0 && tipPeredachiValue !=''){
            krutyaschiiMoment.prop('disabled',true)
            peredatochnoeOtnoshenie.prop('disabled',true)
            console.log(tipPeredachiValue)
        }
        form.submit()
    })
    function isset(r) {
        return typeof r !== 'undefined';
    }
    function deleteFilter(param){

        var params = window.location.search.replace('?','').split('&'),
            params1 = {};
        $.each(params,function(key,value){
            value = value.split('=')
            params1[value[0]]=value[1]
        })
        delete params1[param]

        filterProducts(false, params1);
    }
    function filterProducts(changeType = false,params){
        var tipPeredachi = $('.filterCatalog input[name="tipPeredachi"]:checked').val(),
            raspolozhenieOsej = $('.filterCatalog input[name="raspolozhenieOsej"]:checked').val(),
            krutyaschiiMoment = $('.filterCatalog input[name="krutyaschijMoment"]'),
            gearRatio =krutyaschiiMoment.val().split(';'),
            peredatochnoeOtnoshenie = $('.filterCatalog input[name="peredatochnoeOtnoshenie"]'),
            torque = peredatochnoeOtnoshenie.val().split(';'),
            get = '',
            data = {
                tipPeredachi: tipPeredachi,
                raspolozhenieOsej: raspolozhenieOsej,
            },
            gearRationRange = {
                'min': krutyaschiiMoment.attr('data-min'),
                'max': krutyaschiiMoment.attr('data-max')
            },
            torqueRange = {
                'min':peredatochnoeOtnoshenie.attr('data-min'),
                'max':peredatochnoeOtnoshenie.attr('data-max')
            }

        if(gearRatio[0] != gearRationRange["min"] || gearRatio[1]!=gearRationRange["max"]){

            data.gearRatio =gearRatio.join(';')

        }
        if(torque[0] != torqueRange["min"] || torque[1]!=torqueRange["max"]){
            data.torque=torque.join(';')

        }
        if(params){
            data = params
        }else{
            console.log('no-params')
        }
        if(changeType===true){
            delete data['raspolozhenieOsej']
            delete data['krutyaschijMoment']
            delete data['peredatochnoeOtnoshenie']
            $('#filter2 input[type="radio"]:checked').prop('checked',false)
        }

        console.log(data)

        $.each(data,function(key,value){
            if(!isset(value)){
                delete data[key]
            }
        })
        $.each(data,function(key,value){
            get+=key+'='+value+'&'
        })
        get = get.slice(0,-1)
        $.ajax({
            url:'/catalog',
            data: data,
            type: "GET",
            success: (data)=>{
                var positionSimbol = location.pathname.indexOf('?'),
                    url=location.pathname.substring(positionSimbol,location.pathname.length),
                    newUrl = url+'?';
                newUrl += get
                history.pushState({},'',newUrl)
                // console.log(data["filter"])

                // $('.filterCatalog li:nth-child(-n+2)').html(filter )
                var filter1 = $(data).find('#filter1').html();
                var filter2 = $(data).find('#filter2').html();
                var filter3 = $(data).find('#filter3').html();
                var filter4 = $(data).find('#filter4').html();
                var catalog_main = $(data).find('.catalog__main').html()
                $('.catalog__main').html(catalog_main)
                $('#filter1').html(filter1);
                $('#filter2').html(filter2);
                $('#filter3').html(filter3);
                $('#filter4').html(filter4);
                $(".filterCatalog .js-range-slider").ionRangeSlider({
                    onFinish: filterProducts,
                    onUpdate: filterProducts
                });
                AOS.init()
            }
        })


    }

    $('body').on('click','.filter--desktop #filter1 li button',function(){
        filterProducts(true)
    })
    $('body').on('click','.filter--desktop #filter2 li button',filterProducts)
    $('body').on('click','.catalog__series-list-item button',function(){
        var series = $('.catalog__series-list-form input[name="series"]:checked').val(),
            params = window.location.search.replace('?','').split('&'),
            params1 = {},
            get = '';
        $.each(params,function(key,value){
            value = value.split('=')
            params1[value[0]]=value[1]
        })
        params1["series"]=series

        $.each(params1,function(key,value){
            get+=key+'='+value+'&'
        })
        console.log(params1)
        get = get.slice(0,-1)
        $.ajax({
            url:'/catalog',
            data: params1,
            type: "GET",
            success: (data)=>{
                var positionSimbol = location.pathname.indexOf('?'),
                    url=location.pathname.substring(positionSimbol,location.pathname.length),
                    newUrl = url+'?';
                newUrl += get
                history.pushState({},'',newUrl)
                var newCatalogList = $(data).find('ul.catalog-list').html();
                var newPagination = $(data).find('ul.catalog-pagination').html();
                // console.log(data)
                $('ul.catalog-list').html(newCatalogList)
                $('ul.catalog-pagination').html(newPagination)

                AOS.init()
            }
        })
        // console.log(series,strGET)
    })

    $('body').on('click','.filter--desktop .filter-dropdown__clear-list-icon',function(){
        var param = $(this).closest('.filter-dropdown').find('input[type="radio"]').first().attr('name')
        deleteFilter(param)
    })
    $('body').on('click','.catalog__choice-series-clear-icon',function(e){
        e.preventDefault()
        e.stopPropagation()

        deleteFilter("series")
    })

    $(".filterCatalogMobile .js-range-slider").ionRangeSlider();
    $(".filterCatalog .js-range-slider").ionRangeSlider({
        onFinish: filterProducts,
        onUpdate: filterProducts
    });
    $('.js-range-slider').on('onFinish',filterProducts)


    $(".js-range-slider").on("change", function () {
        const inputValue = $(this);
        const minValue = inputValue.data("from");
        const maxValue = inputValue.data("to");
        // console.log(minValue,maxValue)
        inputValue.closest('.filter-dropdown').find('.filter-dropdown__clear-list-icon--range-slider').addClass('active');

        inputValue.closest('li').find('.range-slider-min-value').val(minValue);

        inputValue.closest('li').find('.range-slider-max-value').val(maxValue);
    });
    // $('#range-slider-min-value-torque').on('change',function(){
    //     var val = $(this).prop("value");
    //     console.log(val)
    // })
    //
    // let updateRangeSliderValues = $(".js-range-slider-torque").data("ionRangeSlider");

    $('.filter-dropdown__clear-list-icon--range-slider').on('click' ,function(){
        var range = $(this).closest('.filter-dropdown').find('.js-range-slider')
        var from = $(this).closest('li').find('.js-range-slider').data('min')
        var to = $(this).closest('li').find('.js-range-slider').data('max')
        range.data("ionRangeSlider").update({
            from: from,
            to:to
        });
        $(this).removeClass('active')
    })
    $('input.range-slider-min-value').on('change',function(){
        // console.log($(this).val())

        let rangeSliderMinValue = $(this).val();

        $(this).closest('li').find('.js-range-slider').data("ionRangeSlider").update({
            from: rangeSliderMinValue,
        });
    })
    $('.range-slider-max-value').on('change',function(){
        let rangeSliderMaxValue = $(this).val();
        $(this).closest('li').find('.js-range-slider').data("ionRangeSlider").update({
            to: rangeSliderMaxValue,
        });
    })

});

</script>
    </main>
@endsection
