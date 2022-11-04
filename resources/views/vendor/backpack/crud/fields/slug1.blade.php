@include('crud::fields.text')
<?php
if(!isset($field['target1'])){
    $field['target1'] = null;
}else{
    if($field['target1'] == '') $field['target1'] = null;
}
$locale = request('_locale');
if(is_null($locale))$locale='ru'
?>
@if(isset($field['target']) && $field['target'] != null && $field['target'] != '' && $locale == 'ru')
  @push('after_scripts')
    <script>
        function translit(str)
        {
            var ru=("А-а-Б-б-В-в-Ґ-ґ-Г-г-Д-д-Е-е-Ё-ё-Є-є-Ж-ж-З-з-И-и-І-і-Ї-ї-Й-й-К-к-Л-л-М-м-Н-н-О-о-П-п-Р-р-С-с-Т-т-У-у-Ф-ф-Х-х-Ц-ц-Ч-ч-Ш-ш-Щ-щ-Ъ-ъ-Ы-ы-Ь-ь-Э-э-Ю-ю-Я-я").split("-")
            var en=("A-a-B-b-V-v-G-g-G-g-D-d-E-e-E-e-E-e-ZH-zh-Z-z-I-i-I-i-I-i-J-j-K-k-L-l-M-m-N-n-O-o-P-p-R-r-S-s-T-t-U-u-F-f-H-h-C-c-CH-ch-SH-sh-SCH-sch---Y-y---E-e-YU-yu-YA-ya").split("-")
            var res = '';
            for(var i=0, l=str.length; i<l; i++)
            {
                var s = str.charAt(i), n = ru.indexOf(s);
                if(n >= 0) { res += en[n]; }
                else { res += s; }
            }
            return res;
        }
        crud.field('{{ $field['target'] }}').onChange(field => {
            let slug = field.value.toString()
                .replace(/\s(.)/g, function($1) { return $1.toUpperCase(); })
                .replace(/\s/g, '')
                .replace(/^(.)/, function($1) { return $1.toLowerCase(); });

            slug = translit(slug)
            @if($field['target1']!=null)
            if(crud.field('{{$field['target1']}}').value!=''){
                let type = translit(crud.field('{{$field['target1']}}').value.toLowerCase())
                if(slug!=''){
                    slug +='-'+type
                }
            }
            @endif

          crud.field('{{ $field['name'] }}').input.value = slug;
        });

    </script>
  @endpush
@endif

@if(isset($field['apply_edit']) && $field['apply_edit'] != null && $field['apply_edit'] != '')
    @push('after_scripts')
        <script>
            crud.field('{{ $field['apply_edit'] }}').onChange(function(field) {
                if(field.value == 1){
                    $(crud.field('{{$field['name']}}').input).attr('readonly',false)
                }else{
                    $(crud.field('{{$field['name']}}').input).attr('readonly',true)

                }
            }).change();
        </script>
    @endpush
@endif
