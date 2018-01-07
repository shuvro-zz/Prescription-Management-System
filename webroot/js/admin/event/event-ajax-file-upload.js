$(document).ready(function(){

    $('#event-banner-image').uploadifive({
        'auto'             : true,
        'formData'         : {
            'timestamp' : '',
            'token'     : ''
        },
        'removeCompleted' : true,
        'swf': SITE_URL + 'uploadify/uploadify.swf',
        'uploadScript': SITE_URL + 'admin/events/eventBannerUpload',
        'onUploadComplete': function (file, response) {
            if(response) {
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
                $('.event-banner').append(uploaded_image_block);
            }
        }
    });

});
