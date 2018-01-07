var genCode = false;

// Event description ckeditor
CKEDITOR.replace( 'editor1' , {
    filebrowserBrowseUrl: '/Attachments/browse',
    toolbar: [
        { name: 'basicstyles', groups: [ 'basicstyles', 'cleanup' ], items: [ 'Bold', 'Italic', 'Underline','Source'] },
        { name: 'paragraph', groups: [ 'list', 'indent',  'align', 'bidi' ], items: [ 'NumberedList', 'BulletedList', '-', 'Outdent', 'Indent', '-', 'Blockquote', 'CreateDiv', '-', 'JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyBlock', '-' ] },
        { name: 'links', items: [ 'Link', 'Unlink' ] },
        { name: 'insert', items: [ 'Image', 'Table', 'PageBreak', 'Iframe' ] },
        { name: 'colors', items: [ 'TextColor'] },
        { name: 'tools', items: [ 'Maximize' ] },
        { name: 'others', items: [ '-' ] },

    ]
} );

// CKEDITOR.replace( 'editor2' , {
//     filebrowserBrowseUrl: '/Attachments/browse',
//     toolbar: [
//         { name: 'basicstyles', groups: [ 'basicstyles', 'cleanup' ], items: [ 'Bold', 'Italic', 'Underline','Source'] },
//         { name: 'paragraph', groups: [ 'list', 'indent',  'align', 'bidi' ], items: [ 'NumberedList', 'BulletedList', '-', 'Outdent', 'Indent', '-', 'Blockquote', 'CreateDiv', '-', 'JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyBlock', '-' ] },
//         { name: 'links', items: [ 'Link', 'Unlink' ] },
//         { name: 'insert', items: [ 'Image', 'Table', 'PageBreak', 'Iframe' ] },
//         { name: 'colors', items: [ 'TextColor'] },
//         { name: 'tools', items: [ 'Maximize' ] },
//         { name: 'others', items: [ '-' ] },
//
//     ]
// } );

if(typeof autocomplete_off == "function"){
    autocomplete_off();
}

$(document).ready(function(){

    $("#form-step3").validate({
        rules: {
            slug: {
                required: true,
                remote:{
                    url: SITE_URL + 'admin/events/isEventSlugExist',
                    type:'post',
                    data:{
                        slug: function(){
                            return $('.event-slug').val()
                        },
                        event_id: getEventId()
                    }
                }
            },
            event_name: "required",
            event_display_name: "required",
            event_code: "required",
            start_date: "required",
            end_date: "required",
            booking_start: "required",
            booking_end: "required",
            venue_id: "required",
            event_description: "required",
            ticket_instruction: "required"
        },
        messages: {
            slug: {
                remote: "Event slug already exist",
                required: "Please enter event slug"
            },
            event_name: "Please enter event name",
            event_display_name: "Please enter event display name",
            event_code: "Please enter event code",
            venue_id: "Please select venue",
            event_description: "Please enter event description",
            start_date: "Please enter event start date",
            end_date: "Please enter event end date",
            booking_start: "Please enter event booking start date",
            booking_end: "Please enter event booking end date",
            ticket_instruction: "Please enter ticket instruction"
        }
    });
    
    // Event file upload
    $('#event-banner-image').uploadifive({
        'auto'             : true,
        'formData'         : {
            'timestamp' : '',
            'token'     : ''
        },
        'fileType'     : 'image',
        'removeCompleted' : true,
        'swf': SITE_URL + 'uploadify/uploadify.swf',
        'uploadScript': SITE_URL + 'admin/events/eventBannerUpload',
        'onUploadComplete': function (file, response) {
            if(response) {
                if(response != 'Error'){
                    var uploaded_image_block = $(
                        '<div class="form-group col-md-3">' +
                        '   <div>' +
                        '       <img style="position: absolute; top: 10px"  src="' + SITE_URL + 'uploads/events/' + response + '" height="40" alt="">' +
                        '   </div>' +
                        '   <div>' +
                        '       <input type="hidden" name="banner" value="' + response + '">' +
                        '   </div>'+
                        '</div>'
                    );
                    $('.uploadifive-queue-item').remove();
                } else {
                    var uploaded_image_block = $(
                        '<div class="form-group col-md-6">' +
                        '   <div>' +
                        '       <p>This file formate is not allowed</p>' +
                        '   </div>' +
                        '   <div>' +
                        '       <input type="hidden" name="thumbnail_image" value="' + response + '">' +
                        '   </div>'+
                        '</div>'
                    );
                }
                $('.event-banner').html(uploaded_image_block);
            }
        }
    });

    // Event file upload
    $('#event-slideshow-image').uploadifive({
        'auto'             : true,
        'formData'         : {
            'timestamp' : '',
            'token'     : ''
        },
        'fileType'     : 'image',
        'removeCompleted' : true,
        'swf': SITE_URL + 'uploadify/uploadify.swf',
        'uploadScript': SITE_URL + 'admin/events/eventBannerUpload',
        'onUploadComplete': function (file, response) {
            if(response) {
                if(response != 'Error'){
                    var uploaded_image_block = $(
                        '<div class="form-group col-md-3">' +
                        '   <div>' +
                        '       <img style="position: absolute; top: 10px"  src="' + SITE_URL + 'uploads/events/' + response + '" height="40" alt="">' +
                        '   </div>' +
                        '   <div>' +
                        '       <input type="hidden" name="slideshow_image" value="' + response + '">' +
                        '   </div>'+
                        '</div>'
                    );
                    $('.uploadifive-queue-item').remove();
                } else {
                    var uploaded_image_block = $(
                        '<div class="form-group col-md-6">' +
                        '   <div>' +
                        '       <p>This file formate is not allowed</p>' +
                        '   </div>' +
                        '   <div>' +
                        '       <input type="hidden" name="thumbnail_image" value="' + response + '">' +
                        '   </div>'+
                        '</div>'
                    );
                }
                $('.event-slideshow').html(uploaded_image_block);
            }
        }
    });

    // Event file upload
    $('#event-thumbnail-image').uploadifive({
        'auto'             : true,
        'formData'         : {
            'timestamp' : '',
            'token'     : ''
        },
        'fileType'     : 'image',
        'removeCompleted' : true,
        'swf': SITE_URL + 'uploadify/uploadify.swf',
        'uploadScript': SITE_URL + 'admin/events/eventBannerUpload',
        'onUploadComplete': function (file, response) {
            if(response) {
                if(response != 'Error'){
                    var uploaded_image_block = $(
                        '<div class="form-group col-md-3">' +
                        '   <div>' +
                        '       <img style="position: absolute; top: 10px"  src="' + SITE_URL + 'uploads/events/' + response + '" height="40" alt="">' +
                        '   </div>' +
                        '   <div>' +
                        '       <input type="hidden" name="thumbnail_image" value="' + response + '">' +
                        '   </div>'+
                        '</div>'
                    );
                    $('.uploadifive-queue-item').remove();
                } else {
                    var uploaded_image_block = $(
                        '<div class="form-group col-md-6">' +
                        '   <div>' +
                        '       <p>This file formate is not allowed</p>' +
                        '   </div>' +
                        '   <div>' +
                        '       <input type="hidden" name="thumbnail_image" value="' + response + '">' +
                        '   </div>'+
                        '</div>'
                    );
                }
                $('.event-thumbnail').html(uploaded_image_block);
            }
        }
    });

});

var startvalue=$.trim($("#datetimepicker").val());

if(startvalue.length>0) {
    // setEventCode();
}

$('.datetimepicker').datetimepicker({
    format:'Y/m/d H:i'
});

$('.datepicker').datetimepicker({
    timepicker:false,
    format:'Y/m/d'
});

$('body').delegate('.datetimepicker','change', function(e){
    e.preventDefault();
    validateEventDate();
});

$('body').delegate('.datepicker','change', function(e){
    e.preventDefault();
    validateBookingDate();
});
$('body').delegate('.datepickerbooking','change', function(e){
    e.preventDefault();
    validateBookingDate();
});

$('body').delegate('.glyphicon-calendar','click', function(){
    $(this).closest('.input-group').find('.form-control').datetimepicker('show');
});

$('body').delegate('.event-start .event-end .booking-start .booking-end','change keyup', function(){
    validateEventDate();
});

$('body').delegate('.event-slug, .event-name','change keyup', function(){
    $("#form-step2").validate().element($('.event-slug'));
});


function setEventCode(){

    if(genCode==true){
        return;
    }
    genCode = true;

    var event_id = $('#event_id').val();
    var start_date = $.trim($('#datetimepicker').val());
    var oldData = $.trim($('#datetimepicker').attr('data-old-date'));

    if(oldData == start_date){
        genCode = false;
        return false;
    }


    eventLoading("Generating event code")

    $.ajax({
        async:false,
        type:'post',
        data: { start_date: start_date, event_id: event_id },
        url: SITE_URL + 'admin/events/generateEventCode',
        complete:function(result) {
            $('.event-code').val(result.responseText);
            $('#datetimepicker').attr('data-old-date',start_date);
            genCode = false;
            hideLoading();
        },
        error:function(){
            $('#datetimepicker').val(oldData);
            genCode = false;
            hideLoading();
        }
    })
    genCode = false;
    hideLoading();
}

function slug  (str) {
    var $slug = '';
    var trimmed = $.trim(str);
    $slug = trimmed.replace(/[^a-z0-9-]/gi, '-').
    replace(/-+/g, '-').
    replace(/^-|-$/g, '');
    return $slug.toLowerCase();
}







