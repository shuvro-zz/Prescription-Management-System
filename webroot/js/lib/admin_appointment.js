jQuery(document).ready(function ($) {

    jQuery('#appointment-form').validate({
    });

    //When page load.......
    if ( $("#today-appointment").is(":checked")) {
        $('#serial-no-section').removeClass('hidden');
    }

    if ( $("#appointments").is(":checked")) {
        $('#appointment_calender_date').removeClass('hidden');
    }
    //End when page load.......

    //Onchange.................
    $('#today-appointment').change(function () {

        if ($(this).prop("checked")) {

            //Get last serial no
            setAppointmentLastSerialNo();

            $('#serial-no-section').removeClass('hidden');
            $('#appointment_calender_date').addClass('hidden');
        }
    });

    $('#appointments').change(function () {

        if ($(this).prop("checked")) {

            setAppointmentLastSerialNo()

            $('#serial-no-section').removeClass('hidden');
            $('#appointment_calender_date').removeClass('hidden');
        }
    });

    $('#appointment-calender-date').change(function () {
        setAppointmentLastSerialNo()
    });
    //End onchange.................

});

function initDatePicker(){

    $(".appointment_calender_date").each(function(){
        $(this).datetimepicker({
            timepicker:false,
            format: 'd-m-Y',
            minDate: new Date()
        });
    });
}

//Set user id to add patient to today appointment
function setAppointmentUserId(e) {
    $('#user-id').val(e.getAttribute('user_id'))
    setAppointmentLastSerialNo();
}

//Get last serial no for today appointment
function setAppointmentLastSerialNo(){

    $('#today-appointment-loading').removeClass('hide');

    if ($('#today-appointment').prop("checked")) {
        $.get(home_url+"admin/users/get-today-appointment-last-serial-no", function(response, status){
            $('#serial-no').val($.parseJSON(response).last_serial_no+1)

            $('#today-appointment-loading').addClass('hide');
        });
    } else if ($('#appointments').prop("checked")) {

        var appointment_calender_date = $('#appointment-calender-date').val();

        $.get(home_url+"admin/users/get-appointment-date-last-serial-no/"+appointment_calender_date, function(response, status){
            $('#serial-no').val($.parseJSON(response).last_serial_no+1)
            $('#today-appointment-loading').addClass('hide');
        });
    }

}
