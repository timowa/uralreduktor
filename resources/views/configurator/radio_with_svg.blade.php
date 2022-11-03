
<div class="order-form-controls-group order-form-controls-group--not-last" x-show="showFields">
    <div class="order-form-controls-group__tooltip" x-bind:class="{ 'inactive': {{$field->id()}} === false }">
        <p class="order-form-controls-group__tooltip-text">
            укажите вариант сборки
        </p>
        <button type="button" aria-label="button" class="order-form-controls-group__tooltip-close" @click="showTooltip2 = false">
            <span></span>
            <span></span>
        </button>
    </div>

    <h4 class="order-form-controls-group__title">{{$field->name()}}</h4>
    <ul class="order-form-controls-group__radio-list" role="list" x-data="{setup: ''}">
        @foreach($field->values() as $value)
            <li class="order-form-controls-group__variant-btn"  :class="{'active': setup === {{$value['value']}}}" @click="setup = {{$value['value']}};activateNextStep2 = true;showTooltip2 = false">
            <input type="radio" name="Вариант сборки" value="{{$value['value']}}" id="{{$field->id()}}" data-name="{{$value['value']}}">
            {{$field->getSvg($value['icon'])}}
            <label for="{{$field->id()}}">{{$value['value']}}</label>
        </li>
        @endforeach
        <li style="min-width: 89px;" :class="{'active': setup === 'Не знаю'}" @click="setup = 'Не знаю';activateNextStep2 = true;showTooltip2 = false">
            <input type="radio" name="Вариант сборки" value="Не знаю" id="Не знаю" data-name="?">
            <label for="Не знаю">Не знаю</label>
        </li>
    </ul>
</div>
