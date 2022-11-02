{{-- This file is used to store sidebar items, inside the Backpack admin panel --}}
<li class="nav-item"><a class="nav-link" href="{{ backpack_url('dashboard') }}"><i class="la la-home nav-icon"></i> {{ trans('backpack::base.dashboard') }}</a></li>
<li class="nav-item nav-dropdown">
    <a class="nav-link nav-dropdown-toggle" href="#"><i class="nav-icon la la-archive"></i>Каталог</a>
    <ul class="nav-dropdown-items">
        <li class="nav-item"><a class="nav-link" href="{{ backpack_url('product-category') }}"><i class="nav-icon la la-tasks"></i> Категории</a></li>
        <li class="nav-item"><a class="nav-link" href="{{ backpack_url('product-series') }}"><i class="nav-icon la la-wrench"></i>Серии</a></li>
        <li class="nav-item"><a class="nav-link" href="{{ backpack_url('product-attribute') }}"><i class="nav-icon la la-object-ungroup"></i> Аттрибуты</a></li>
        <li class="nav-item"><a class="nav-link" href="{{ backpack_url('product') }}"><i class="nav-icon la la-cubes"></i> Редукторы</a></li>

    </ul>
</li>


<li class="nav-item"><a class="nav-link" href="{{ backpack_url('elfinder') }}"><i class="nav-icon la la-files-o"></i> <span>{{ trans('backpack::crud.file_manager') }}</span></a></li>