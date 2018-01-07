/* Admin event creation JS */
var AttendeeFormBuilder = false;
var BookingFormBuilder = false;
var seat_count = {lavels:{}};
seat_count.status = false;
var save_action = false;
$(document).ready(function(){

    var first_question = false;
    var second_question = false;
    var third_question = false;

    if(!read_only_view){
        
    }

    $('body').delegate('.event-save','click', function(){
        save_action = true;
        getStep('next');
    });

    $('body').delegate('.event-back','click', function(){
        save_action = false;
        getStep('previous');
    });


    $('body').delegate('.check-box-class-add','click', function(){
        var is_checked = $(this).hasClass('checked');
        if(is_checked == true){
            $(this).removeClass('checked');
            $(this).addClass('unchecked');
        } else {
            $(this).removeClass('unchecked');
            $(this).addClass('checked');
        }
    });

    $('body').delegate('.event-step','click', function(e){
        save_action = false;
        e.preventDefault();
        var step_counter = $(this).attr('data-step-counter');

        if(!step_counter){
            return ;
        }
        
        var event_id = getEventId();
        if(event_id){
            var msg_title = 'Getting event data.';
            eventLoading(msg_title);

            var response_id = 'get-event-step';
            var path = 'admin/events/get-event-step';
            var event_id = getEventId();
            var post_data = {
                event_id: event_id,
                step_counter: step_counter
            };
            commonAjax(post_data, path, response_id);

        } else {
            swal('Please complete this step first', "" , "error");
        }
    });


    $('body').delegate('.event-question','change', function(){ // Event label placed in step 2 so all associated js code should re-arrange

        showHideLavelInputes(); return;

        var is_multiple_level_price = $('input[name=is_multiple_level_price]:checked').val();
        var is_restrict_total_ticket = $('input[name=is_restrict_total_ticket]:checked').val();
        var is_restrict_ticket_per_user = $('input[name=is_restrict_ticket_per_user]:checked').val();

        var level_dom = getLevelDom();

        // IF 1st question == yes
        if( typeof is_multiple_level_price !== 'undefined' && is_multiple_level_price == '1' ){
            if( $(this).hasClass('question1') ){
                first_question = true;
                $('.event-level-section').append(level_dom.level_name_price_dom);

                if(second_question == true){
                    $('.event-level-section').find('.level-input-row-dom').append(level_dom.level_max_per_person_dom);
                }

                if(third_question == true){
                    $('.event-level-section').find('.level-input-row-dom').append(level_dom.level_total_tickets_dom);
                }

                $('.level-row-dom-add').removeClass('hidden');

            }
        }

        // IF 1st question == no
        if( typeof is_multiple_level_price !== 'undefined' && is_multiple_level_price == '0' ){
            if( $(this).hasClass('question1') ) {
                first_question = false;
                $('.event-level-section').html('');
                $('.level-row-dom-add').addClass('hidden');
                $('.event-level-section').append(level_dom.level_name_price_dom);
            }
        }

        // IF 2nd question == yes
        if( typeof is_restrict_total_ticket !== 'undefined' && is_restrict_total_ticket == '1' ){
            if( $(this).hasClass('question2') ) {
                if (first_question == true) {
                    second_question = true;
                    //$('.event-level-section').find('.level-input-row-dom').append(level_dom.level_max_per_person_dom);
                    $('.event-level-section').find('.level-input-row-dom').append(level_dom.level_total_tickets_dom);
                } else {
                    second_question = true;
                    //$('.event-level-section').find('.level-input-row-dom').append(level_dom.level_max_per_person_dom);
                    $('.event-level-section').find('.level-input-row-dom').append(level_dom.level_total_tickets_dom);
                    //swal('Please select first question!', "" , "error");
                }
            }
        }

        // IF 2nd question == no
        if( typeof is_restrict_total_ticket !== 'undefined' && is_restrict_total_ticket == '0' ){
            if( $(this).hasClass('question2') ) {
                second_question = false;
                //$('.level-max-per-persone-dom').remove();
                $('.level-total-tickets-dom').remove();
            }
        }

        // IF 3rd question == yes
        if( typeof is_restrict_ticket_per_user !== 'undefined' && is_restrict_ticket_per_user == '1' ){
            if( $(this).hasClass('question3') ) {
                if (first_question == true) {
                    third_question = true;
                    //$('.event-level-section').find('.level-input-row-dom').append(level_dom.level_total_tickets_dom);
                    $('.event-level-section').find('.level-input-row-dom').append(level_dom.level_max_per_person_dom);
                } else {
                    third_question = true;
                    //$('.event-level-section').find('.level-input-row-dom').append(level_dom.level_total_tickets_dom);
                    $('.event-level-section').find('.level-input-row-dom').append(level_dom.level_max_per_person_dom);
                    //swal('Please select first question!', "" , "error");
                }
            }
        }

        // IF 3rd question == no
        if( typeof is_restrict_ticket_per_user !== 'undefined' && is_restrict_ticket_per_user == '0' ){
            if( $(this).hasClass('question3') ) {
                third_question = false;
                //$('.level-total-tickets-dom').remove();
                $('.level-max-per-persone-dom').remove();
            }
        }

    });

    $('body').delegate('.level-row-dom-add','click', function(e){
        e.preventDefault();
        var level_dom = $('.event-level-section').children().not(".level-title").first().clone();
        // level_dom.find("input[type=text]").val("").removeAttr("readonly").removeAttr("min");
        // level_dom.find("input[type=hidden]").val("").removeAttr("readonly").removeAttr("min");

        level_dom.find("input").val("").removeAttr("readonly").removeAttr("isColorPicker").removeAttr("min");
        level_dom.find("input[type='color']").val("#e0e0e0");
        level_dom.removeClass('lavel-booked');
        level_dom.find('.sp-replacer').remove();
        $('.event-level-section').append(level_dom);
        setTimeout(function(){
            //makeColorPicker($("input[type='color']"));
            makeColorPicker($(".level-color-picker"));
            showHideLavelInputes();
        },500);
    });

    $('body').delegate('.level-row-dom-remove','click', function(e){                                                    // Remove level row dom
        e.preventDefault();

        var level_dom = $(".input-row-container .level-dom");
        if(level_dom.length<=1){
            swal('One level is required!', "" , "error");
            return false;
        }

        $(this).closest(".level-dom").remove();

        setTimeout(function(){
            showHideLavelInputes();
        },500);
        return true;


        var level_dom = '';


        $('.level-dom').each(function(){
            ++level_dom;
        });

        if(level_dom>1){
            $(this).closest('.level-dom').remove();
        } else {
            swal('One level is required!', "" , "error");
        }

    });

    /*$('body').delegate('#required-pre-requisites','change', function(){
        var is_checked = $(this).is(':checked');
        if(is_checked == true){
            $('.event-pre-requisites').removeClass('hidden');
        } else {
            $('.event-pre-requisites').addClass('hidden');
        }
    });*/
    
    // $('body').delegate('.attendee-info','change', function(e){
    //     e.preventDefault();
    //     var attendee_info_is_checked = $('#does-event-require-attendee-info').is(':checked');
    //     if(attendee_info_is_checked == true){
    //         jQuery('#form-editor-attendee').show();
    //         jQuery('#frmb-0').css('height',function(){
    //             return jQuery('#frmb-0-cb-wrap').height();
    //         });
    //     }else{
    //         jQuery('#form-editor-attendee').hide();
    //     }
    //
    // });

    /*$('body').delegate('.attendee-info','change', function(e){
        e.preventDefault();
        
        var attendee_info_is_checked = $('#does-event-require-attendee-info').is(':checked');
        var default_form_is_checked = $('#use-default-attendee-form').is(':checked');
        
        if(attendee_info_is_checked == true && default_form_is_checked == true){
            getDefaultAttendeeForm();
        } else if(attendee_info_is_checked == false && default_form_is_checked == false) {
            //getAttendeeFormBuilder();
            $('.attendee-additional-details').html('');
        }
        
    });*/

    $('body').delegate('.event-name','keyup', function(e){                                                    // Remove level row dom
        $('.event-slug').val(slug($('.event-name').val()));
    });

// ----------------------------------------------------------------------
// Start Seat Plan Ready JS -- Rakib

    $(document).on('keyup','.float_number',function(){
        var s = $(this).val();
        match = s.match(/^([0-9]*)([\.]{0,1})([0-9]*)/)
        if(match){
            $(this).val(match[0]);
        }
        else{
            $(this).val();
        }
    });

    // $(document).on('blur','.float_number',function(){
    //     // console.log(1);
    //     var s = $.trim($(this).val())+".00";
    //     match = s.match(/^([0-9]*)([\.]{0,1})([0-9]*)/)
    //     if(match){
    //         $(this).val(match[0]);
    //     }
    //     else{
    //         $(this).val("0.00");
    //     }
    // });

    $(document).on('blur','.float_number',function(){
        // console.log(1);
        var s = $.trim($(this).val());
        match = s.match(/^([0-9]*)([\.]{0,1})([0-9]*)/)
        if(s==""){
            $(this).val("0.00");
        }
        else{
            $(this).val(parseFloat(s).toFixed(2));
        }
    });

    $(document).on('keyup','.int_number',function(){
        var s = $(this).val();
        match = s.match(/^([0-9]*)/)
        if(match){
            $(this).val(match[0]);
        }
        else{
            $(this).val();
        }
    });

    jQuery.validator.addMethod("requiredIfEqual", function(value, element, params) {
        var $ = jQuery;
        if($.trim(value) != ""){
            return true;
        }
        if($(params[0]).length){
            if ($.trim($(params[0]).val()) == params[1]) {
                return $.trim($(element).val()) != "";
            }
        }
        return  true;
    }, jQuery.validator.format("This field is required."));

    $(document).on("change","[name='enable_seat_plan']",function(){
        $("#seat-plan-html > .seat-plan-circle").remove("");
        enable_disable_seat_plan();
    })
    $(document).on("change","[name='seat_plan_type']",function(){
        $("#seat-plan-html > .seat-plan-circle").remove("");
        enable_disable_seat_plan();
    })

    $('body').delegate('.generate-reset','click', function(e) {
        e.preventDefault();

        var step_counter = $(this).attr('data-step-counter');
        var event_id = getEventId();
        if (event_id) {
            var msg_title = 'Getting event data.';
            eventLoading(msg_title);

            var response_id = 'get-event-step';
            var path = 'admin/events/save-generated-seat-plan';
            var event_id = getEventId();

            var post_data = $("#form-step4").serializeToJson();


                post_data.event_id = event_id;
                post_data.step_counter = step_counter;


            if ($(this).attr('reset')) {
                post_data.reset = 1;
            }
            else{
                var step_validation = validateSteps();
                if (!step_validation) {
                    setTimeout(function(){
                        hideLoading();
                        swal('Please provide seat plan details!', "All fields are requird" , "error");
                    })
                    return false;
                }
            }

            commonAjax(post_data, path, response_id);

        } else {
            swal('Please complete this step first', "", "error");
        }

    });

    // enable_disable_seat_plan();
    // initSeatPlanContextMenu();
    //generateSeatPlan();
    // create_seat_plan_html();
    //makeColorPicker($("input[type='color']"));
    makeColorPicker($(".level-color-picker"));
    showHideLavelInputes();

// End Seat Plan Ready JS -- Rakib    
// ----------------------------------------------------------------------

});

$.fn.serializeToJson = function() {
    var toReturn	= {};
    var els 		= $(this).find(':input').get();

    $.each(els, function() {
        // if (this.name && !this.disabled && (this.checked || /select|textarea/i.test(this.nodeName) || /text|hidden|password/i.test(this.type))) {
        //     var val = $(this).val();
        //     // toReturn.push( encodeURIComponent(this.name) + "=" + encodeURIComponent( val ) );
        //     toReturn[this.name] = val;
        // }
        if (this.name && !this.disabled && (this.checked || /select|textarea/i.test(this.nodeName) || /color|date|datetime|datetime-local|email|file|hidden|image|month|number|password|range|search|submit|tel|text|time|url|week/i.test(this.type))) {
            var val = $(this).val();
            // toReturn.push( encodeURIComponent(this.name) + "=" + encodeURIComponent( val ) );
            toReturn[this.name] = val;
        }
    });
    return toReturn;
}


function showHideLavelInputes(){

    var step_counter = getStepCounter();
    if(step_counter != 1){
        return ;
    }

    var is_multiple_level_price = $('input[name=is_multiple_level_price]:checked');
    var is_restrict_total_ticket = $('input[name=is_restrict_total_ticket]:checked');
    var is_restrict_ticket_per_user = $('input[name=is_restrict_ticket_per_user]:checked');
    var enable_seat_plan = $('input[name=enable_seat_plan]:checked');

    if(is_multiple_level_price.length==0 || is_restrict_total_ticket.length==0 || is_restrict_ticket_per_user.length==0 || enable_seat_plan.length==0 ){
        $(".level-row-dom-add").addClass('hidden');
        $(".event-level-section").hide();
        disableAllInputs($(".event-level-section"));
        return false;
    }


    if(is_restrict_total_ticket.length == 0 || is_restrict_total_ticket.val()==0){
        $(".event-level-section .level-total-tickets-dom").hide();
        disableAllInputs($(".event-level-section .level-total-tickets-dom"));
        is_restrict_total_ticket = 0;
    }
    else{
        $(".event-level-section .level-total-tickets-dom").show();
        enableAllInputs($(".event-level-section .level-total-tickets-dom"));
        is_restrict_total_ticket = 1;
    }

    if(is_restrict_ticket_per_user.length == 0 || is_restrict_ticket_per_user.val()==0){
        $(".event-level-section .level-max-per-persone-dom").hide();
        disableAllInputs($(".event-level-section .level-max-per-persone-dom"));
        is_restrict_ticket_per_user = 0;
    }
    else{
        $(".event-level-section .level-max-per-persone-dom").show();
        enableAllInputs($(".event-level-section .level-max-per-persone-dom"));
        is_restrict_ticket_per_user = 1;
    }


    var lavel_count = 1;
    if(is_multiple_level_price.length == 0){
        $(".level-row-dom-add").addClass('hidden');
        $(".event-level-section").hide();
        disableAllInputs($(".event-level-section"));
        is_multiple_level_price = 0;
    }
    else if(is_multiple_level_price.val()==0){
        is_multiple_level_price = 0;
        var level_dom = $(".input-row-container .level-dom");

        $(".level-row-dom-add").addClass('hidden');
        // $(".event-level-header").removeClass('hidden');
        $(".event-level-section").show();

        $(".event-level-section .level-row-dom-remove").hide();


        if(level_dom.length>1){
            level_dom.each(function(){
                if(lavel_count>1){
                    $(this).hide();
                    disableAllInputs($(this));
                }
                else{
                    $(this).show();
                    // enableAllInputs($(".level-color-dom",$(this)));
                    // enableAllInputs($(".level-name-dom",$(this)));

                    $(".event-level-section .level-color-dom").hide();
                    disableAllInputs($(".event-level-section .level-color-dom"));
                    $(".event-level-section .level-name-dom").hide();
                    disableAllInputs($(".event-level-section .level-name-dom"));


                    enableAllInputs($(".level-price-dom",$(this)));
                    enableAllInputs($(".action-btn",$(this)));
                }
                lavel_count++;
            });
        }
        else{
            level_dom.show();
            // enableAllInputs($(".level-color-dom",level_dom));
            // enableAllInputs($(".level-name-dom",level_dom));

            $(".event-level-section .level-color-dom").hide();
            disableAllInputs($(".event-level-section .level-color-dom"));
            $(".event-level-section .level-name-dom").hide();
            disableAllInputs($(".event-level-section .level-name-dom"));

            enableAllInputs($(".level-price-dom",level_dom));
            enableAllInputs($(".action-btn",level_dom));
        }
    }
    else{
        $(".level-row-dom-add").removeClass('hidden');
        // $(".event-level-header").removeClass('hidden');
        $(".event-level-section").show();
        var level_dom = $(".input-row-container .level-dom");
        if(level_dom.length <=1){
            $(".event-level-section .level-row-dom-remove").hide();
        }
        else{
            $(".event-level-section .level-row-dom-remove").show();
        }

        is_multiple_level_price = 1;
        if(is_restrict_total_ticket && is_restrict_ticket_per_user){
            level_dom.show();
            enableAllInputs($(".input-row-container"));
            $(".event-level-section .level-color-dom").show();
            enableAllInputs($(".event-level-section .level-color-dom"));
            $(".event-level-section .level-name-dom").show();
            enableAllInputs($(".event-level-section .level-name-dom"));
        }
        else{
            level_dom.each(function(){
                $(this).show();
                // enableAllInputs($(".level-color-dom",$(this)));
                // enableAllInputs($(".level-name-dom",$(this)));

                $(".event-level-section .level-color-dom").show();
                enableAllInputs($(".event-level-section .level-color-dom"));
                $(".event-level-section .level-name-dom").show();
                enableAllInputs($(".event-level-section .level-name-dom"));

                enableAllInputs($(".level-price-dom",$(this)));
                enableAllInputs($(".action-btn",$(this)));
            });
        }
    }

    if(is_multiple_level_price > 0){
        $(".level-row-dom-add").removeClass('hidden');
    }
}



function getStep(step) {

    if(step == 'next'){

        var step_validation = validateSteps();

        if(step_validation == true) {
            var step_counter = getStepCounter();
            if(step_counter==4){
                if(!checkSeatCount()){
                    return false;
                }
            }

            var msg_title = 'Saving event data.';
            eventLoading(msg_title);


            getNextStep();
        }

    } else if(step == 'previous'){

        var msg_title = 'Getting event data.';
        eventLoading(msg_title);
        getPreviousStep();

    }

}

function getPreviousStep(){
    var response_id = 'get-previous-step';
    var path = 'admin/events/get-previous-step';
    var step_counter = getStepCounter();
    var post_data = $('#form-step'+step_counter).serialize();
    commonAjax(post_data, path, response_id);
}

function getNextStep(){
    var response_id = 'get-next-step';
    var path = 'admin/events/get-next-step';
    var step_counter = getStepCounter();
    var post_data = $('#form-step'+step_counter).serialize();

    if(seat_plan_settings && step_counter==4){

        if(!checkSeatCount()){
            return false;
        }

        var post_data = $('#form-step'+step_counter).serializeToJson();
        post_data.seat_plan_settings = JSON.stringify(seat_plan_settings);
    }
    if(step_counter==5){
        var post_data = $('#form-step'+step_counter).serializeToJson();
        if(AttendeeFormBuilder.formData) {
            post_data.attendee_form = JSON.stringify(AttendeeFormBuilder.formData);
        }
        if(BookingFormBuilder.formData){
            post_data.booking_form = JSON.stringify(BookingFormBuilder.formData);
        }
    }

    commonAjax(post_data, path, response_id);
}

function checkSeatCount(){
    if(seat_plan_settings.is_restrict_total_ticket) {
        if (!seat_count.status) {
            return false;
        }
        if (!event_levels) {
            swal('Ticket type is empty', "", "error");
            ;
            return false;
        }
        for (level_id in event_levels) {
            if (!seat_count.lavels || !seat_count.lavels[level_id]) {
                swal("Please select " + event_levels[level_id]['level_name'] + " seat", "", "error");
                return false;
            }

            // console.log(seat_count.lavels[level_id], "<", event_levels[level_id]['total_ticket_per_level']);

            if (seat_count.lavels[level_id] < event_levels[level_id]['total_ticket_per_level']) {
                swal("Please select more " + (event_levels[level_id]['total_ticket_per_level'] - seat_count.lavels[level_id] ) + " " + event_levels[level_id]['level_name'] + " seat", "", "error");
                return false;
            }
            if (seat_count.lavels[level_id] > event_levels[level_id]['total_ticket_per_level']) {
                swal("Please remove " + (seat_count.lavels[level_id] - event_levels[level_id]['total_ticket_per_level'] ) + " " + event_levels[level_id]['level_name'] + " seat", "", "error");
                return false;
            }
        }
    }
    return true;
}

function getDefaultAttendeeForm(){
    var response_id = 'get-default-attendee-form';
    var path = 'admin/events/get-default-attendee-form';
    var event_id = getEventId();
    var post_data = {
        event_id: event_id
    };
    commonAjax(post_data, path, response_id);
}

function getAttendeeFormBuilder() {
    var response_id = 'get-attendee-form-builder';
    var path = 'admin/events/get-attendee-form-builder';
    var event_id = getEventId();
    var post_data = '';
    commonAjax(post_data, path, response_id);
}

function commonAjax(post_data, path, response_id){
    if(read_only_view){
        post_data.read_only_view = "read_only_view";
    }
    $.ajax({
        async:true,
        type:'post',
        data: post_data,
        url: SITE_URL + path,
        complete:function(request, json) {
            ajaxResponseHandaler(request.responseText, response_id);
        }
    })
}

function ajaxResponseHandaler(result,response_id){

    if(response_id == 'get-default-attendee-form'){
        $('.attendee-additional-details').html(result);
    } else if (response_id == 'get-attendee-form-builder'){
        $('.attendee-additional-details').html(result);
    } else {
        hideLoading();
        var step_counter = getStepCounter();
        if(step_counter == 5 && save_action === true){
            location.href = SITE_URL+'admin/events';
        } else {

            var s = "";

            if(result.error){
                s = result;
            }
            else{
                try{
                    var s = JSON.parse(result)
                }
                catch( e){

                }

                console.log(s.msg)
            }
            if(s.error){
                hideLoading();
                setTimeout(function (){
                    if(s.msg){
                        swal('', s.msg , "error");
                    }
                    else{
                        swal('', 'Error message' , "error");
                    }
                },500)

            }
            else{
                $('.event-cration-section').html(result);
            }
        }
    }

    setTimeout(function(){
        // $.globalEval(result);
    },1000);

}

function getStepCounter() {
    return parseInt($('#step_counter').val());
}

function getEventId() {
    return parseInt($('#event_id').val());
}

function eventLoading(msg_title){
    swal({
        title: msg_title,
        text: "",
        imageUrl: "/img/green_loader.gif"
    });
    $('.confirm').hide();
}

function hideLoading(){                                                         // Hide sweetalert loading.
    swal.close();
    return true;
}

function getLevelDom(){
    var inputIndex = new Date().getTime() + Math.random(1,100) + Math.random(1,100);

    var level_name_price_dom  = '<div class="level-dom">';

        level_name_price_dom += '<div class="col-md-10">';

        level_name_price_dom += '   <div class="input-row level-input-row-dom">';

        level_name_price_dom += '       <div class="column column1 level-color-dom">';
        level_name_price_dom += '           <div class="form-row">';
        level_name_price_dom += '               <div class="inputs">';
        level_name_price_dom += '                   <input class="level-color-picker" name="level_color['+inputIndex+']" type="color" value="#ff0000"/>';
        level_name_price_dom += '               </div>';
        level_name_price_dom += '           </div>';
        level_name_price_dom += '       </div>';

        level_name_price_dom += '       <div class="column column1 level-name-dom">';
        level_name_price_dom += '           <div class="form-row">';
        level_name_price_dom += '               <div class="inputs">';
        level_name_price_dom += '                   <input type="text" name="level_name['+inputIndex+']" class="form-control level-input valid-input" placeholder="Level Name">';
        level_name_price_dom += '               </div>';
        level_name_price_dom += '           </div>';
        level_name_price_dom += '       </div>';

        /*
        level_name_price_dom += '       <div class="column column1 level-color-dom">';
        level_name_price_dom += '           <div class="form-row">';
        level_name_price_dom += '               <div class="inputs">';
        level_name_price_dom += '                   <select name="level_color['+inputIndex+']" class="form-control">';
        level_name_price_dom += '                       <option value="red">Red</option>';
        level_name_price_dom += '                       <option value="blue">Blue</option>';
        level_name_price_dom += '                       <option value="green">Green</option>';
        level_name_price_dom += '                       <option value="silver">Silver</option>';
        level_name_price_dom += '                       <option value="yellow">Yellow</option>';
        level_name_price_dom += '                   </select>';
        level_name_price_dom += '               </div>';
        level_name_price_dom += '           </div>';
        level_name_price_dom += '       </div>'; */

        level_name_price_dom += '       <div class="column column1 level-price-dom">';
        level_name_price_dom += '           <div class="form-row">';
        level_name_price_dom += '               <div class="inputs">';
        level_name_price_dom += '                   <input type="text" name="level_price['+inputIndex+']" class="form-control price level-input valid-number" id="price" placeholder="Price" required >';
        level_name_price_dom += '               </div>';
        level_name_price_dom += '           </div>';
        level_name_price_dom += '       </div>';

        level_name_price_dom += '   </div>';

        level_name_price_dom += '</div>';

        level_name_price_dom += '<div class="col-md-2">';

        level_name_price_dom += '   <div class="column column3">';
        level_name_price_dom += '       <div class="form-row">';
        level_name_price_dom += '           <button class="level-row-dom-remove" >Remove</button>';
        level_name_price_dom += '       </div>';
        level_name_price_dom += '   </div>';

        level_name_price_dom += '</div>';
        level_name_price_dom += '</div>';

    var level_max_per_person_dom =  '<div class="column column1 level-max-per-persone-dom">';
        level_max_per_person_dom += '    <div class="form-row">';
        level_max_per_person_dom += '        <div class="inputs">';
        level_max_per_person_dom += '            <input type="text" name="max_per_person['+inputIndex+']" class="form-control level-input valid-number" placeholder="Max Per Person">';
        level_max_per_person_dom += '        </div>';
        level_max_per_person_dom += '    </div>';
        level_max_per_person_dom += '</div>';

    var level_total_tickets_dom =  '<div class="column column1 level-total-tickets-dom">';
        level_total_tickets_dom += '    <div class="form-row">';
        level_total_tickets_dom += '        <div class="inputs">';
        level_total_tickets_dom += '            <input type="text" name="total_tickets['+inputIndex+']" class="form-control level-input valid-number" placeholder="Total Tickets">';
        level_total_tickets_dom += '        </div>';
        level_total_tickets_dom += '    </div>';
        level_total_tickets_dom += '</div>';

    var level_dom = {
        level_name_price_dom: level_name_price_dom,
        level_max_per_person_dom: level_max_per_person_dom,
        level_total_tickets_dom: level_total_tickets_dom
    };

    return level_dom;

}

function CKupdate(){
    for ( instance in CKEDITOR.instances )
        CKEDITOR.instances[instance].updateElement();
}

function validateSteps(){

    var error_type = 0;
    var form_valid = true;
    var step_counter = getStepCounter();
    if( step_counter == 1 ){


        var is_multiple_level_price = $('input[name=is_multiple_level_price]:checked');
        var is_enable_discount_for_early_purchase = $('input[name=is_enable_discount_for_early_purchase]:checked');
        var is_restrict_total_ticket = $('input[name=is_restrict_total_ticket]:checked');
        var is_restrict_ticket_per_user = $('input[name=is_restrict_ticket_per_user]:checked');
        var enable_seat_plan = $('input[name=enable_seat_plan]:checked');
        var is_price_included_tax = $('input[name=is_price_included_tax]:checked');
        var is_price_included_service_charge = $('input[name=is_price_included_service_charge]:checked');

        var valid = true;
        // if(is_restrict_total_ticket.length && is_enable_discount_for_early_purchase.length && is_restrict_ticket_per_user.length && is_multiple_level_price.length && enable_seat_plan.length && is_price_included_tax.length && is_price_included_service_charge.length)
        if(is_restrict_total_ticket.length && is_enable_discount_for_early_purchase.length && is_restrict_ticket_per_user.length && is_multiple_level_price.length && enable_seat_plan.length)
        {

            var level_dom = $(".input-row-container .level-dom");
            level_dom.each(function(){
                if(!valid){
                    return valid;
                }



                $("input",$(this)).each(function(){
                    if(!valid){
                        return valid;
                    }
                    if($(this).attr('disabled') || $(this).hasClass('disabled')  || $(this).hasClass('level_id') ){

                    }
                    else{
                        if($.trim($(this).val())==""){
                            valid = false;
                            return valid;
                        }
                    }
                });

                $(".level-price-dom input, .level-total-tickets-dom input, .level-max-per-persone-dom input",$(this)).each(function(){
                    if(!valid){
                        return valid;
                    }
                    if($(this).attr('disabled') || $(this).hasClass('disabled')){

                    }
                    else{
                        var val = parseInt($(this).val());
                        if(isNaN(val)){
                            valid = false;
                            $(this).val("");
                            return valid;
                        }
                    }
                });
            });


        }
        else{
            valid = false;
        }

        if(!valid){
            setTimeout(function(){
                swal('All fields are required', "All fields are requird" , "error");;
            })
        }


        return valid;

        var level_dom = $(".input-row-container .level-dom");
        level_dom.each(function(){
            $(this).show();
            enableAllInputs($(".level-color-dom",$(this)));
            enableAllInputs($(".level-name-dom",$(this)));
            enableAllInputs($(".level-price-dom",$(this)));
        });




        var question1 = $('.question1').is(':checked');
        var question2 = $('.question2').is(':checked');
        var question3 = $('.question3').is(':checked');

        if( question1 === false || question2 === false || question3 === false){
            form_valid = false;
            error_type = 'event-question-empty';
        }

        // Level input number validation
        $(".valid-number").each(function(){
            var this_val = $(this).val();
            if (this_val == "" || !$.isNumeric(this_val)) {
                error_type = 'valid-number';
                form_valid = false;
                return false;
            }
        });

        // Level name validation
        $(".valid-input").each(function(){
            var this_val = $(this).val();
            if (this_val == "") {
                error_type = 'valid-input';
                form_valid = false;
                return false;
            }
        });

        if(form_valid == false){
            if(error_type == 'event-question-empty'){
                swal('Questions need to be filled!', "All fields are requird" , "error");
            } else if(error_type == 'valid-number'){
                swal('Please enter valid number', "All fields are requird" , "error");
            } else if(error_type == 'valid-input'){
                swal('Please enter level name', "All fields are requird" , "error");
            } else {
                swal('All fields are required', "All fields are requird" , "error");
            }
        }

        return form_valid;


    }
    else if(step_counter == 2) {

        if($("#ticket-level-html-container .level_price").length == 0){
            form_valid = false;
            swal('', "You must need at least 1 ticket level", "error");
        }




        if(form_valid) {
            $("#ticket-level-html-container .event-ticket-level").each(function () {
                if (!form_valid) {
                    return form_valid;
                }
                var event_ticket_level_block = $(this);

                var level_name = $(".level_name",event_ticket_level_block);
                var level_price = $(".level_price",event_ticket_level_block);
                var total_tickets = $(".total_tickets",event_ticket_level_block);
                var max_per_person = $(".max_per_person",event_ticket_level_block);
                var level_order = $(".level_order",event_ticket_level_block);
                var discount_end_date = $(".discount_end_date",event_ticket_level_block);
                var discount_amount = $(".discount_amount",event_ticket_level_block);
                var current_element = false;

                if(form_valid && level_name.length) {
                    current_element = level_name;
                    current_element.removeClass("red-border");
                    if ($.trim(level_name.val()) == "") {
                        form_valid = false;
                        swal('', "Ticket level name is empty", "error");
                    }
                    else{
                        level_name.val($.trim(level_name.val()));
                    }
                }


                if(form_valid && level_price.length) {
                    current_element = level_price;
                    current_element.removeClass("red-border");
                    var v = parseFloat($.trim(level_price.val()));
                    if (isNaN(v) || v<0) {
                        form_valid = false;
                        swal('', "Base price must be greater than or equal to 0", "error");
                    }
                    else{
                        // level_price.val(parseFloat(v));
                    }
                }


                if(form_valid && total_tickets.length) {
                    current_element = total_tickets;
                    current_element.removeClass("red-border");
                    var v = parseInt($.trim(total_tickets.val()));
                    if (isNaN(v) || v<1) {
                        form_valid = false;
                        swal('', "Total tickets must be greater than 0", "error");
                    }
                    else{
                        total_tickets.val(v);
                    }
                }


                if(form_valid && max_per_person.length) {
                    current_element = max_per_person;
                    current_element.removeClass("red-border");
                    var v = parseInt($.trim(max_per_person.val()));
                    if (isNaN(v) || v<1) {
                        form_valid = false;
                        swal('', "Max per customer must be greater than 0", "error");
                    }
                    else{
                        max_per_person.val(v);
                        if(total_tickets.length && parseInt(max_per_person.val()) > parseInt(total_tickets.val())){
                            form_valid = false;
                            swal('', "Ticket max per customer must be less than or equal to total ticket", "error");
                        }
                    }
                }

                if(form_valid && level_order.length) {
                    current_element = level_order;
                    current_element.removeClass("red-border");
                    var v = parseInt($.trim(level_order.val()));
                    if (isNaN(v) || v<1) {
                        form_valid = false;
                        swal('', "Level order must be greater than 0", "error");
                    }
                    else{
                        // level_order.val(v);
                    }

                    // unique check
                    var level_order_val = [];
                    $('.level_order').each(function( index ) {
                        level_order_val[index] = $(this).val();
                    });

                    var results = [];
                    for (var i = 0; i < level_order_val.length - 1; i++) {
                        if (level_order_val[i + 1] == level_order_val[i]) {
                            results.push(level_order_val[i]);
                        }
                    }
                    if(results.length>0){
                        form_valid = false;
                        swal('', "Ticket sort order should be unique", "error");
                    }
                }

                if(form_valid && discount_end_date.length) {
                    current_element = discount_end_date;
                    current_element.removeClass("red-border");
                    if ($.trim(discount_end_date.val()) == "") {
                        form_valid = false;
                        swal('', "Discount end date is empty", "error");
                    }
                    else{
                        discount_end_date.val($.trim(discount_end_date.val()));
                    }
                }

                if(form_valid && discount_amount.length) {
                    current_element = discount_amount;
                    current_element.removeClass("red-border");
                    var v = parseFloat($.trim(discount_amount.val()));
                    if (isNaN(v) || v<0) {
                        form_valid = false;
                        swal('', "Discount amount must be greater than or equal to 0", "error");
                    }
                    else{
                        // discount_amount.val(parseFloat(v));
                    }
                }

                if(form_valid && total_tickets.length) {
                    $(".total_ticket",event_ticket_level_block).each(function () {
                        if (!form_valid) {
                            return form_valid;
                        }
                        if(notDisabledTicketType($(this))) {
                            current_element = $(this);
                            current_element.removeClass("red-border");

                            if ($.trim($(this).val()) == "") {
                                var v = 0
                            }
                            else {
                                var v = parseInt($.trim($(this).val()));
                            }
                            if (isNaN(v) || v < 0) {
                                form_valid = false;
                                swal('', "Total tickets must be greater than or equal to 0", "error");
                            }
                            else {
                                $(this).val(v);
                                if (parseInt(total_tickets.val()) < v) {
                                    form_valid = false;
                                    swal('', "Ticket Type total ticket must be less or equal to total ticket of that ticket level", "error");
                                }
                            }
                        }
                    });
                }


                if(form_valid && max_per_person.length) {
                    $(".max_ticket_per_user",event_ticket_level_block).each(function () {
                        if (!form_valid) {
                            return form_valid;
                        }
                        if(notDisabledTicketType($(this))) {
                            current_element = $(this);
                            current_element.removeClass("red-border");
                            if ($.trim($(this).val()) == "") {
                                var v = 0
                            }
                            else {
                                var v = parseInt($.trim($(this).val()));
                            }
                            if (isNaN(v) || v < 0) {
                                form_valid = false;
                                swal('', "Max per customer must be greater than or equal to 0", "error");
                            }
                            else {
                                $(this).val(v);
                                var t = $(this).closest('tr').find(".total_ticket");
                                var v1 = v1 = parseInt(t.val());
                                if (t.length && (isNaN(v1) || v1 < 0)) {
                                    v1 = parseInt(t.val());
                                    if (isNaN(v1) || v1 < 0) {
                                        v1 = 0;
                                    }
                                }

                                if (form_valid && parseInt($(this).val()) > v1 && v1 > 0) {
                                    form_valid = false;
                                    swal('', "Ticket max per customer must be less than or equal to total ticket", "error");
                                }

                                if (form_valid && parseInt(max_per_person.val()) < v) {
                                    form_valid = false;
                                    swal('', "Ticket Type max per customer must be less or equal to max per customer of that ticket level", "error");
                                }
                            }
                        }
                    });
                }


                if(form_valid) {
                    $(".price",event_ticket_level_block).each(function () {
                        if (!form_valid) {
                            return form_valid;
                        }
                        if(notDisabledTicketType($(this))){
                            current_element = $(this);
                            current_element.removeClass("red-border");
                            var v = parseFloat($.trim($(this).val()));
                            if (isNaN(v) || v<0) {
                                form_valid = false;
                                swal('', "Ticket price must be greater than or equal to 0", "error");
                            }
                            else{
                                // $(this).val(v);
                            }
                        }

                    });
                }

                if(form_valid && total_tickets.length) {
                    current_element = total_tickets;
                    current_element.removeClass("red-border");
                    var total_tickets_val = parseInt(total_tickets.val());
                    var sum_total_tickets = 0;
                    $(".total_ticket", event_ticket_level_block).each(function () {
                        if(notDisabledTicketType($(this))) {
                            var v = parseInt($(this).val())
                            if (!isNaN(v)) {
                                sum_total_tickets = sum_total_tickets + v;
                            }
                        }
                    });

                    if (sum_total_tickets > total_tickets_val) {
                        form_valid = false;
                        swal('', "Sum of ticket Type total ticket must be less or equal to total ticket of that ticket level", "error");
                    }
                }

                if(form_valid && max_per_person.length) {
                    current_element = max_per_person;
                    current_element.removeClass("red-border");
                    var max_per_person_val = parseInt(max_per_person.val());
                    var total_max_ticket_per_user = 0;
                    $(".max_ticket_per_user", event_ticket_level_block).each(function () {
                        if(notDisabledTicketType($(this))) {
                            var v = parseInt($(this).val())
                            if (!isNaN(v)) {
                                total_max_ticket_per_user = total_max_ticket_per_user + v;
                            }
                        }
                    });

                    if (total_max_ticket_per_user > max_per_person_val) {
                        form_valid = false;
                        swal('', "Sum of ticket Type max per customer must be less or equal to max per customer of that ticket level", "error");
                    }
                }
                
                if(!form_valid && current_element && current_element.length){
                    setTimeout(function () {
                        var scroll_container = $(".event-multiple-mngment");
                        console.log(scroll_container[0].scrollHeight - event_ticket_level_block.height()- 35);
                        console.log(current_element);
                        console.log(current_element.val());
                        console.log(scroll_container.scrollTop());
                        console.log(current_element.offset());
                        scroll_container.animate({
                            // scrollTop: scroll_container[0].scrollHeight - scroll_container[0].clientHeight
                            scrollTop: scroll_container.scrollTop() + current_element.offset().top - 100
                        }, 1000);

                        current_element.addClass("red-border");
                    },500)
                }

            });
        }


    }
    else if ( step_counter == 3 ){

        CKupdate();

        var step2_form = $("#form-step3");

        //form_valid = $("#form-step3").valid();

        console.log(form_valid);

        /*if(form_valid == false){
            swal('Please provide event details!', "All fields are requird" , "error");
        }*/

        if($("#form-step3").valid() == false || validateEventDate()==false || validateBookingDate()==false){
            var form_valid = false;
            swal('Please provide event details!', "All fields are requird" , "error");
        }

    }
    else if(step_counter == 4){

        var form_step3 = $("#form-step4");

            form_step3.removeData('validate').validate({
                rules: {
                    // "Rectangular[enable_seat_plan]": "required",
                    "Rectangular[total_block]": "required",
                    "Rectangular[block_per_row]": "required",
                    "Rectangular[max_seat_each_block]": "required",
                    "Rectangular[max_col_each_block]": "required",
                    // "RectangularTable[enable_seat_plan]": "required",
                    "RectangularTable[total_block]": "required",
                    "RectangularTable[block_per_row]": "required",
                    "RectangularTable[max_row_each_block]": "required",
                    "RectangularTable[max_col_each_block]": "required",
                    "CircularTable[total_block]": "required",
                    "CircularTable[block_per_row]": "required",
                    "CircularTable[max_col_each_block]": "required",
                },
                messages: {
                    // "Rectangular[enable_seat_plan]": "Please select enable disable seat plan",
                    "Rectangular[total_block]": "Please enter total block",
                    "Rectangular[block_per_row]": "Please enter block per row",
                    "Rectangular[max_seat_each_block]": "Please enter max seat each block",
                    "Rectangular[max_col_each_block]": "Please enter max col each block",
                    // "RectangularTable[enable_seat_plan]": "Please select enable disable seat plan",
                    "RectangularTable[total_block]": "Please enter total table",
                    "RectangularTable[block_per_row]": "Please enter table per row",
                    "RectangularTable[max_row_each_block]": "Number of vertical seats  each table",
                    "RectangularTable[max_col_each_block]": "Number of horizontal seats  each table",
                    "CircularTable[total_block]": "Please enter total table",
                    "CircularTable[block_per_row]": "Please enter table per row",
                    "CircularTable[max_col_each_block]": "Please enter number of seats each table",
                }
            });



        form_valid = form_step3.valid();




    } else if(step_counter == 5){

        /*
        var checked = '';

        $('.pre-requisites').each(function(){
            if( $(this).is(':checked') ){
                ++checked;
            }
        });

        if(checked<2){
            form_valid = false;
            swal('At least 2 of the following are required', "" , "error");
        } */

    }

    console.log(form_valid);

    return form_valid;
}

function notDisabledTicketType(target){
    var tr = target.closest("tr");
    if(tr.length && tr.hasClass("disable_event_level_ticket_type")){
        return false;
    }

    return true;
}


function disableAllInputs(t,form_inputs) {
    if(!t){
        t = document;
    }

    if(!form_inputs  || !$.isArray(form_inputs)){
        var form_inputs = [ "input", "select", "textarea","button"];
    }

    if(typeof t == "string"){
        t = $(t);
    }
    if(t.length == 0){
        return false;
    }


    for (var i = 0; i < form_inputs.length; i++) {
        $(form_inputs[i],t).each(function(){
            var el = $(this);
            el.prop("disabled",true);
            el.attr("disabled","disabled").addClass("disabled");
        });

    }
}


function enableAllInputs(t,form_inputs) {
    if(!t){
        t = document;
    }

    if(!form_inputs  || !$.isArray(form_inputs)){
        var form_inputs = [ "input", "select", "textarea","button"];
    }

    if(typeof t == "string"){
        t = $(t);
    }

    if(t.length == 0){
        return false;
    }


    for (var i = 0; i < form_inputs.length; i++) {
        $(form_inputs[i],t).each(function(){
            var el = $(this);
            el.removeAttr("disabled").removeClass("disabled");
            el.prop("disabled",false);
        });

    }
}


function isEmpty(obj) {

    if(obj==undefined || typeof obj =="undefined" || obj==null){
        return true;
    }

    if(Array.isArray(obj)){
        return obj.length == 0;
    }
    else if(!isNaN(obj)){
        return obj * 1 === 0
    }
    else if(typeof obj == "boolean"){
        return obj == false;
    }
    else if(typeof obj == "string"){
        return $.trim(obj) == "";
    }
    else if(obj===true || obj===false){
        return obj;
    }
    for(var prop in obj) {
        if(obj.hasOwnProperty(prop))
            return false;
    }

    return JSON.stringify(obj) === JSON.stringify({});
}


function makeColorPicker(el,option){
    var defaultOption = {
        preferredFormat: "hex",
        showPaletteOnly: true,
        togglePaletteOnly: true,
        togglePaletteMoreText: 'more',
        togglePaletteLessText: 'less',
        // color: 'blanchedalmond',
        palette: [
            ["#000","#444","#666","#999","#ccc","#eee","#f3f3f3","#fff"],
            ["#f00","#f90","#ff0","#0f0","#0ff","#00f","#90f","#f0f"],
            ["#f4cccc","#fce5cd","#fff2cc","#d9ead3","#d0e0e3","#cfe2f3","#d9d2e9","#ead1dc"],
            ["#ea9999","#f9cb9c","#ffe599","#b6d7a8","#a2c4c9","#9fc5e8","#b4a7d6","#d5a6bd"],
            ["#e06666","#f6b26b","#ffd966","#93c47d","#76a5af","#6fa8dc","#8e7cc3","#c27ba0"],
            ["#c00","#e69138","#f1c232","#6aa84f","#45818e","#3d85c6","#674ea7","#a64d79"],
            ["#900","#b45f06","#bf9000","#38761d","#134f5c","#0b5394","#351c75","#741b47"],
            ["#600","#783f04","#7f6000","#274e13","#0c343d","#073763","#20124d","#4c1130"]
        ]
    };

    if(isEmpty(option)){
        option = {};
    }

    option = $.extend(defaultOption,option);

    el.each(function(){
        var isColorPicker = $(this).attr('isColorPicker');
        if(!isColorPicker){
            $(this).spectrum(option);
            $(this).attr('isColorPicker',1);
        }
    });

}


