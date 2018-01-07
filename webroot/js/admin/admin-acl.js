// Admin Access Controll Level.

$(document).ready(function(){

    $('body').delegate('.controller-row','click', function(){

        showSpinner($(this));

        var controller_name = $(this).attr('data-controller-name');
        var opened = $(this).hasClass('opened');

        if(opened == true){
            $(this).removeClass('opened').addClass('closed');
            $('.'+controller_name+'-controller-method').remove();
            hideSpinner("."+controller_name+'-controller');
        } else {
            $(this).removeClass('closed').addClass('opened');
            var method = 'admin/AccessLists/getMethods';
            var data = {controller_name: controller_name};
            commonAjax(data, method,controller_name);
        }

    });

    $('body').delegate('.permission-toggle','click', function(){

        showMethodSpinner($(this));

        var user_type = $(this).attr('data-user-type');
        var access_status = $(this).attr('data-access-status');
        var access_list_id = $(this).closest('tr').attr('data-access-id');
        var controller_name = $(this).closest('tr').attr('data-controller');

        if(access_status == 'fa-check green'){
            $(this).attr('data-access-status','fa-times red');
            $(this).removeClass('fa-check green fa-spin fa-spinner').addClass('fa-times red');
        } else {
            $(this).attr('data-access-status','fa-check green');
            $(this).removeClass('fa-times red fa-spin fa-spinner').addClass('fa-check green');
        }

        var method = 'admin/AccessLists/permissionChange';
        var data = {
            access_list_id: access_list_id,
            controller_name: controller_name,
            access_status: access_status,
            user_type: user_type
        };
        controller_name = 'method';
        commonAjax(data, method,controller_name);

    });

    function commonAjax(data,method,controller_name){
        $.ajax({
            async:true,
            type:'post',
            data: data,
            complete:function(request, json) {
                insertDom(request.responseText,controller_name);
            },
            url: SITE_URL + method
        })
    }

    function insertDom(response,controller_name){

        if(controller_name != 'method'){

            hideSpinner("."+controller_name+'-controller');

            $(response).insertAfter("."+controller_name+'-controller');

        }

    }

    function showSpinner(this_event){
        this_event.find('.controller-name i').addClass('fa-spin fa-spinner')
    }

    function hideSpinner(controller_name){
        $(controller_name).find('.controller-name i').removeClass('fa-spin fa-spinner')
    }

    function showMethodSpinner(this_event){
        this_event.removeClass('fa-check').removeClass('fa-times').addClass('fa-spin fa-spinner')
    }

});







