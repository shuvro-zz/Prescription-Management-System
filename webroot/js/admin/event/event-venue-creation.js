$(document).ready(function(){

    $('body').delegate('#event-venue-save','click', function(e){
        e.preventDefault();

        var venue_form = $("#event-venue-creation-form");

        venue_form.validate({
            rules: {
                title: 'required',
                address_line_1: 'required',
                state: 'required',
                postcode: {
                    required: true,
                    number: true
                }
            },
            messages: {
                title: "Please enter venue title",
                address_line_1: "Please enter venue address line 1",
                state: "Please enter venue state",
                postcode: {
                    required: "Please enter postcode",
                    number: "Please enter number"
                },
            }
        });

        form_valid = venue_form.valid();

        if(form_valid == false){

            //swal('All fields are required', "" , "error");

        } else {

            eventLoading("Saving venue data");
            var img=$('#image').val();
            var img1=$('#image')[0].files[0];
            var file_data = $('#image').prop('files')[0];
            var formData = new FormData();
            formData.append('image', img1);
            formData.append('title', $('#title').val());
            formData.append('address_line_2', $('#address_line_2').val());
            formData.append('address_line_1', $('#address_line_1').val());
            formData.append('postcode', $('#postcode').val());
            formData.append('country', $('#country').val());
            formData.append('state', $('#state').val());/**/



            var path = 'admin/venues/saveVenue';
            /*var post_data = venue_form.serialize();
            var post_data1=  post_data+'&image='+encodeURIComponent(img)+'&icon_image='+encodeURIComponent(icon_image);*/
           /* var data = new FormData(venue_form);
            data.append('file', jQuery('#file')[0].files[0]);*/


            $.ajax({
                async:true,
                type:'post',
                data: formData,
                url: SITE_URL + path,
                /*dataType : 'json', // data type
                 */
                processData: false,
                contentType: false,
                complete:function(request, json) {
                    hideLoading();
                    try {
                        var response_obj = JSON.parse(request.responseText);
                        if(response_obj.status == 'Error'){
                            showMessage(response_obj);
                            swal(response_obj.msg, "" , "error");
                        } else {
                            $("#event-venue-creation-form")[0].reset();
                            $('#NewEvent').modal('toggle');
                            swal(response_obj.msg, "" , "success");
                            updateVenueDom();
                        }
                    } catch(e) {
                        console.log(e);
                    }
                }
            })

        }

    });

    function updateVenueDom() {
        var path = 'admin/venues/updateVenueDom';
        $.ajax({
            async:true,
            type:'get',
            url: SITE_URL + path,
            complete:function(request, json) {
                $('.venue-dom').html(request.responseText);
            }
        })
    }

    function showMessage(response_obj) {
        if(response_obj.status == 'Error'){
            var msg_class = 'alert-danger';
        } else {
            var msg_class = 'alert-success';
        }
        var msg_dom =  '<div class="alert '+msg_class+'" onclick="this.classList.add("hidden");">';
        msg_dom += '<a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">×</a>';
        msg_dom += '<b>' + response_obj.status + '! </b>' + response_obj.msg + '</div>';

        $('.msg-section').html(msg_dom);
    }

    function eventLoading(msg_title){
        swal({
            title: msg_title,
            text: "",
            imageUrl: "/img/green_loader.gif"
        });
        $('.confirm').remove();
    }

    function hideLoading(){                                                         // Hide sweetalert loading.
        $('.sweet-alert').remove();
        $('.sweet-overlay').remove();
        return true;
    }

});



