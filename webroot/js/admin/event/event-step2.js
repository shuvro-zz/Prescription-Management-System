

if(typeof autocomplete_off == "function"){
    autocomplete_off();
}

// color picker
if(typeof showHideLavelInputes == 'function'){
    makeColorPicker($("input[type='color']"));
    showHideLavelInputes();
}

$('table').on('click','tr .ticket-type-remove',function(e){
    e.preventDefault();
    $(this).closest('tr').remove();
    checkTicketTypeExist();
});

$(document).on("click",".disable_event_level_ticket_type_btn",function(){
    var tr = $(this).closest("tr");
    var hi = $("."+ $(this).attr("data-targer"));
    console.log($(this).attr("data-targer"))
    console.log(tr)
    console.log(hi);
    if(tr.length && hi.length){
        hi.val(1);
        tr.addClass("disable_event_level_ticket_type").hide();
    }
});
function addTicketType() {
    var t = new Date().getTime(); 
    var ticket_type_row = '<tr>';
        ticket_type_row +=      "<td class='text-defult'><input class='form-control' placeholder='' type='hidden' name='ticket_type_id["+t+"]'><input class='form-control' placeholder='' type='text' name='ticket_type["+t+"]'></td>";
        ticket_type_row +=      "<td class='fixed-width'><input class='form-control text-center int_number' placeholder='' type='text'  name='ticket_type_order["+t+"]'></td>";
        ticket_type_row +=      "<td class='fixed-width'><a href='#' class='ticket-type-remove'><img src='/css/admin_styles/images/trash-icon.png'> </a></td>";
        ticket_type_row += '</tr>';
    $(ticket_type_row).appendTo("#tbody-ticket-type");

    checkTicketTypeExist();
}

function applyTicketType() {
    var step_counter = 2;
    var event_id = getEventId();

    if(!checkTicketTypeExist()){
        return;
    }

    if (event_id) {
        var valid = true;
        $("#tbody-ticket-type input[type='text']").each(function(){
            var v = $.trim($(this).val());
            $(this).val(v);
            if(v == ""){
                valid = false;
            }
        });
        if(valid) {
            var msg_title = 'Applying ticket type';
            eventLoading(msg_title);
            var response_id = 'get-event-step';
            var path = 'admin/events/apply-ticket-type-to-level';
            var event_id = getEventId();
            var post_data = $("#tbody-ticket-type").serializeToJson();
            post_data.event_id = event_id;
            post_data.step_counter = step_counter;
            // post_data.tmp_level_data = {};
            // $(".event-ticket-level",$("#ticket-level-html-container")).each(function(){
            //     var level_id = $(this).attr('level_id');
            // })
            post_data = $("#form-step2").serialize();
            // console.log(post_data.tmp_level_data);
            // return;die;
            commonAjax(post_data, path, response_id);
        }
        else{
            swal('Please provide ticket type details!', "All fields are requird" , "error");
        }
    } else {
        swal('Please complete Pricing Preference step first', "", "error");
    }
}

function addLevel(){
    var t = new Date().getTime();
    var ht = $("#new-ticket-level-html-container").html();
    ht = ht.replace(/---index---/g,"new_"+t);
    var level_dom = $(ht).clone();
    level_dom.find("input").val("").removeAttr("readonly").removeAttr("isColorPicker").removeAttr("min");
    level_dom.find("input[type='color']").val("#e0e0e0");
    level_dom.find('.sp-replacer').remove();
    level_dom.find('.sp-replacer').remove();

    var d = $("#ticket-level-html-container");
    d.append(level_dom);
    setTimeout(function () {
        initStep2();
        var scroll_container = $(".event-multiple-mngment")
        scroll_container.animate({
            // scrollTop: scroll_container[0].scrollHeight - scroll_container[0].clientHeight
            scrollTop: scroll_container[0].scrollHeight - level_dom.height()- 35
        }, 1000);
    },500)
}

function deleteLevel(_this){
    if($("#ticket-level-html-container .event-ticket-level").length > 1){
        $(_this).closest("div.event-ticket-level").remove();
    }
}

function checkTicketTypeExist(){
    return true;
    if($("#tbody-ticket-type input[type='text']").length > 0){
        $(".apply-ticket-type-to-level").removeAttr('disabled');
        $(".apply-ticket-type-to-level").prop('disabled',false);
        $(".apply-ticket-type-to-level").addClass('disabled');
        return true;
    }
    else{
        $(".apply-ticket-type-to-level").attr('disabled','disabled');
        $(".apply-ticket-type-to-level").prop('disabled',true);
        $(".apply-ticket-type-to-level").removeClass('disabled');
        return false;
    }
}
checkTicketTypeExist();


function initStep2() {
    $('.datetimepicker').datetimepicker({
        format: 'Y/m/d H:i'
    });

    $('.datepicker').datetimepicker({
        timepicker: false,
        format: 'Y/m/d'
    });


    makeColorPicker($("input[type='color']"));
}
initStep2();
