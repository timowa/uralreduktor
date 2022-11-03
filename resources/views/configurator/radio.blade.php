<div class="order-form-controls-group order-form-controls-group--not-last" x-show="showFields">
    <div class="order-form-controls-group__tooltip" x-bind:class="{ 'inactive': showTooltip1 === false }">
        <p class="order-form-controls-group__tooltip-text">
            укажите передаточное отношение
        </p>
        <button type="button" aria-label="button" class="order-form-controls-group__tooltip-close" @click="showTooltip1 = false">
            <span></span>
            <span></span>
        </button>
    </div>
    <h4 class="order-form-controls-group__title">{!! $field->name() !!}</h4>
    <ul class="order-form-controls-group__radio-list" role="list" x-data="{setup: ''}">
        @foreach($field->values() as $value)
            <li :class="{'active': setup === {{$value}}}" @click="setup = {{$value}};activateNextStep1 = true;showTooltip1 = false">
                <input type="radio" name="{{$field->name()}}" value="{{$value}}" id="{{$field->id()}}" data-name="{{$value}}">
                <label for="{{$field->id()}}">{{$value}}</label>
            </li>
        @endforeach
    </ul>
</div>
