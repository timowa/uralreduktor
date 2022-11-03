<script>
    $(document).ready(function (){
        $('#productCardSizes').find('img').attr('style','')
        $('#productCardSizes').find('img').attr('loading','lazy')
        $('#productCardSizes').find('img').attr('decoding','async')
        $('#productCardSizes').find('img').attr('width','550')
        $('#productCardSizes').find('img').attr('height','224')
        $('form').on('submit',function(e){
            var form = $(this)
            //   if(form.attr('id')==="makeOrder"){
            //       var detailsText = form.find('textarea[name="details"]')
            //       $.eaech(details,function(key,value){
            //           detailsText.append('<li><span>'+key+'</span>:<b>'+value+'</b></li>')
            //       })
            //   }
            e.preventDefault()
            // var formData = new FormData($(this))
            $.ajax({
                type:'post',
                url:"/checkCaptcha",
                data:$(this).serialize(),
                success:function(data){
                    if(data==="success"){
                        form.unbind('submit')
                        form.submit()
                        form.trigger('reset')
                    }else{
                        alert('Сначала подтвердите что вы не робот')
                    }
                },
                error:function(data){
                    alert('Пока что это невозможно. Попробуйте позже')
                }
            })
        })
        // $('input#orderFormTel').mask("8(999) 999-9999",{ completed:function(){$(this).parent().addClass('correct')}});
        $('textarea').on('input',function(){
            var value = $(this).val()
            if(value.indexOf('http')>0||value.indexOf('//')>0){
                $(this).parent().removeClass('correct').addClass('error')
            }else{
                $(this).parent().removeClass('error').addClass('correct')
            }
        })
        $('input#orderFormName, input#name').on('input',function(){
            var value = $(this).val();
            var regEx = /^[а-яА-Я]+$/;
            var valid = regEx.test(value);
            if (!valid) {
                $(this).parent().removeClass('correct').addClass('error')

            }else{
                $(this).parent().removeClass('error').addClass('correct')
            }
        })
        $('input#orderFormMail, input#email').on('blur',function(){
            var value = $(this).val();
            var regEx = /^[a-zА-Я\.0-9_-]+@[a-z0-9-]+\.([a-z]{1,6}\.)?[a-z]{2,6}$/i;
            var validEmail = regEx.test(value);
            if (!validEmail || value.indexOf('@')===0) {
                $(this).parent().removeClass('correct').addClass('error')
            }
            else{
                $(this).parent().removeClass('error').addClass('correct')
            }
        })

        var details = {};
        var name = {
            name:$('form#makeOrder input[name="product_name"]').val(),
            "Передаточное отношение":"",
            "Вариант сборки":"",
            "Монтажное положение":""
        }

        $('.order-form__select-dropdown-list li span').each(function(){
            if($(this).hasClass('aactive')){
                $(this).removeClass('aactive').addClass('active')
            }
        })

        $('.order-form__select-dropdown').each(function(){
            var variant = $(this).find('span').first().text()
            if(variant !== 'Вариант'){
                $(this).find('.order-form__select-dropdown-list li span.active').trigger('click')
            }
        })

        // $('button#nextStep').on('click',function(){
        //     $.each(details,function(key,value){
        //         if(value!=""){
        //             $('ul#users-list li').each(function(){
        //                 if($(this).find("p").text()==key){
        //                     if(value!=''){
        //                         $(this).find('span').text(value)
        //                     }else{
        //                         $(this).find('span').text('-')
        //
        //                     }
        //                 }
        //             })
        //         }
        //
        //     })
        // })

        $('form#quest').on('change',function(){
            $('.form-controls-wrapper').each(function(){
                if($(this).hasClass('error')) valid = false
            })
            if(valid===false){
                $(this).find('button[type="submit"]').prop('disabled',true)
            }else{
                $(this).find('button[type="submit"]').prop('disabled',false)
            }
            if($('.recaptcha-checkbox').data('aria-checked')===false){
                var valid = true
                valid = false;
            }
        })
        $('form#makeOrder').on('click change',function(){
            var valid = true
            $('.form-controls-wrapper').each(function(){
                if($(this).hasClass('error')) valid = false
            })
            if(valid===false){
                $(this).find('button[type="submit"]').prop('disabled',true)
            }else{
                $(this).find('button[type="submit"]').prop('disabled',false)
            }
            if($('.recaptcha-checkbox').data('aria-checked')===false){
                valid = false;
            }
            generateTitle()
        })

        // $('input#accept').on('change',function(){
        //     if($(this).is(':checked')){
        //         $('.order-form__step-page-1').find('input[type="radio"], select').prop('disabled',true)
        //         $('.order-form__step-page-1').find('.order-form-controls-group').hide()
        //     }else{
        //         $('.order-form__step-page-1').find('input[type="radio"], select').prop('disabled',false)
        //         $('.order-form__step-page-1').find('.order-form-controls-group').show()
        //     }
        // })
        $(document).find('div.order-complete-modal button').on('click',function(){
            $(document).find('div.order-complete-modal').removeClass('active')
        })
        $(document).find('div.quest-complete-modal button').on('click',function(){
            $(document).find('div.quest-complete-modal').removeClass('active')
        })
        @if(Session::get('message'))
        @if(Session::get('message')=='OrderComplete')
        $(document).find('div.order-complete-modal').addClass('active')
        @elseif(Session::get('message')=='questComplete')
        $(document).find('div.quest-complete-modal').addClass('active')
        @endif
        @endif

        function generateTitle(){
            $('ul#users-list li').each(function(){
                if( $(this).find('span').text()==''){
                    $(this).find('span').text('-')
                }
            })
            $('.order-form__select-dropdown-list li').each(function(){
                if($(this).children('span').hasClass('active')){
                    var select = $(this).data('select')
                    var option = $(this).data('option')
                    var optionName = ''
                    if(option.indexOf(" ")<0 && option.indexOf("-")<0){
                        optionName = option.charAt(0)
                    }else{
                        if(option.indexOf(" ")>=0){
                            $.each(option.split(" "),function(key,value){
                                optionName+=value.charAt(0)
                            })
                        }else if(option.indexOf("-")>=0){
                            $.each(option.split("-"),function(key,value){
                                optionName+=value.charAt(0)
                            })
                        }
                    }

                    details[select]=option
                    name[select]=optionName.toUpperCase()

                    $(document).find('select[name="'+select+'"] option[value="'+option+'"]').prop('selected',true)
                }})
            $('#makeOrder input[type="radio"]').on('change',function(){
                var select = $(this).attr('name')
                var option = $(this).val()
                var str = $(this).data('name')
                details[select]=option
                name[select]=str

            })
            var newname = '';
            var step = 0;
            $.each(name,function(key,value){
                if(step == 0 || value ===""){
                    newname+=value;
                }else{
                    newname+='-'+value;
                }
                step++

            })
            $('.users-conf-name').text(newname)
            $('#makeOrder input[name="product_name"]').val(newname)
            console.log(details,name)
            $.each(details,function(key,value){
                if(value!=""){
                    $('ul#users-list li').each(function(){
                        if($(this).find("p").text()==key){
                            if(value!=''){
                                $(this).find('span').text(value)
                            }else{
                                $(this).find('span').text('-')

                            }
                        }
                    })
                }

            })
        }
        generateTitle()
    })



</script>
