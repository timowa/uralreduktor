<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />


    {{-- {{dd($_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'])}}--}}
    @if(isset($motor_meta))
    @if(Str::contains($_SERVER['REQUEST_URI'],$motor_meta['slug']))
    @if(empty($motor_meta['title']))
    <title>{{$motor_meta['name']}} | {{$motor_meta['title']}}</title>
    <meta name="description" content="{{$motor_meta['name']}}">
    <meta property="og:title" content="{{$motor_meta['name']}}">
    <meta property="og:description" content="{{$motor_meta['name']}}">

    <link rel="canonical" href="<?= 'https://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] . '' ?>">
    <meta name="robots" content="index,follow" />
    @else
    <title>{{$motor_meta['name']}} | {{$motor_meta['title']}}</title>
    <meta property="og:image:alt" content="{{$motor_meta['alt']}}">
    <meta name="description" content="{{$motor_meta['name']}} | {{$motor_meta['description']}}">
    <meta property="og:title" content="{{$motor_meta['name']}} | {{$motor_meta['title']}}">
    <meta property="og:description" content="{{$motor_meta['name']}} | {{$motor_meta['description']}}">
    <meta name="keywords" content="{{$motor_meta['keywords']}}">
    <link rel="canonical" href="<?= 'https://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] . '' ?>">
    <meta name="robots" content="index,follow" />
    @endif
    @endif
    @endif
    @if(isset($meta[0]))
    @if(empty($meta[0]->meta_title))
    <title>Уралредуктор</title>
    <meta name="description" content="description">
    <meta property="og:title" content="title">
    <meta property="og:description" content="description">
    <meta name="keywords" content="ключевые слова">
    @else
    @if($meta[0]->meta_url=='https://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'].'')
    <title>{{$meta[0]->meta_title}}</title>
    <meta property="og:image:alt" content="{{$meta[0]->meta_image_description}}">
    <meta name="description" content="{{$meta[0]->meta_description}}">
    <meta property="og:title" content="{{$meta[0]->meta_title}}">
    <meta property="og:description" content="{{$meta[0]->meta_description}}">
    <meta name="keywords" content="{{$meta[0]->meta_keywords}}">
    <link rel="canonical" href="<?= 'https://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] . '' ?>">
    <meta name="robots" content="index,follow" />
    @elseif(Str::contains($meta[0]->meta_url,'/news/'))
    <title>Новость Уралредуктор</title>
    <meta name="description" content="description">
    <meta property="og:title" content="title">
    <meta property="og:description" content="description">
    <meta name="keywords" content="ключевые слова">
    <link rel="canonical" href="<?= 'https://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] . '' ?>">
    <meta name="robots" content="index,follow" />
    @elseif(Str::contains($meta[0]->meta_url,'/articles/'))
    <title>Статья Уралредуктор</title>
    <meta name="description" content="description">
    <meta property="og:title" content="title">
    <meta property="og:description" content="description">
    <meta name="keywords" content="ключевые слова">
    <link rel="canonical" href="<?= 'https://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] . '' ?>">
    <meta name="robots" content="index,follow" />
    @else
    <title>{{$meta[0]->meta_title}}</title>
    <meta property="og:image:alt" content="{{$meta[0]->meta_image_description}}">
    <meta name="description" content="{{$meta[0]->meta_description}}">
    <meta property="og:title" content="{{$meta[0]->meta_title}}">
    <meta property="og:description" content="{{$meta[0]->meta_description}}">
    <meta name="keywords" content="{{$meta[0]->meta_keywords}}">
    <link rel="canonical" href="<?= 'https://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] . '' ?>">
    <meta name="robots" content="index,follow" />
    @endif
    @endif
    @endif
    @if(isset($meta[0]) && isset($motor_meta))
    @else
    @if(empty($meta[0]) && empty($motor_meta))
    <title>Уралредуктор</title>
    <meta name="description" content="description">
    <meta property="og:title" content="title">
    <meta property="og:description" content="description">
    <meta name="keywords" content="ключевые слова">
    @endif
    @endif
    <meta property="og:image" content="{{asset('resources/svgSprites/logo.svg')}}">
    <meta property="og:url" content="{{asset('resources/svgSprites/logo.svg')}}">
    <link rel="icon" href="{{asset('resources/svgSprites/logo.svg')}}">

    <link rel="apple-touch-icon" href="{{asset('resources/svgSprites/logo.svg')}}">
    <link rel="manifest" href="{{asset('resources/svgSprites/logo.svg')}}">


    <meta property="og:locale" content="ru">
    <meta property="og:type" content="website">
    <meta name="twitter:card" content="summary_large_image">




    <meta name="theme-color" content="#fff" />
    <link rel="stylesheet" href="{{asset('styles/aos.min.css')}}" />
    <link rel="stylesheet" href="{{asset('styles/swiper-bundle.min.css')}}" />
    <link rel="stylesheet" href="{{asset('styles/simplebar.min.css')}}" />
    <!--Plugin CSS file with desired skin-->
    <link rel="stylesheet" href="{{asset('styles/ion.rangeSlider.min.css')}}" />
    <link rel="stylesheet" href="{{asset('styles/main.css')}}?v=3.9999278" />
</head>