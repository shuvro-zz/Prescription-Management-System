
var selected_level = '';
var selected_level_id = '';
var selected_level_color = '';

$(document).ready(function(){
    
    $('body').delegate('.generate-layout','click', function(e){                    // OnCLick generate layout.
        e.preventDefault();
        var valid_seat_plan = validateSeatPlanForm();
        if(valid_seat_plan == true){
            getSeatPlan();
        } else {
            var error_msg = 'Please enter all seat information';
            swal(error_msg, "All fields are required." , "error");
        }
    });

    $('body').delegate('.seat-level','change', function(){                         // OnChange seat level.
        if(this.checked) {
            $('.seat-level').not(this).prop("checked",false);                      // Make only one selected level.
            selected_level = $(this).attr('data-level');
            selected_level_id = $(this).attr('data-level-id');
            selected_level_color = $(this).attr('data-level-color');
        }
    });

    $('body').delegate('.seat','change', function(){                               // OnChange seat.
        var level_check = validateLevelInputs();
        if(level_check == true){
            var has_class = $(this).find('label').hasClass(selected_level_color);
            if(has_class == false){
                $(this).find('label').attr('class', '');
                $(this).find('label').addClass(selected_level_color);
                $(this).find('.seat_level').val(selected_level);
                $(this).find('.seat_level_id').val(selected_level_id);
            } else {
                $(this).find('label').removeClass(selected_level_color);
                $(this).find('.seat_level').val('');
                $(this).find('.seat_level_id').val('');
            }
            countLevelSeat();
        } else {
            var error_msg = 'Please select level!';
            swal(error_msg, "Level selection is required." , "error");
        }

    });

    $('body').delegate('.save-layout','click', function(e){                        // OnClick save layout.
        e.preventDefault();
        var valid_seat_plan = validateSeatPlanForm();
        if(valid_seat_plan == true){
            saveSeatPlan();
        } else {
            var error_msg = 'Please enter all seat information';
            swal(error_msg, "All fields are required." , "error");
        }
    });

    $('body').delegate('.reset-layout','click', function(e){                      // OnClick layout seat reset button.
        e.preventDefault();
        var level_color = $(this).attr('data-level-color');
        $('#level-seat-mapping-form .'+level_color).each(function(){
            $(this).parent('.seat').find('.seat_level').val('');
            $(this).parent('.seat').find('.seat_level_id').val('');
            $(this).removeClass(level_color);
        });
    });

});

function saveSeatPlan(){
    var section_id = 'save-seat-plan';
    var path = 'admin/SeatPlans/saveSeatPlan';
    var data = $('#level-seat-mapping-form, #seat-plan-form').serialize()
    commonAjax(data, path, section_id);
}

function getSeatPlan(){
    showLoading('.seat-map-layout');
    var section_id = 'seat-map-layout';
    var path = 'admin/SeatPlans/getSeatPlan';
    var data = $('#seat-plan-form').serialize()
    commonAjax(data, path, section_id);
}

function commonAjax(data,path,section_id){
    $.ajax({
        async:true,
        type:'post',
        data: data,
        url: SITE_URL + path,
        complete:function(request, json) {
            ajaxResponseHandaler(request.responseText,data,section_id);
        }
    })
}

function ajaxResponseHandaler(result,data,section_id){

    if(section_id == 'seat-map-layout'){
        $('.seat-map-layout').html(result);
        scrollGoTo('.seat-map-layout');
        countLevelSeat();
    } else if(section_id == 'save-seat-plan'){
        getSeatPlan();
    }

}

function showLoading(loader_dom){
    var html_content  = '<div class="center-align blue-loader" style="margin-top: 50px;margin-left: 500px;"> <img src="/img/blue_loader.gif" alt="Loading" /> </div>';
    $(loader_dom).html(html_content);
}

function scrollGoTo(classOrId){
    $('html,body').animate({scrollTop: $(classOrId).offset().top}, 'slow');
}

function countLevelSeat() {
    $('.total-seat').each(function(){
        var total_seat_this = $(this);
        var level_color = $(this).attr('data-level-color');
        var level_seat_count = 0;
        $('#level-seat-mapping-form .'+level_color).each(function(){
            ++level_seat_count;
        });
        $(this).val(level_seat_count);
    });

}

function validateSeatPlanForm(){
    var seat_plan_form = $("#seat-plan-form");

    seat_plan_form.validate({
        rules: {
            no_of_rows: {
                required: true,
                number: true,
                maxlength: 3
            },
            no_of_rows_in_block: {
                required: true,
                number: true,
                maxlength: 3
            },
            block_row_seat: {
                required: true,
                number: true,
                maxlength: 3
            },
            seat_per_block_row: {
                required: true,
                number: true,
                maxlength: 3
            },
            block_last_row_seat_numbres: {
                required: true,
                number: true,
                maxlength: 3
            }
        },
        messages: {
            no_of_rows: {
                required: "Please enter no of rows",
                number: "Please enter number",
                maxlength: "Max length is 3"
            },
            no_of_rows_in_block: {
                required: "Please enter no of rows in block",
                number: "Please enter number",
                maxlength: "Max length is 3"
            },
            block_row_seat: {
                required: "Please enter block row seat",
                number: "Please enter number",
                maxlength: "Max length is 3"
            },
            seat_per_block_row: {
                required: "Please enter seat per block row",
                number: "Please enter number",
                maxlength: "Max length is 3"
            },
            block_last_row_seat_numbres: {
                required: "Please enter block last row seat numbres",
                number: "Please enter number",
                maxlength: "Max length is 3"
            }
        }
    });

    return seat_plan_form.valid();
}

function validateLevelInputs() {
    var valid_level = false;
    $('.seat-level').each(function(){
        if($(this).is(':checked')){
            valid_level = true;
        }
    });
    return valid_level;
}





