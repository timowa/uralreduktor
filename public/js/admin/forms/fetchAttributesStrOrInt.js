crud.field('attribute_type').onChange(function(field){
    toggleFields()
})
$(document).ready(function(){
    toggleFields()
})
let selectNum = $('select[name="numAttributes[]"]'),
    selectStr = $('select[name="strAttributes[]"]'),
    selectSvg = $('select[name="svgAttributes[]"]'),
    selectConfiguratorFieldType = $('select[name="configurator_field_type"]');
function toggleFields(){
    switch(crud.field('attribute_type').value){
        case 'string':
            crud.field('strAttributes').show().enable()
            crud.field('numAttributes').hide().disable()
            crud.field('svgAttributes').hide().disable()
            $(selectNum).empty()
            $(selectSvg).empty()
            $(selectConfiguratorFieldType).find('option').prop('disabled',false)
            $(selectConfiguratorFieldType).val('select')
            $(selectConfiguratorFieldType).trigger('change')
            break
        case 'num':
            crud.field('numAttributes').show().enable()
            crud.field('strAttributes').hide().disable()
            crud.field('svgAttributes').hide().disable()
            $(selectStr).empty()
            $(selectSvg).empty()
            $(selectConfiguratorFieldType).find('option').prop('disabled',false)
            $(selectConfiguratorFieldType).val('radio')
            $(selectConfiguratorFieldType).trigger('change')
            break
        case 'svg':
            crud.field('svgAttributes').show().enable()
            crud.field('strAttributes').hide().disable()
            crud.field('numAttributes').hide().disable()
            $(selectStr).empty()
            $(selectNum).empty()
            $(selectConfiguratorFieldType).find('option').prop('disabled',true)
            $(selectConfiguratorFieldType).find('option[value="radio_with_svg"]').prop('disabled',false)
            $(selectConfiguratorFieldType).val('radio_with_svg')
            $(selectConfiguratorFieldType).trigger('change')
            break
    }
}

crud.field('show_in_configurator').onChange(function(field){
    if(field.value == 1){
        crud.field('configurator_field_type').show().enable()
    }else{
        crud.field('configurator_field_type').hide().disable()
    }
})
