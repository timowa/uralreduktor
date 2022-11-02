crud.field('category_id').onChange(function(field) {
    if (field.value != '') {
        crud.field('has_series').show().enable();
    } else {
        crud.field('has_series').hide().disable();
    }
}).change();
