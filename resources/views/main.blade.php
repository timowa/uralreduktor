<!DOCTYPE html>
<html lang="ru">
@yield('head')

<body x-data="{mobileMenu: false, mobileSubMenu: false, searchMenu: false, headerSubMenu:false, filter: false, orderForm: false, questionModal: false, orderCompleteModal: false,  questCompleteModal: false }" :class="{'mobileMenuOpened': mobileMenu === true || searchMenu === true || filter === true || orderForm === true || questionModal === true || orderCompleteModal === true || questCompleteModal === true}">
	@include('parts.header')
	@yield('content')
	@include('parts.footer')
</body>
<!-- Google Tag Manager (noscript) -->
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-NXTVBWW" height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<!-- End Google Tag Manager (noscript) -->

</html>