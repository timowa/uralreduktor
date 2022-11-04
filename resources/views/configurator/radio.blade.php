<div class="order-form-controls-group order-form-controls-group--not-last" x-show="showFields">
    <div class="order-form-controls-group__tooltip" x-bind:class="{ 'inactive': {{$field->tooltipName()}} === false }">
        <p class="order-form-controls-group__tooltip-text">
            укажите {{\Illuminate\Support\Str::lower($field->name())}}
        </p>
        <button type="button" aria-label="button" class="order-form-controls-group__tooltip-close" @click="{{$field->tooltipName()}} = false">
            <span></span>
            <span></span>
        </button>
    </div>
    <h4 class="order-form-controls-group__title" >{!! $field->name() !!}</h4>
    <ul class="order-form-controls-group__radio-list" role="list" x-data="{setup: ''}">
        @foreach($field->values() as $value)
            <li :class="{'active': setup === {{$value}}}" @click="{{$field->data($value)}}">
                <input type="radio" name="{{$field->inputName()}}" value="{{$value}}" id="{{$field->id()}}" data-name="{{$value}}">
                <label for="{{$field->id()}}">{{$value}}</label>
            </li>
        @endforeach
    </ul>
</div>
