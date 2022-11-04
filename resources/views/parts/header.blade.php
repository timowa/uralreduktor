<script src="{{asset('js/aos.js')}}" defer></script>
<script src="{{asset('js/simplebar.min.js')}}"></script>
<script src="{{asset('js/sticksy.min.js')}}"></script>
<script defer src="https://unpkg.com/@alpinejs/persist@3.x.x/dist/cdn.min.js"></script>
<script defer src="https://unpkg.com/@alpinejs/collapse@3.x.x/dist/cdn.min.js"></script>
<script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
<script src="{{asset('js/jquery.min.js')}}"></script>
<script src="{{asset('js/main.min.js')}}" defer></script>

@yield('cdn')
<script>
  $(document).ready(function() {
    function ajaxSearch(str) {
      $.ajax({
        beforeSend: function() {
          $('.header-search-menu__list').html('')
        },
        url: "/search/catalog",
        type: 'post',
        data: {
          str: str,
          "_token": "{{ csrf_token() }}",
        },
        success: function(data) {
          $('.header-search-menu__list').html(data)
        },
        error: function(data) {
          console.log(data + 2)
        }
      })
    }
    $('#search').on('input', function() {
      var str = $(this).find('input').val();
      ajaxSearch(str)
    })
    $('#search').keydown(function(event) {
      var val = $(this).find('input').val()
      if (event.keyCode == 13) {
        if ($('ul.header-search-menu__list').children().length > 0 && val !== '') {
          event.preventDefault();
          var href = $('ul.header-search-menu__list').children().first().find('a').attr('href');
          window.location.href = href;
        } else {
          event.preventDefault();
          return false;
        }

      }
    })
    $('#searchMobile').on('input', function() {
      var str = $(this).val()
      ajaxSearch(str)
    })
  })
</script>
<header class="header" @mouseover.outside="headerSubMenu = false">
  <div class="container header__container">
    <button type="button" class="header__hamb-btn" @click="mobileMenu = !mobileMenu;searchMenu = false" :class="{'active': mobileMenu === true}"><span>
      </span></button>
    <div class="header__left">
      <div class="header__logo">
        <a href="/">
          <svg width="30" height="30">
            <use xlink:href="{{asset('resources/svgSprites/svgSprite.svg#logo')}}"></use>
          </svg>
        </a>
      </div>
      <nav class="header__menu" x-data="{headerSubMenu1:false}">
        <ul class="header__menu-list" role="list">
          <li @mouseover="headerSubMenu = true" :class="{'active': headerSubMenu === true}"><a href="/catalog">Каталог</a></li>
          <li><a href="/about">О компании</a></li>
          <!-- <li @click="headerSubMenu1 = !headerSubMenu1" :class="{'active': headerSubMenu1 === true}"><a href="#">О компании</a></li> -->
          <li><a href="/contacts">Контакты</a></li>
        </ul>
        <nav class="header__dropdown-menu-wrapper" x-show="headerSubMenu1" @click.outside="headerSubMenu1 = false" x-transition.origin.top.left.duration.300ms style="display:none;">
          <ul class="header__dropdown-menu" role="list">
            <!--li>
              <a href="/about">
                <span>О нас</span>
              </a>
            </li-->
            <!--li>
              <a href="/news">
                <span>Новости</span>
              </a>
            </li-->
            <!--li>
              <a href="/articles">
                <span>Статьи</span>
              </a>
            </li-->
          </ul>
        </nav>
        <nav class="header__dropdown-menu-wrapper" x-show="headerSubMenu" x-transition.origin.top.left.duration.300ms style="display:none;" @mouseover="headerSubMenu = true">
          <ul class="header__dropdown-menu" role="list">
            @foreach($globalCategories as $category)
            <li><a href="{{route('categoryPage',$category->slug)}}">
{{--                {!!file_get_contents(asset('storage/'.$category->icon))!!}--}}
                <span>
                  @if(str_contains($category->name,'редукторы'))
                  {{$category->name}}
                  @else
                  {{$category->name}} редукторы
                  @endif
                </span>
              </a></li>
            @endforeach

          </ul>
        </nav>
      </nav>
    </div>
    <ul class="header__search-phone-list" role="list">
      <li class="header__order-btn-wrapper">
        <button class="primary-btn header__order-btn" type="button" @click="orderForm = true">Запросить</button>
      </li>
      <li>
        <svg class="header__search header__search--adaptive" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 32 32" width="32" height="32" @click="searchMenu = !searchMenu; mobileMenu = false" :class="{'active': searchMenu === true}">
          <path stroke="#07012E" stroke-width="2" d="M22.38 11.69c0 5.904-4.786 10.69-10.69 10.69S1 17.594 1 11.69 5.786 1 11.69 1s10.69 4.786 10.69 10.69Z" />
          <path fill="#07012E" d="m19.601 17.535 12.4 12.4L29.933 32l-12.4-12.399z" />
        </svg>
        <nav class="header-search-menu header-search-menu--desktop" x-data="{searchInputText:'',searchMenuDesktop: false}" @click.outside="searchInputText = '';searchMenuDesktop = false">
          <div class="header-search-menu__wrapper header-search-menu__wrapper--desktop">
            <div class="header-search-menu__bottom-line" :class="{'active': searchMenuDesktop === true}">
              <svg class="header__search header__search--desktop" width="32" height="32" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg" @mouseover.self="searchMenuDesktop = true" :class="{'active': searchMenuDesktop === true}">
                <path fill-rule="evenodd" clip-rule="evenodd" d="M12.2285 20.1238C16.589 20.1238 20.1238 16.589 20.1238 12.2285C20.1238 7.86814 16.589 4.33333 12.2285 4.33333C7.86814 4.33333 4.33333 7.86814 4.33333 12.2285C4.33333 16.589 7.86814 20.1238 12.2285 20.1238ZM12.2285 22.4571C17.8776 22.4571 22.4571 17.8776 22.4571 12.2285C22.4571 6.57948 17.8776 2 12.2285 2C6.57948 2 2 6.57948 2 12.2285C2 17.8776 6.57948 22.4571 12.2285 22.4571Z" fill="#07012E" />
                <path d="M19.151 17.3438L30 28.1928L28.1918 30.0009L17.3428 19.1519L19.151 17.3438Z" fill="#07012E" />
              </svg>
              <form action="/search/catalog" method="post" id="search">
                <input name="search_field" type="text" x-model.debounce.500ms="searchInputText" :class="{'active': searchMenuDesktop === true}" placeholder="Поиск по марке">
              </form>
            </div>
            <button type="button" @click="searchInputText = '';searchMenuDesktop = false" :class="{'active': searchMenuDesktop === true}"><svg width="32" height="32">
                <use xlink:href="{{asset('resources/svgSprites/svgSprite.svg#search-icon-close')}}"></use>
              </svg></button>
          </div>
          <ul class="header-search-menu__list header-search-menu__list--desktop" role="list" x-show="searchInputText" style="display: none;" x-transition.origin.top.left.duration.300ms>
            <li class="header-search-menu__item header-search-menu__item--title">
              <h3><a href="#">Название раздела, который выдает поиск</a></h3>
            </li>

          </ul>
        </nav>
      </li>
      <li class="header__phone-wrapper">
        <a href="tel:+7 (343) 236–44–44" class="header__phone-text">+7 (343) 236–44–44</a>
        <svg class="header__phone" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 32" width="24" height="32">
          <path fill="#07012E" d="M2.377 9.282c-.442-3.037 1.61-5.765 4.745-6.764a2.2 2.2 0 0 1 1.679.14c.522.27.926.735 1.13 1.303l1.007 2.8c.162.45.19.942.084 1.41a2.438 2.438 0 0 1-.686 1.217l-2.994 2.86c-.147.142-.257.32-.319.52a1.26 1.26 0 0 0-.032.615l.027.125.072.314a17.98 17.98 0 0 0 1.687 4.357 17.433 17.433 0 0 0 2.998 3.928l.093.087c.15.138.33.234.526.277.195.044.398.034.589-.029l3.87-1.272a2.22 2.22 0 0 1 1.354-.01 2.31 2.31 0 0 1 1.127.78l1.832 2.32a2.44 2.44 0 0 1-.206 3.237c-2.399 2.334-5.698 2.812-7.993.888a30.42 30.42 0 0 1-6.997-8.518A30.867 30.867 0 0 1 2.375 9.282h.002Zm7.04 4.26 2.48-2.375a4.876 4.876 0 0 0 1.373-2.434 5.025 5.025 0 0 0-.167-2.819l-1.004-2.8A4.732 4.732 0 0 0 9.824.494 4.426 4.426 0 0 0 6.447.21C2.553 1.453-.573 5.096.089 9.646A33.377 33.377 0 0 0 3.97 21.083a32.807 32.807 0 0 0 7.547 9.185c3.443 2.885 8.038 1.9 11.023-1.002a4.865 4.865 0 0 0 1.449-3.182 4.918 4.918 0 0 0-1.035-3.354l-1.833-2.323a4.619 4.619 0 0 0-2.255-1.558 4.443 4.443 0 0 0-2.705.023l-3.214 1.055a15.881 15.881 0 0 1-2.165-2.952 15.499 15.499 0 0 1-1.365-3.43v-.003Z" />
        </svg>
      </li>
    </ul>
  </div>
  <nav class="header__mobile-menu" :class="{'active': mobileMenu === true}">
    <ul class="header__list" role="list">
      <li><a href="/">
          <svg width="30" height="30">
            <use xlink:href="{{asset('resources/svgSprites/svgSprite.svg#logo')}}"></use>
          </svg>
          <span>Главная</span>
        </a>
      </li>
      <li class="has-submenu" :class="{'active': mobileSubMenu === true}" @click.self="mobileSubMenu = !mobileSubMenu">
        <a @click.self="mobileSubMenu = !mobileSubMenu">
          <svg width="18" height="32" @click.self="mobileSubMenu = !mobileSubMenu">
            <use xlink:href="{{asset('resources/svgSprites/svgSprite.svg#menu-icon-back')}}"></use>
          </svg>
          <span @click.self="mobileSubMenu = !mobileSubMenu">Каталог</span>
        </a>
        <ul class="header__sub-menu" :class="{'active': mobileSubMenu === true}" role="list">
          @foreach($globalCategories as $category)
          <li><a href="/catalog?typeOfTransmission={{$category->id}}">
              <svg width="68" height="48">
                <use xlink:href="{{asset('resources/svgSprites/svgSprite.svg#submenu-icon-'.$loop->iteration)}}"></use>
              </svg>
              <span>
                @if(str_contains($category->name,'редукторы'))
                {{$category->name}}
                @else
                {{$category->name}} редукторы
                @endif
              </span>
            </a></li>
          @endforeach

        </ul>
      </li>
      <li><a href="/about">О компании</a></li>
      <li><a href="/news">Новости</a></li>
      <li><a href="/articles">Статьи</a></li>
      <li><a href="/contacts">Контакты</a></li>

    </ul>
  </nav>
  <nav class="header-search-menu header-search-menu--adaptive" :class="{'active': searchMenu === true}" x-data="{searchInputText:''}">
    <div class="header-search-menu__wrapper header-search-menu__wrapper--adaptive">
      <form action="/search/catalog" method="post">

      </form>
      <input name="search_field" type="text" x-model.debounce.500ms="searchInputText" placeholder="Поиск по марке" id="searchMobile">
      <button type="button" @click="searchInputText = ''"><svg width="32" height="32">
          <use xlink:href="{{asset('resources/svgSprites/svgSprite.svg#search-icon-close')}}"></use>
        </svg></button>

    </div>
    <ul class="header-search-menu__list" role="list" x-show="searchInputText">
      <li class="header-search-menu__item header-search-menu__item--title">
        <h3><a href="#">Название раздела, который выдает поиск</a></h3>
      </li>

    </ul>
  </nav>
</header>
<div class="overlay" :class="{'active':mobileMenu === true || searchMenu === true || filter === true || orderForm === true || questionModal === true || orderCompleteModal === true,'z-998': filter === true || orderForm === true || orderCompleteModal === true}" @click="mobileMenu = false;searchMenu = false;filter = false;orderForm = false; questionModal = false; orderCompleteModal = false"></div>
