$(document).ready(function(){
    let attributes = [],
        url=$('[name="series_id"]').data('source'),
        fields = $('[data-attributes]');
    $.ajaxSetup({
        url: url,
        type:'post',
        success:function(data){
            attributes = [];
            $.each(data,function (key,value){
                attributes.push(parseInt(key))
            })
            $.each(fields,function(key,value){
                var fieldName = $(value).attr('name').replace('[]','')
                if($.inArray($(value).data('attributes'),attributes)>=0){
                    $(value).empty()
                    $.each(data[$(value).data('attributes')],function(key,option) {
                        var newOption = new Option(option, key, false, false);
                        $(value).append(newOption).trigger('change');
                    })
                    crud.field(fieldName).show().enable()
                }else{
                    crud.field(fieldName).hide().disable()
                    $(value).val(null).trigger('change')
                }
            })
        },
    });

    crud.field('series_id').onChange(function(field){
        $.ajax({
            data:{
                id:field.value
            }
        })
    })
    $.each($('[hidden-by-default]'),function(key,value){
            var fieldName = $(value).attr('name').replace('[]','')
            crud.field(fieldName).hide().disable()

    })


})
