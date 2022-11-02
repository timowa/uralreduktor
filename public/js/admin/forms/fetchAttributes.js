let attributes = [],
    fields = $('[data-attributes]'),
    url = $('[name="category_id"]').data('source');
$.ajaxSetup({
        url: url,
        type:'post',
        success:function(data){
           if(data.success){
               attributes = []
               $.each(data.attributes,function(key,value){
                    attributes.push(value.id)
               })
               $.each(fields,function(key,value){
                   var fieldName = $(value).attr('name').replace('[]','')
                   if($.inArray($(value).data('attributes'),attributes)>=0){
                       crud.field(fieldName).show().enable()
                   }else{
                       crud.field(fieldName).hide().disable()
                       $(value).val(null).trigger('change')
                   }
               })
           }
        },
    });
crud.field('category_id').onChange(function(field){
    $.ajax({
        data: {id:field.value}
    })
})
$.ajax({
    data: {id:$('[name="category_id"]').val()}
})
