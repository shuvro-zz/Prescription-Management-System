jQuery(document).ready(function ($) {
    //create slug
    jQuery('#name').keyup(function(){
        jQuery('#slug').val(slug(jQuery('#name').val()));
    });



    var slug = function(str) {
        var $slug = '';
        var trimmed = jQuery.trim(str);
        $slug = trimmed.replace(/[^a-z0-9-]/gi, '-').
        replace(/-+/g, '-').
        replace(/^-|-$/g, '');
        return $slug.toLowerCase();
    }

    $("#printButton").click(function(){
        var mode = 'iframe'; //popup
        var close = mode == "popup";
        var options = { mode : mode, popClose : close};
        $("div.printableArea").printArea( options );
    });

    if($('#is_print').val() == 'print'){
        $( "#printButton" ).trigger( "click" );
    }

    $("#new_patient").click(function(){
        $("#patient_drop_down").toggleClass("hide");
        $("#patient_field").toggleClass("hide");

        /*if($("#patient_field").hasClass("hide")){
            $("#patient_field input").prop('required',false);
        }else{
            $("#patient_field input").prop('required',true);
        }*/

    });

    $('.tokenize-sortable-demo1').tokenize2({
        sortable: true,
        displayNoResultsMessage: true

    });


});

function initDatePicker(){

    $(".datetime").each(function(){
        var format = $(this).attr('format')
        if(!format || $.trim(format)==""){
            format = 'Y/m/d g:i A'
        }
        var formatTime = $(this).attr('formatTime')
        if(!formatTime || $.trim(formatTime)==""){
            formatTime = 'h:m A'
        }

        $('.datetime').datetimepicker({
            format:'Y/m/d g:i A',
            formatTime:formatTime
        });

    });

    $(".date").each(function(){
        $(this).datetimepicker({
            timepicker:false,
            format: 'd/m/Y'
        });
    });


    $('.time').datetimepicker({
        datepicker:false,
        format:'H:i'
    });

    $(".date").prop('readonly', false);
    $(".time").prop('readonly', false);

}

function getUserInfo(user_id){
    $('.reset_prescriptions').html('');
    if(user_id==''){
        $('.reset_patient').val('');
        $('#last-visit-date').html('');
    }else{
        $('#loading').removeClass('hide');
        $.post(home_url+'admin/users/get-user/'+user_id,function(response){
            //console.log(response);

            $('#user-phone').val(response.user.phone);
            $('#user-email').val(response.user.email);
            $('#user-age').val(response.user.age);
            $('#user-address').val(response.user.address_line1);
            $('#loading').addClass('hide');
            $('#prescriptions-link').html(response.prescriptions);
            $('#last-visit-date').html(response.last_visit_date);
        },'json');
    }
}




function saveAndPrint(){
    $('#is-print').val(1);
    $( "#prescription-form" ).submit();
}



