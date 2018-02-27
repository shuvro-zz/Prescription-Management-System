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

    $(".date").prop('readonly', true);
    $(".time").prop('readonly', true);

}

function getUserInfo(user_id){
    if(user_id==''){
        $('.reset_patient').val('');
    }else{
        $('#loading').removeClass('hide');
        $.post(home_url+'admin/users/get-user/'+user_id,function(response){

            $('#user-phone').val(response.user.phone);
            $('#user-email').val(response.user.email);
            $('#user-age').val(response.user.age);
            $('#user-address').val(response.user.address_line1);
            $('#loading').addClass('hide');
            $('#prescriptions_link').html(response.prescriptions);
        },'json');
    }
}

/*var index = 0;
var ids = [];*/

function getDiagnosis(e){
    /*if($(e)[0].checked){
        ids[index] = e.value;
        index++;
    }else{
        ids = ids.filter(function(id) {
            return id !== e.value;
        });

        index--;
    }

    var all_id = ids.toString();
    all_id = all_id.replace(/,/g , "_");*/

    var checkedVals = $('input:checkbox:checked').map(function() {
        return this.value;
    }).get();

    var all_id = checkedVals.join("_");

    $('.medicines .tokenize-sortable-demo1').trigger('tokenize:clear');
    $('.tests .tokenize-sortable-demo1').trigger('tokenize:clear');
    $('#all_instructions').val('');
    if(all_id!=''){
        $('#loading').removeClass('hide');
        $.post(home_url+'admin/diagnosis/get-diagnosis/'+all_id ,function(response){
            $.each(response.medicines, function( id, value ) {
                $('.medicines .tokenize-sortable-demo1').trigger('tokenize:tokens:add', [id, value, true]);
            });

            $.each(response.tests, function( id, value ) {
                $('.tests .tokenize-sortable-demo1').trigger('tokenize:tokens:add', [id, value, true]);
            });

            $('#all_instructions').val(response.all_instructions);
            $('#loading').addClass('hide');

        },'json');
    }
}



