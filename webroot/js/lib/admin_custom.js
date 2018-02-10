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

    $("#new_patient").click(function(){
        $("#patient_drop_down").toggleClass("hide");
        $("#patient_field").toggleClass("hide");

        /*if($("#patient_field").hasClass("hide")){
            $("#patient_field input").prop('required',false);
        }else{
            $("#patient_field input").prop('required',true);
        }*/

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

    $(".date").prop('readonly', true);
    $(".time").prop('readonly', true);


}
