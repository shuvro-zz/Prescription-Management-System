if(typeof autocomplete_off == "function"){
    autocomplete_off();
}

$(document).ready(function(){

    // OnCheck "Do you wish to restrict booking to the Event?" question
    $('body').delegate('#required-pre-requisites','change', function(){
        var is_checked = $(this).is(':checked');
        if(is_checked == true){
            //$('.event-pre-requisites').removeClass('hidden');

            //
            $('div.event-pre-requisites input[type=checkbox]').each(function() {
                $(this).prop('checked', true);
            });
            //


            $('.required-customer-validate-check').removeClass('hidden');
            checkRequiredCustomerValidate();
        } else {
            //$('.event-pre-requisites').addClass('hidden');
            //
            $('div.event-pre-requisites input[type=checkbox]').each(function() {
                $(this).prop('checked', false);
            });
            //
            $('.required-customer-validate-check').addClass('hidden');
            checkRequiredCustomerValidate();
        }
    });

    // OnCheck "Do you wish for your customer to validate their identity?" question
    $('body').delegate('#required-customer-validate','change', function(){
        checkRequiredCustomerValidate();
    });

    // OnCheck "Does the event require attendee information?" question
    $('body').delegate('#does-event-require-additional-attendee-info','change', function(e){
        console.log(BookingFormBuilder);
        e.preventDefault();
        var is_checked = $(this).is(':checked');
        if(is_checked == true){
            // $('#form-editor-booking').show();
            var fb = jQuery('#form-editor-booking');
            fb.show();
            var formWrapId = fb.find(".form-wrap.form-builder").attr('id');
            if(formWrapId){
                var id = formWrapId.replace('-form-wrap','');
                if($.trim(id) != ""){
                    jQuery('#'+id).css('min-height',function(){
                        return jQuery('#'+id+'-cb-wrap').height();
                    });
                }
            }
        } else {
            $('#form-editor-booking').hide();
        }
    });


    $('body').delegate('#does-event-require-attendee-info','change', function(e){
        e.preventDefault();
        var attendee_info_is_checked = $('#does-event-require-attendee-info').is(':checked');
        if(attendee_info_is_checked == true){
            var fb = jQuery('#form-editor-attendee');
            fb.show();
            var formWrapId = fb.find(".form-wrap.form-builder").attr('id');
            if(formWrapId){
                var id = formWrapId.replace('-form-wrap','');
                if($.trim(id) != ""){
                    jQuery('#'+id).css('min-height',function(){
                        return jQuery('#'+id+'-cb-wrap').height();
                    });
                    // jQuery('#frmb-0').css('min-height',function(){
                    //     return jQuery('#frmb-0-cb-wrap').height();
                    // });
                }
            }

        }else{
            jQuery('#form-editor-attendee').hide();
        }

    });


    function checkRequiredCustomerValidate() {
        var is_checked = $('#required-customer-validate').is(':checked');
        if(is_checked == true){
           // $('.event-required-customer-validate').removeClass('hidden');
            //
            $('div.event-required-customer-validate input[type=checkbox]').each(function() {
                $(this).prop('checked', true);
            });
            //
        } else {
           // $('.event-required-customer-validate').addClass('hidden');
            //
            $('div.event-required-customer-validate input[type=checkbox]').each(function() {
                $(this).prop('checked', false);
            });
            //
        }
    }
    
});
