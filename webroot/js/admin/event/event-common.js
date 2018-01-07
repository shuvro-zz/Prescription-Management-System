function validateEventDate()
{
    var valid = false;
    var start_date = $('.event-start').val();
    var end_date = $('.event-end').val();

    if(start_date && end_date){
        var start = new Date(Date.parse(start_date));
        var end = new Date(Date.parse(end_date));
        
        if( ( end >= start )) {
            valid = true;
        } else {
            valid = false;
        }
        
    } else {
        valid = true;
    }

    if(start_date && end_date){
        if(valid == false){
            
            var start_error_msg = 'Event end time must be greater than Event start time';
            $('#event-date-error').html(start_error_msg);

        } else {
            emptyEventErrorMsg();
        }
    } else {
        emptyEventErrorMsg();
    }

    return valid;
}

function validateBookingDate()
{
    var valid = false;
    var booking_start = $('.booking-start').val();
    var booking_end = $('.booking-end').val();

    if(booking_start && booking_end){
        booking_end = booking_end.split(' ')[0];
        var end = new Date(booking_end).getTime();

        booking_start = booking_start.split(' ')[0];
        var start = new Date(booking_start).getTime();

        if( ( start >= end )) {
            valid = false;
        } else {
            valid = true;
        }
        
    } else {
        valid = true;
    }

    if(booking_start && booking_end){
        if(valid == false){
            
            var start_error_msg = 'Booking end time must be greater than Booking start time';
            $('#booking-date-error').html(start_error_msg);

        } else {
            emptyBookingErrorMsg();
        }
    } else {
        emptyBookingErrorMsg();
    }

    // Event time and booking time validation
    var booking_end = $('.booking-end').val();
    var booking_end_time = new Date(Date.parse(booking_end)).getTime();

    var event_end_date = $('.event-end').val();
    var event_end_time = new Date(Date.parse(event_end_date)).getTime();
    
    if(booking_end_time >= event_end_time){
        valid = false;
        var start_error_msg = 'Booking end time must be less than Event end time';
        $('#booking-date-error').html(start_error_msg);
    }

    return valid;
}

function emptyEventErrorMsg(){
    $('#event-date-error').html('');
}

function emptyBookingErrorMsg(){
    $('#booking-date-error').html('');
}