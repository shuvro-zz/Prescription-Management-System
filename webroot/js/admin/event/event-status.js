$(document).ready(function(){

    $('body').delegate('.event-status','click', function(e){
        e.preventDefault();

        var event_status_dom = $(this).closest('.event-status-section');
        var event_id = $(this).closest('.event-tr').find('.event_id').val();

        if( $(this).hasClass('fa-check') ){
            var status_dom = '<i class="fa fa-remove event-status" style="color: #ff3300"></i>';
        } else  {
            var status_dom = '<i class="fa fa-check event-status" style="color: #00ff00"></i>';
        }

        $(this).closest('.event-status-section').html(status_dom);

        var path = 'admin/events/change-status';
        var post_data = { event_id: event_id };

        $.ajax({
            async:true,
            type:'post',
            data: post_data,
            url: SITE_URL + path,
            complete:function(request, json) {

            }
        })

    });

    $('body').delegate('.slider-status','click', function(e){
        e.preventDefault();

        var slider_status_dom = $(this).closest('.slider-status-section');
        var event_id = $(this).closest('.event-tr').find('.event_id').val();

        if( $(this).hasClass('fa-check') ){
            var status_dom = '<i class="fa fa-remove slider-status" style="color: #ff3300"></i>';
        } else  {
            var status_dom = '<i class="fa fa-check slider-status" style="color: #00ff00"></i>';
        }

        $(this).closest('.slider-status-section').html(status_dom);

        var path = 'admin/events/change-slider-status';
        var post_data = { event_id: event_id };

        $.ajax({
            async:true,
            type:'post',
            data: post_data,
            url: SITE_URL + path,
            complete:function(request, json) {

            }
        })

    });
    

});



