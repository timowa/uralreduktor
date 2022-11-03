@php
$firstValue = empty($field->default())?$field->values()->first():$field->default();
@endphp
<div class="order-form-controls-group order-form-controls-group--not-last" x-show="showFields">
    <h4 class="order-form-controls-group__title">{{$field->name()}}</h4>
    <div class="order-form__select-dropdown" x-data="{selectDropdowntext: '{{$firstValue}}', toggleDropdownList: false}">
        <div class="order-form__select-dropdown-top disable" @click="toggleDropdownList = !toggleDropdownList">
            <span x-text="selectDropdowntext === '' ? '{{$firstValue}}' : selectDropdowntext" :class="{'active':selectDropdowntext != ''}" class="active">{{$firstValue}}</span>
            <svg :class="{'active': toggleDropdownList}" width="16" height="16">
                <use xlink:href="{{asset('resources/svgSprites/svgSprite.svg#icon-dropdown')}}"></use>
            </svg>
        </div>

        <select name="{{$field->name()}}" style="display: none">
            @foreach($field->values() as $value)
                <option value="{{$value}}" @selected($value==$firstValue)>{{$value}}</option>
            @endforeach
        </select>
        <ul role="list" class="order-form__select-dropdown-list" x-ref="selectDropdownList" x-bind:style="toggleDropdownList === true ? 'height: ' + $refs.selectDropdownList.scrollHeight + 'px' : ''" :class="{'active': toggleDropdownList === true}">
            @foreach($field->values() as $value)
                <li @click="selectDropdowntext = '{{$value}}';activateNextStep = true" data-select="{{$field->name()}}" data-option="{{$value}}"><span :class="{'active': selectDropdowntext === '{{$value}}'}">{{$value}}</span></li>
            @endforeach
        </ul>
    </div>
</div>
