
// ----------------------------------------------------------------------
// Start Seat Plan JS -- Rakib




var generateSeatPlanTimer = false;
if(!seat_plan_settings){
    var seat_plan_settings = {};
}
if(!seat_plan_type){
    var seat_plan_type = "";
}
if(!seat_plan_settings){
    var seat_plan_settings = {};
}
if(!event_levels){
    var event_levels = {};
}
var notSelectedColor = "#FFFFFF";


if(typeof autocomplete_off == "function"){
    autocomplete_off();
}

console.log(typeof autocomplete_off)


function enable_disable_seat_plan(){



    var step_counter = getStepCounter();
    if(step_counter != 4){
        return ;
    }

    var plan_type = $("[name='seat_plan_type']:checked");
    seat_plan_type = "";
    if(plan_type.length == 1 && $.trim(plan_type.val())!=""){
        seat_plan_type = plan_type.val();
    }

    seat_plan_settings.seat_plan_type = seat_plan_type;




    var el = $("[name='enable_seat_plan']:checked")

    if(el.length && el.val() == 1){
        enableAllInputs(".seat_plan_type_radio");
        $(".seat_plan_type_radio").show();
    }
    else{
        disableAllInputs("#seat-plan-details");
        $("#seat-plan-details").hide();
        disableAllInputs(".seat_plan_type_radio");
        $(".seat_plan_type_radio").hide();
    }


    if(el.length && el.val() == 1 && plan_type.length==1){
        enableAllInputs("#seat-plan-details");
        disableAllInputs(".seat_plan_type_setting");
        enableAllInputs($(".seat_plan_type_setting."+seat_plan_settings.seat_plan_type));

        $(".seat_plan_type_setting:not(."+seat_plan_settings.seat_plan_type+")").hide();
        $(".seat_plan_type_setting."+seat_plan_settings.seat_plan_type).show();
        $("#seat-plan-details").show();
        // create_seat_plan_html();
    }
    else if(el.length && el.val() == 1){
        disableAllInputs("#seat-plan-details");
        $("#seat-plan-details").hide();
    }
}


function generateSeatPlan(refresh){
    var step_counter = getStepCounter();
    if(step_counter != 4){
        return ;
    }

    if(generateSeatPlanTimer!=false){
        clearTimeout(generateSeatPlanTimer);
        generateSeatPlanTimer = false;
    }
    generateSeatPlanTimer = setTimeout(function(){

        seat_plan_settings.total_block = parseInt($("[name='total_block']").val());
        seat_plan_settings.max_seat_each_block = parseInt($("[name='max_seat_each_block']").val());
        seat_plan_settings.max_col_each_block = parseInt($("[name='max_col_each_block']").val());


        for(i in seat_plan_settings){
            if( isNaN(seat_plan_settings[i]) || seat_plan_settings[i] == NaN){
                seat_plan_settings[i] = 0;
                return;
            }
        }



        seat_plan_settings.max_row_each_block = Math.ceil(seat_plan_settings.max_seat_each_block / seat_plan_settings.max_col_each_block);
        seat_plan_settings.max_seat_each_block = seat_plan_settings.max_row_each_block * seat_plan_settings.max_col_each_block;
        seat_plan_settings.total_seat = seat_plan_settings.total_block * seat_plan_settings.max_seat_each_block;


        $("[name='max_seat_each_block']").val(seat_plan_settings.max_seat_each_block);

        seat_plan_settings.block = new Array();


        for(i=1; i<=seat_plan_settings.total_block;i++){

            if(!seat_plan_settings.block){
                seat_plan_settings.block = new Array();
                seat_plan_settings.SeatPlanBlocks = new Array();
            }

            if(!seat_plan_settings.block[i]){
                seat_plan_settings.block[i] = {};
                seat_plan_settings.SeatPlanBlocks[i] = {};
            }


            seat_plan_settings.block[i].block_name = alphaIndex(i);

            seat_plan_settings.SeatPlanBlocks[i].event_id = getEventId();
            seat_plan_settings.SeatPlanBlocks[i].seat_plan_type = seat_plan_type;
            seat_plan_settings.SeatPlanBlocks[i].block_number = i;
            seat_plan_settings.SeatPlanBlocks[i].block_name = alphaIndex(i);
            seat_plan_settings.SeatPlanBlocks[i].total_col = seat_plan_settings.max_seat_each_block;
            seat_plan_settings.SeatPlanBlocks[i].total_row = seat_plan_settings.max_row_each_block;
            seat_plan_settings.SeatPlanBlocks[i].total_seat = seat_plan_settings.total_seat;

            if(!seat_plan_settings.block[i]['seat_plan']){
                seat_plan_settings.block[i]['seat_plan'] = new Array();
            }

            for(row=1; row<=seat_plan_settings.max_row_each_block;row++){
                for(col=1; col<=seat_plan_settings.max_col_each_block;col++){
                    if(!seat_plan_settings.block[i]['seat_plan'][row]){
                        seat_plan_settings.block[i]['seat_plan'][row] = new Array();
                    }
                    if(!seat_plan_settings.block[i]['seat_plan'][row][col]){
                        seat_plan_settings.block[i]['seat_plan'][row][col] = {};
                    }

                    if(seat_plan_settings.block[i]['seat_plan'][row][col]['deleted']==undefined || seat_plan_settings.block[i]['seat_plan'][row][col]['deleted']=='undefined'){
                        seat_plan_settings.block[i]['seat_plan'][row][col]['deleted'] = 0;
                    }

                    if(seat_plan_settings.block[i]['seat_plan'][row][col]['booked']==undefined || seat_plan_settings.block[i]['seat_plan'][row][col]['booked']=='undefined'){
                        seat_plan_settings.block[i]['seat_plan'][row][col]['booked'] = 0;
                    }

                    if(seat_plan_settings.block[i]['seat_plan'][row][col]['disabled']==undefined || seat_plan_settings.block[i]['seat_plan'][row][col]['disabled']=='undefined'){
                        seat_plan_settings.block[i]['seat_plan'][row][col]['disabled'] = 0;
                    }
                    else{
                        colsole.log("ok");
                    }
                    if(seat_plan_settings.block[i]['seat_plan'][row][col]['seat_no']==undefined || seat_plan_settings.block[i]['seat_plan'][row][col]['seat_no']=='undefined'){
                        seat_plan_settings.block[i]['seat_plan'][row][col]['seat_no'] = row+"_"+col;
                    }

                }
            }
        }



        seat_plan_settings = create_seat_plan_html(seat_plan_settings);

        generateSeatPlanTimer = false;
    },1000)
}



function alphaIndex(i){
    var total_char_symble = 26;
    if(!i || i<=0){
        return "";
    }
    var block = "";
    var alpla_char = ["A","B","C","D","E","F","G","H","I","J","K","L","M","N","O","P","Q","R","S","T","U","V","W","X","Y","Z"];

    if(i<=total_char_symble){
        block = alpla_char[i-1];
    }
    else{
        var j = Math.floor(i/total_char_symble);
        i = i%total_char_symble;
        if(i == 0){
            block = alphaIndex(total_char_symble)+block;
            if(j<total_char_symble) {
                j = j-1;
            }
        }
        else{
            block = alphaIndex(i)+block;
        }
        i = j;
        block = alphaIndex(i)+block;
    }
    return block;
}


//    var n = 26*2;
//    n = n + 1;
//    // console.log(n);
//    // console.log(alphaIndex(n));

function create_seat_plan_html(){
    seat_count.status = false;
    if(seat_plan_type=="Rectangular"){
        return create_rectangular_seat_plan_html();
    }
    else if(seat_plan_type=="RectangularTable"){
        return create_rectangular_table_seat_plan_html();
    }
    else if(seat_plan_type=="CircularTable"){
        return create_circular_table_seat_plan_html();
    }

    return false;
}



var row_interval = false;
var col_interval = false;
var timeout_diff = 10;
var seat_plan_html_container;

function create_rectangular_seat_plan_html(i){
    var step_counter = getStepCounter();
    if(step_counter != 4){
        return ;
    }

    if(!seat_plan_settings.total_block || seat_plan_settings.total_block<=0 || !seat_plan_settings.SeatPlanBlocks || isEmpty(seat_plan_settings.SeatPlanBlocks)){
        return;
    }

    $("#seat-plan-html > .seat-plan-circle").remove();
    seat_plan_html_container = $("<div class='seat-plan-circle' id='block_row_1'></div>");
    $("#seat-plan-html").prepend(seat_plan_html_container);

    if (!seat_plan_settings.block_per_row || seat_plan_settings.block_per_row <= 0) {
        seat_plan_settings.block_per_row = seat_plan_settings.total_block;
    }

    if(!i){
        i = 1;
    }
    create_rectangular_block_html(i)

}
function create_rectangular_block_html(i, block_row,target){
    if(i>seat_plan_settings.total_block){
        return;
    }

    if(seat_plan_settings.block[i]) {

        if(target){
            var inner_body_seat = target;
            inner_body_seat.html("");
        }
        else{
            var inner_body_seat = $("<div class='inner-body-seat' id='inner-body-seat-" + i + "'></div>");
            seat_plan_html_container.append(inner_body_seat);
        }



        var table_box = $("<div class='table-box flex-container' id='table_box_block_" + i + "'  block='"+i+"' ></div>")
            .html("<h3 class='block-name' style='text-align: left'>" + seat_plan_settings.block[i].block_name + "</h3>")
            .appendTo(inner_body_seat);


        max_seat_each_block = seat_plan_settings.SeatPlanBlocks[i].total_seat;

        var row = 1;
        setTimeout(function(){
            create_rectangular_row_html(i,row,table_box,max_seat_each_block);
        },timeout_diff)
    }



    if(!target){
        setTimeout(function(){

            if (i >= seat_plan_settings.block_per_row && i % seat_plan_settings.block_per_row == 0 && i != seat_plan_settings.total_block) {
                if(!block_row){
                    block_row = 1;
                }
                ++block_row;
                seat_plan_html_container_tml = $("<div class='seat-plan-circle' id='block_row_"+block_row+"'></div>");
                seat_plan_html_container.after(seat_plan_html_container_tml);
                seat_plan_html_container = seat_plan_html_container_tml;
            }

            create_rectangular_block_html(i+1,block_row);
        },timeout_diff)
    }



}
function create_rectangular_row_html(i,row,table_box,max_seat_each_block){

    if(row <= seat_plan_settings.SeatPlanBlocks[i].total_row){
        if (seat_plan_settings.block[i]['seat_plan'][row]) {
            var table_row = $("<div class='table-row top-seat' id='table_row_block_" + i + " row_" + row + "'></div>").appendTo(table_box);
            var table_row_ul = $("<ul class='seat-list list-inline top table_row_ul' id='table_row_ul_block_" + i + "_row_" + row + "' block='" + i + "' row='" + row + "'></ul>").appendTo(table_row);

            if(!col){
                var col = 1;
            }

            setTimeout(function () {
                create_rectangular_col_html(i, row, col, table_row_ul, max_seat_each_block)
            }, timeout_diff)
        }

        setTimeout(function(){
            create_rectangular_row_html(i,row+1,table_box,max_seat_each_block);
        },timeout_diff);
    }
}
function create_rectangular_col_html(i,row,col,table_row_ul,max_seat_each_block){
    if(col <= seat_plan_settings.SeatPlanBlocks[i].total_col && max_seat_each_block > 0) {
        if (seat_plan_settings.block[i]['seat_plan'][row][col]) {
            var li = "<li class='seat-plan-contextMenu block_" + i + " row_" + row + " col_" + col + " on-hover'  id='seat_" + i + "_" + row + "_" + col + "' data-toggle='tooltip' title='" + seat_plan_settings.block[i].seat_plan[row][col].seat_no + " (" + seat_plan_settings.block[i].block_name + "_" + row + "_" + col + ")" + "' ";

            li = li + " block='" + i + "' row='" + row + "' col='" + col + "' seat_no='" + seat_plan_settings.block[i]['seat_plan'][row][col]['seat_no'] + "'";

            if (seat_plan_settings.block[i].seat_plan[row][col]['deleted']) {
                li = li + " deleted='1' ";
            }


            if (seat_plan_settings.block[i] && seat_plan_settings.block[i]['seat_plan'] && seat_plan_settings.block[i]['seat_plan'][row] && seat_plan_settings.block[i]['seat_plan'][row][col]) {


            }
            else {
                if (!seat_plan_settings.block[i].block_name) {
                    seat_plan_settings.block[i].block_name = alphaIndex(i);
                }
                if (!seat_plan_settings.block[i].seat_plan) {
                    seat_plan_settings.block[i].seat_plan = new Array();
                }
                if (!seat_plan_settings.block[i].seat_plan[row]) {
                    seat_plan_settings.block[i].seat_plan[row] = new Array();
                }
                if (!seat_plan_settings.block[i].seat_plan[row][col]) {
                    seat_plan_settings.block[i].seat_plan[row][col] = {};
                }
                seat_plan_settings.block[i].seat_plan[row][col]['seat_no'] = row + "_" + col;
                seat_plan_settings.block[i].seat_plan[row][col]['booked'] = 0;
                seat_plan_settings.block[i].seat_plan[row][col]['delete'] = 0;
                seat_plan_settings.block[i].seat_plan[row][col]['disabled'] = 0;
                seat_plan_settings.block[i].seat_plan[row][col]['lavel_id'] = 0;
            }


            // li.attr('id',"seat_"+i+"_"+row+"_"+col)
            //     .attr("data-toggle","tooltip")
            //     .attr("title",seat_plan_settings.block[i].seat_plan[row][col].seat_no+" ("+seat_plan_settings.block[i].block_name+"_"+row+"_"+col+")");
//                    var hinput = $("<input name='"+seat_plan_settings.block_name+"_"+seat_plan_settings.block[i].seat_plan[row][col]['seat_no']+"' type='hidden' />");
//                    hinput.val(JSON.stringify(seat_plan[row][col])).appendTo(li);
            li = li + ">" + getColorImage(seat_plan_settings.block[i].seat_plan[row][col]['lavel_id'], i, row, col) + "</li>";
            table_row_ul.append(li);
            // li = $(li).tooltip();
        }
        setTimeout(function(){
            create_rectangular_col_html(i,row,col+1,table_row_ul,--max_seat_each_block)
        },timeout_diff)
    }
    else{
        if(i>=seat_plan_settings.total_block){
            // $('[data-toggle="tooltip"]').tooltip();
            showSeatCounter();
        }
    }
}

function create_rectangular_table_seat_plan_html(i){
    var step_counter = getStepCounter();
    if(step_counter != 4){
        return ;
    }

    if(!seat_plan_settings.total_block || seat_plan_settings.total_block<=0 || !seat_plan_settings.SeatPlanBlocks || isEmpty(seat_plan_settings.SeatPlanBlocks)){
        return;
    }

    $("#seat-plan-html > .seat-plan-circle").remove();
    seat_plan_html_container = $("<div class='seat-plan-circle' id='block_row_1'></div>");
    $("#seat-plan-html").prepend(seat_plan_html_container);

    if (!seat_plan_settings.block_per_row || seat_plan_settings.block_per_row <= 0) {
        seat_plan_settings.block_per_row = seat_plan_settings.total_block;
    }

    if(!i){
        i = 1;
    }
    create_rectangular_table_block_html(i)

}
function create_rectangular_table_block_html(i, block_row,target){
    if(i>seat_plan_settings.total_block){
        return;
    }

    if(seat_plan_settings.block[i]) {

        if(target){
            var inner_body_seat = target;
            inner_body_seat.html("");
        }
        else{
            var inner_body_seat = $("<div class='inner-body-seat' id='inner-body-seat-" + i + "'></div>");
            seat_plan_html_container.append(inner_body_seat);
        }


        var table_box = $("<div class='table-box flex-container' id='table_box_block_" + i + "'  block='"+i+"'></div>")
        // .html("<h3 class='block-name' style='text-align: left'>" + seat_plan_settings.block[i].block_name + "</h3>")
            .appendTo(inner_body_seat);


        max_seat_each_block = seat_plan_settings.SeatPlanBlocks[i].total_seat;

        var table_table_center = "<div class='table-table-center' id='table_center_block_" + i + "'><div class='no-of-table'><p>"+seat_plan_settings.block[i].block_name.replace("Table", "Table:")+"</p></div></div>";
        var table_circular = $("<div class='table-circular flex-container' id='table_circular_block_" + i + "'></div>");
        table_circular.append(table_table_center);

        var table_row = {};
        var table_row_ul = {};
        for(row=1; row<=4;row++) {
            if (row == 1) {
                // table_row = "<div class='table-row top-seat'><ul class='seat-list list-inline top'>";
                table_row[row] = $("<div class='table-row top-seat' id='table_row_block_" + i + "row_" + row + "'></div>").appendTo(table_box);
                table_row_ul[row] = $("<ul class='seat-list list-inline top table_row_ul' id='table_row_ul_block_" + i + "_row_" + row + "' block='" + i + "' row='" + row + "'></ul>").appendTo(table_row[row]);
            }
            else if (row == 3) {
                // table_row = "<div class='table-row btm-seat'><ul class='seat-list list-inline'>";
                table_row[row] = $("<div class='table-row btm-seat' id='table_row_block_" + i + "row_" + row + "'></div>").appendTo(table_box);
                table_row_ul[row] = $("<ul class='seat-list list-inline table_row_ul' id='table_row_ul_block_" + i + "_row_" + row + "' block='" + i + "' row='" + row + "'></ul>").appendTo(table_row[row]);
            }
            else if (row == 2) {
                // table_row = "<div class='left-seat'><ul class='list-group'>";
                table_row[row] = $("<div class='left-seat' id='table_row_block_" + i + "row_" + row + "'></div>").prependTo(table_circular);
                table_row_ul[row] = $("<ul class='list-group table_row_ul' id='table_row_ul_block_" + i + "_row_" + row + "' block='" + i + "' row='" + row + "'></ul>").appendTo(table_row[row]);
                table_circular.appendTo(table_box)
            }
            else if (row == 4) {
                // table_row = "<div class='right-seat'><ul class='list-group'>";
                table_row[row] = $("<div class='right-seat' id='table_row_block_" + i + "row_" + row + "'></div>").appendTo(table_circular);
                table_row_ul[row] = $("<ul class='list-group table_row_ul' id='table_row_ul_block_" + i + "_row_" + row + "' block='" + i + "' row='" + row + "'></ul>").appendTo(table_row[row]);
            }
        }



        for(row=1; row<=4;row++) {
            if (row % 2 == 1) {
                var column_count = seat_plan_settings.SeatPlanBlocks[i].total_col;
            }
            else {
                var column_count = seat_plan_settings.SeatPlanBlocks[i].total_row;
            }

            if (!column_count) {
                continue;
            }

            create_rectangular_table_row_html(i,row,table_row_ul[row],column_count)
        }



    }




    setTimeout(function(){

        if (i >= seat_plan_settings.block_per_row && i % seat_plan_settings.block_per_row == 0 && i != seat_plan_settings.total_block) {
            if(!block_row){
                block_row = 1;
            }
            ++block_row;
            seat_plan_html_container_tml = $("<div class='seat-plan-circle' id='block_row_"+block_row+"'></div>");
            seat_plan_html_container.after(seat_plan_html_container_tml);
            seat_plan_html_container = seat_plan_html_container_tml;
        }

        create_rectangular_table_block_html(i+1,block_row);
    },timeout_diff)

}
function create_rectangular_table_row_html(i,row,table_row_ul,column_count){
    if(row <= 4){
        setTimeout(function(){
            create_rectangular_table_col_html(i,row,1,table_row_ul,column_count);
        },timeout_diff);
    }
}
function create_rectangular_table_col_html(i,row,col,table_row_ul,column_count){
    if(column_count >= col) {
        if (seat_plan_settings.block[i]['seat_plan'][row][col]) {
            var li = "<li class='seat-plan-contextMenu block_" + i + " row_" + row + " col_" + col + " on-hover'  id='seat_" + i + "_" + row + "_" + col + "' data-toggle='tooltip' title='" + seat_plan_settings.block[i].seat_plan[row][col].seat_no + " (" + seat_plan_settings.block[i].block_name + "_" + row + "_" + col + ")" + "' ";

            li = li + " block='" + i + "' row='" + row + "' col='" + col + "' seat_no='" + seat_plan_settings.block[i]['seat_plan'][row][col]['seat_no'] + "' ";

            if (seat_plan_settings.block[i].seat_plan[row][col]['deleted']) {
                li = li + " deleted='1' ";
            }


            if (seat_plan_settings.block[i] && seat_plan_settings.block[i]['seat_plan'] && seat_plan_settings.block[i]['seat_plan'][row] && seat_plan_settings.block[i]['seat_plan'][row][col]) {


            }
            else {
                if (!seat_plan_settings.block[i].block_name) {
                    seat_plan_settings.block[i].block_name = alphaIndex(i);
                }
                if (!seat_plan_settings.block[i].seat_plan) {
                    seat_plan_settings.block[i].seat_plan = new Array();
                }
                if (!seat_plan_settings.block[i].seat_plan[row]) {
                    seat_plan_settings.block[i].seat_plan[row] = new Array();
                }
                if (!seat_plan_settings.block[i].seat_plan[row][col]) {
                    seat_plan_settings.block[i].seat_plan[row][col] = {};
                }
                seat_plan_settings.block[i].seat_plan[row][col]['seat_no'] = row + "_" + col;
                seat_plan_settings.block[i].seat_plan[row][col]['booked'] = 0;
                seat_plan_settings.block[i].seat_plan[row][col]['delete'] = 0;
                seat_plan_settings.block[i].seat_plan[row][col]['disabled'] = 0;
                seat_plan_settings.block[i].seat_plan[row][col]['lavel_id'] = 0;
            }


            // li.attr('id',"seat_"+i+"_"+row+"_"+col)
            //     .attr("data-toggle","tooltip")
            //     .attr("title",seat_plan_settings.block[i].seat_plan[row][col].seat_no+" ("+seat_plan_settings.block[i].block_name+"_"+row+"_"+col+")");
//                    var hinput = $("<input name='"+seat_plan_settings.block_name+"_"+seat_plan_settings.block[i].seat_plan[row][col]['seat_no']+"' type='hidden' />");
//                    hinput.val(JSON.stringify(seat_plan[row][col])).appendTo(li);
            li = li + ">" + getColorImage(seat_plan_settings.block[i].seat_plan[row][col]['lavel_id'], i, row, col) + "</li>";
            li = $(li);
            table_row_ul.append(li);
            // li.tooltip();
        }
        setTimeout(function(){
            create_rectangular_table_col_html(i,row,col+1,table_row_ul,column_count)
        },timeout_diff)
    }
    else{
        if(i>=seat_plan_settings.total_block){
            // $('[data-toggle="tooltip"]').tooltip();
            showSeatCounter();
        }
    }
}



var min_radius = 80;
var seat_per_table = 10;
var seat_width = 30;
var seat_height = 30;
var gap_between_seat = 10;
var gap_between_table_and_seat = 30;
var time_diff = 30;

function create_circular_table_seat_plan_html(i){
    var step_counter = getStepCounter();
    if(step_counter != 4){
        return ;
    }

    if(!seat_plan_settings.total_block || seat_plan_settings.total_block<=0 || !seat_plan_settings.SeatPlanBlocks || isEmpty(seat_plan_settings.SeatPlanBlocks)){
        return;
    }

    $("#seat-plan-html > .seat-plan-circle").remove();
    seat_plan_html_container = $("<div class='seat-plan-circle' id='block_row_1'></div>");
    $("#seat-plan-html").prepend(seat_plan_html_container);

    if (!seat_plan_settings.block_per_row || seat_plan_settings.block_per_row <= 0) {
        seat_plan_settings.block_per_row = seat_plan_settings.total_block;
    }

    if(!i){
        i = 1;
    }
    create_circular_table_block_html(i)

}
function create_circular_table_block_html(i, block_row,target){
    if(i>seat_plan_settings.total_block){
        return;
    }

    if(seat_plan_settings.block[i]) {

        if(target){
            var inner_body_seat = target;
            inner_body_seat.html("");
        }
        else{
            var inner_body_seat = $("<div class='inner-body-seat' id='inner-body-seat-" + i + "'></div>");
            seat_plan_html_container.append(inner_body_seat);
        }

        var table_box = $("<div class='table-box circular_table_container' id='table_box_block_" + i + "'  block='"+i+"' ></div>")
            // .html("<h3 class='block-name' style='text-align: left'>" + seat_plan_settings.block[i].block_name + "</h3>")
            .appendTo(inner_body_seat);


        // max_seat_each_block = seat_plan_settings.SeatPlanBlocks[i].total_seat;

        max_seat_each_block = seat_plan_settings.count.block[i]['total_seat'];
        // console.log(max_seat_each_block);

        var row = 1;
        setTimeout(function(){
            create_circular_table_row_html(i,row,table_box,max_seat_each_block,seat_width,seat_height,gap_between_seat,gap_between_table_and_seat,min_radius);
        },timeout_diff)
    }



    if(!target) {
        setTimeout(function () {
            if (i >= seat_plan_settings.block_per_row && i % seat_plan_settings.block_per_row == 0 && i != seat_plan_settings.total_block) {
                if (!block_row) {
                    block_row = 1;
                }
                block_row++;
                seat_plan_html_container_tml = $("<div class='seat-plan-circle' id='block_row_" + block_row + "'></div>");
                seat_plan_html_container.after(seat_plan_html_container_tml);
                seat_plan_html_container = seat_plan_html_container_tml;
            }
            create_circular_table_block_html(i + 1, block_row);
        }, timeout_diff)
    }

}
function create_circular_table_row_html(i,row,this_container,seat_per_table,seat_width,seat_height,gap_between_seat,gap_between_table_and_seat,radius){

    if(row <= seat_plan_settings.SeatPlanBlocks[i].total_row){
        if (seat_plan_settings.block[i]['seat_plan'][row]) {
            if(row==1){
                var center = $("<div class='circular_table_center'  block='" + i + "' row='" + row + "'></div>").appendTo(this_container);
                // var crosshair_x = $("<div class='circular_table_crosshair-x'></div>").appendTo(this_container);
                // var crosshair_y = $("<div class='circular_table_crosshair-y'></div>").appendTo(this_container);
            }


            var table_row_ul = $("<ul class='seat-list table_row_ul' id='table_row_ul_block_" + i + "_row_" + row + "' block='" + i + "' row='" + row + "'></ul>").appendTo(this_container);



            var circle = seat_per_table * (seat_width + gap_between_seat);
            // console.log(circle);
            if(circle < 200){

            }
            var radius1 = (circle/Math.PI)/2;
            if(!radius || radius < radius1){
                radius = radius1;
            }



            // if(radius<150 && i%2==0){
            //     radius = 80;
            // }
            // if(i%2==0){
            //     radius = 80;
            // }
            // console.log(radius);

            var width = radius*2, height = radius*2;
            var angle = 0;
            var angle = 4.75;

            if(seat_per_table > 0){
                var step = (2*Math.PI) / seat_per_table;
                var rotate_deg = (360/seat_per_table);

                console.log("rotate_deg",rotate_deg);

                var col = 1;
                setTimeout(function () {
                    // addSeatInCircle(seat_per_table,col,table_row_ul,width,height,radius,angle,rotate_deg,angle,step);
                    create_circular_table_col_html(i,row,col,table_row_ul,seat_per_table,width,height,radius,angle,rotate_deg,angle,step,seat_width,seat_height)
                }, time_diff);
            }




            this_container.css({width:(radius*2)+"px",height:(radius*2)+"px"});
            table_row_ul.css({width:(radius*2)+"px",height:(radius*2)+"px"});
            if(row==1) {
                // crosshair_x.animate({width: width + "px", top: (height / 2) + "px"}, 500);
                // crosshair_y.animate({height: height + "px", left: (width / 2) + "px"}, 500);
                center.css({
                    width: (width - gap_between_table_and_seat) + "px",
                    height: (height - 30) + "px",
                    'line-height': (height - gap_between_table_and_seat) + "px"
                });
                center.css({
                    top: (gap_between_table_and_seat / 2) + "px",
                    left: (gap_between_table_and_seat / 2) + "px"
                }).html(seat_plan_settings.block[i]['block_name']);
            }
        }

        setTimeout(function(){
            create_circular_table_row_html(i,row+1,this_container,seat_per_table,seat_width,gap_between_seat,gap_between_table_and_seat,radius);
        },timeout_diff);
    }
}

function create_circular_table_col_html(i,row,col,table_row_ul,seat_per_table,width,height,radius,angle,rotate_deg,angle,step,seat_width,seat_height,seatcount){
    if(col <= seat_plan_settings.SeatPlanBlocks[i].total_col && seat_per_table > 0) {
        if (seat_plan_settings.block[i]['seat_plan'][row][col] && !seat_plan_settings.block[i]['seat_plan'][row][col]['deleted']) {
            var li = "<li class='circular_table_field seat-plan-contextMenu block_" + i + " row_" + row + " col_" + col + " on-hover'  id='seat_" + i + "_" + row + "_" + col + "' data-toggle='tooltip' title='" + seat_plan_settings.block[i].seat_plan[row][col].seat_no + " (" + seat_plan_settings.block[i].block_name + "_" + row + "_" + col + ")" + "' ";

            li = li + " block='" + i + "' row='" + row + "' col='" + col + "' seat_no='" + seat_plan_settings.block[i]['seat_plan'][row][col]['seat_no'] + "'";

            if (seat_plan_settings.block[i].seat_plan[row][col]['deleted']) {
                li = li + " deleted='1' ";
            }


            if (seat_plan_settings.block[i] && seat_plan_settings.block[i]['seat_plan'] && seat_plan_settings.block[i]['seat_plan'][row] && seat_plan_settings.block[i]['seat_plan'][row][col]) {


            }
            else {
                if (!seat_plan_settings.block[i].block_name) {
                    seat_plan_settings.block[i].block_name = alphaIndex(i);
                }
                if (!seat_plan_settings.block[i].seat_plan) {
                    seat_plan_settings.block[i].seat_plan = new Array();
                }
                if (!seat_plan_settings.block[i].seat_plan[row]) {
                    seat_plan_settings.block[i].seat_plan[row] = new Array();
                }
                if (!seat_plan_settings.block[i].seat_plan[row][col]) {
                    seat_plan_settings.block[i].seat_plan[row][col] = {};
                }
                seat_plan_settings.block[i].seat_plan[row][col]['seat_no'] = row + "_" + col;
                seat_plan_settings.block[i].seat_plan[row][col]['booked'] = 0;
                seat_plan_settings.block[i].seat_plan[row][col]['delete'] = 0;
                seat_plan_settings.block[i].seat_plan[row][col]['disabled'] = 0;
                seat_plan_settings.block[i].seat_plan[row][col]['lavel_id'] = 0;
            }

            li = li + ">" + getColorImage(seat_plan_settings.block[i].seat_plan[row][col]['lavel_id'], i, row, col) + "</li>";
            // var li = "<div class='circular_table_field'><img src='http://organization.gradpak.com/css/admin_styles/images/seat.png' /></div>";

            var x = Math.round(width / 2 + radius * Math.cos(angle) - seat_width / 2);
            var y = Math.round(height / 2 + radius * Math.sin(angle) - seat_height / 2);

            if(!seatcount){
                seatcount = 0
            }

            $(li).css({
                left: x + 'px',
                top: y + 'px',
                transform: "rotate(+" + (rotate_deg * seatcount) + "deg)"
            }).appendTo(table_row_ul);

            angle += step;

            seatcount++;


            // table_row_ul.append(li);
            // li = $(li).tooltip();
        }

        setTimeout(function(){
            if (seat_plan_settings.block[i]['seat_plan'][row][col] && seat_plan_settings.block[i]['seat_plan'][row][col]['deleted']){
                ++seat_per_table;
            }
            create_circular_table_col_html(i,row,col+1,table_row_ul,--seat_per_table,width,height,radius,angle,rotate_deg,angle,step,seat_width,seat_height,seatcount)
        },timeout_diff)
    }
    else{
        if(i>=seat_plan_settings.total_block){
            // $('[data-toggle="tooltip"]').tooltip();
            showSeatCounter();
        }
    }
}

function addSeatInCircle(seat_per_table,ij,this_container,width,height,radius,angle,rotate_deg,angle,step){
    if(seat_per_table>=ij) {
        //$('.container').append("<div class='field'>"+ij+"</div>");
//            var seat = $("<div class='field'>" + ij + "</div>");
        var seat = $("<div class='circular_table_field'><img src='http://organization.gradpak.com/css/admin_styles/images/seat.png' /></div>");


        var x = Math.round(width / 2 + radius * Math.cos(angle) - $(seat).width() / 2);
        var y = Math.round(height / 2 + radius * Math.sin(angle) - $(seat).height() / 2);

        seat.css({
            left: x + 'px',
            top: y + 'px',
            transform: "rotate(+" + (rotate_deg * (ij - 1)) + "deg)"
        }).appendTo(this_container);

        angle += step;

        setTimeout(function () {
            addSeatInCircle(seat_per_table, ij + 1, this_container, width, height, radius, angle, rotate_deg, angle, step)
        }, time_diff);
    }
}

function getColorImage(lavelId,block,row,col){
    var color = notSelectedColor;

    if(event_levels[lavelId] && !isEmpty(event_levels[lavelId]['level_color'])){
        var color = event_levels[lavelId]['level_color'];
    }

    var style = "background:"+color;
    if(!isEmpty(seat_plan_settings.block[block].seat_plan[row][col].booked) ){
        style = style + ";opacity:0.35";
    }
    else if(seat_plan_settings.block[block].seat_plan[row][col].disabled){
        style = style + ";opacity:0.2";
    }

    var img_src = "/css/admin_styles/images/seat.png";
    if(seat_plan_type=="Rectangular"){

    }
    else if(seat_plan_type=="RectangularTable"){
        img_src = "/css/admin_styles/images/seat"+row+".png";
    }

    var img = "<img src='"+img_src+"' style='"+style+"' />";

    if(seat_plan_settings.block[block].seat_plan[row][col].deleted){
        img = "";
    }
    return img;
}


function total_available_seat(block,row,col,old_lavel_id,val){
    if(!seat_plan_settings.count['lavel'][old_lavel_id]){
        seat_plan_settings.count['lavel'][old_lavel_id] = {
            'total_seat' : 0,
            'total_valid' : 0,
            'total_available' : 0,
            'total_disabled' : 0,
            'total_delete' : 0
        };
    }

    seat_plan_settings.count.block[block]['total_available'] = seat_plan_settings.count.block[block]['total_available'] + val;
    seat_plan_settings.count.block[block]['total_seat'] = seat_plan_settings.count.block[block]['total_seat'] + val;
    seat_plan_settings.count.block[block]['total_valid'] = seat_plan_settings.count.block[block]['total_valid'] + val;
    seat_plan_settings.count.block[block]['total_delete'] = seat_plan_settings.count.block[block]['total_delete'] - val;



    seat_plan_settings.count['total_available'] = seat_plan_settings.count['total_available'] + val;
    seat_plan_settings.count['total_seat'] = seat_plan_settings.count['total_seat'] + val;
    seat_plan_settings.count['total_valid'] = seat_plan_settings.count['total_valid'] + val;
    seat_plan_settings.count['total_delete'] = seat_plan_settings.count['total_delete'] - val;


    if(seat_plan_settings.block[block].seat_plan[row][col].disabled || !event_levels[old_lavel_id]){
        seat_plan_settings.count['total_disabled'] = seat_plan_settings.count['total_disabled'] + val;
        seat_plan_settings.count['lavel'][old_lavel_id]['total_disabled'] = seat_plan_settings.count['lavel'][old_lavel_id]['total_disabled'] + val;
        seat_plan_settings.count['block'][block]['total_disabled'] = seat_plan_settings.count['block'][block]['total_disabled'] + val;
    }

    if (seat_count.lavels[old_lavel_id] && val<=0) {
        seat_count.lavels[old_lavel_id] = seat_count.lavels[old_lavel_id] + val;
        seat_plan_settings.count['lavel'][old_lavel_id]['total_seat'] = seat_plan_settings.count['lavel'][old_lavel_id]['total_seat'] + val;
        seat_plan_settings.count['lavel'][old_lavel_id]['total_available'] = seat_plan_settings.count['lavel'][old_lavel_id]['total_seat'] + val;
        seat_plan_settings.count['lavel'][old_lavel_id]['total_valid'] = seat_count.lavels[old_lavel_id] + val;
    }

}

function initSeatPlanContextMenu() {
    var step_counter = getStepCounter();
    if (step_counter != 4) {
        return;
    }


    var items = getContextMenuItems();


    $.contextMenu('destroy', '.seat-plan-contextMenu');
    $.contextMenu({
        selector: '.seat-plan-contextMenu',
        autoHide: true,
        callback: function (action, options) {
            var m = "clicked: " + action;


            var _that = this;

            var invalid = false;
            var block = _that.attr('block');
            var row = _that.attr('row');
            var col = _that.attr('col');

            if((action=="addNew" || action=="delete") && !col){
                col = 0;
                if(block && row && seat_plan_settings.block && seat_plan_settings.block[block] && seat_plan_settings.block[block].seat_plan[row]) {
                    if (action == "addNew") {
                        for(var aa in seat_plan_settings.block[block].seat_plan[row]){
                            if(seat_plan_settings.block[block].seat_plan[row][aa]['deleted'] && !seat_plan_settings.block[block].seat_plan[row][aa].booked){
                                if(!col){
                                    col = aa;
                                    break;
                                }
                            }
                        }
                    }
                    else if (action == "delete") {
                        for(var aa in seat_plan_settings.block[block].seat_plan[row]){
                            if(!seat_plan_settings.block[block].seat_plan[row][aa]['deleted'] && !seat_plan_settings.block[block].seat_plan[row][aa].booked){
                                col = aa;
                            }
                        }
                    }

                    if(!col){
                        return false;
                    }
                }
                else{
                    return false;
                }
            }

            if (!block || !row || !col || !seat_plan_settings.block || !seat_plan_settings.block[block] || !seat_plan_settings.block[block].seat_plan[row] || !seat_plan_settings.block[block].seat_plan[row][col]) {
                invalid = false;
                _that.removeClass('seat-plan-contextMenu');
                return;
            }

            if (seat_plan_settings.block[block].seat_plan[row][col].booked) {
                _that.removeClass('seat-plan-contextMenu');
                action = action + " not allowed";
                return;
            }

            var ba = action.indexOf("block_add_to_");
            var ra = action.indexOf("row_add_to_");
            var ca = action.indexOf("col_add_to_");
            var bc = action.indexOf("clear_block_");
            var rc = action.indexOf("clear_row_");
            var cc = action.indexOf("clear_col_");

            var rd = action.indexOf("delete_row_");
            var cd = action.indexOf("delete_col_");

            var a = action.indexOf("add_to_");

            if (seat_plan_type == "Rectangular") {

            }
            else if (seat_plan_type == "RectangularTable") {

            }
            else if (seat_plan_type == "CircularTable") {

            }


            var lavelId = seat_plan_settings.block[block].seat_plan[row][col].lavel_id;
            if (ba === 0 || bc === 0) {
                var lavelId = parseInt(action.replace("block_add_to_", ""));
                if (bc === 0) {
                    lavelId = 0;
                }
                if (!isNaN(lavelId)) {
                    if (seat_plan_type == "Rectangular" || seat_plan_type == "CircularTable") {
                        for (jj = 1; jj <= seat_plan_settings.SeatPlanBlocks[block].total_row; jj++) {
                            for (ii = 1; ii <= seat_plan_settings.SeatPlanBlocks[block].total_col; ii++) {
                                if (seat_plan_settings.block[block].seat_plan[jj][ii] && !seat_plan_settings.block[block].seat_plan[jj][ii].booked) {
                                    // seat_plan_settings.block[block].seat_plan[jj][ii].lavel_id = lavelId;
                                    // $("#seat_" + block + "_" + jj + "_" + ii).html(getColorImage(lavelId, block, jj, ii));
                                    addLevelId(lavelId, block, jj, ii);
                                }
                            }
                        }
                    }
                    else if (seat_plan_type == "RectangularTable") {
                        for (jj = 1; jj <= 4; jj++) {
                            // For horizontal seat
                            for (ii = 1; ii <= seat_plan_settings.SeatPlanBlocks[block].total_col; ii++) {
                                if (seat_plan_settings.block[block].seat_plan[jj][ii] && !seat_plan_settings.block[block].seat_plan[jj][ii].booked) {
                                    // seat_plan_settings.block[block].seat_plan[jj][ii].lavel_id = lavelId;
                                    // $("#seat_" + block + "_" + jj + "_" + ii).html(getColorImage(lavelId, block, jj, ii));
                                    addLevelId(lavelId, block, jj, ii);
                                }
                            }

                            // For vertical seat
                            for (ii = 1; ii <= seat_plan_settings.SeatPlanBlocks[block].total_row; ii++) {
                                if (seat_plan_settings.block[block].seat_plan[jj][ii] && !seat_plan_settings.block[block].seat_plan[jj][ii].booked) {
                                    // seat_plan_settings.block[block].seat_plan[jj][ii].lavel_id = lavelId;
                                    // $("#seat_" + block + "_" + jj + "_" + ii).html(getColorImage(lavelId, block, jj, ii));
                                    addLevelId(lavelId, block, jj, ii);
                                }
                            }
                        }
                    }
                }
            }
            else if (ra === 0 || rc === 0 || rd === 0) {
                var lavelId = parseInt(action.replace("row_add_to_", ""));
                if (rc === 0 || rd === 0) {
                    lavelId = 0;
                }
                if (!isNaN(lavelId)) {
                    if (seat_plan_type == "Rectangular") {
                        for (ii = 1; ii <= seat_plan_settings.SeatPlanBlocks[block].total_col; ii++) {
                            if (seat_plan_settings.block[block].seat_plan[row][ii] && !seat_plan_settings.block[block].seat_plan[row][ii].booked) {
                                // seat_plan_settings.block[block].seat_plan[row][ii].lavel_id = lavelId;
                                // $("#seat_"+block+"_"+row+"_"+ii).html( getColorImage(lavelId,block,row,ii) );

                                if (rd === 0) {
                                    seat_plan_settings.block[block].seat_plan[row][ii].deleted =1
                                    var old_lavel_id = seat_plan_settings.block[block].seat_plan[row][ii].lavel_id;
                                    total_available_seat(block,row,ii,old_lavel_id,-1);
                                }

                                addLevelId(lavelId, block, row, ii);
                            }
                        }
                    }
                    else if (seat_plan_type == "RectangularTable") {
                        if (row % 2 == 1) {
                            var RectangularTable_seat_count = seat_plan_settings.SeatPlanBlocks[block].total_col;
                        }
                        else {
                            var RectangularTable_seat_count = seat_plan_settings.SeatPlanBlocks[block].total_row;
                        }

                        jj = row;
                        for (ii = 1; ii <= RectangularTable_seat_count; ii++) {
                            if (seat_plan_settings.block[block].seat_plan[jj][ii] && !seat_plan_settings.block[block].seat_plan[jj][ii].booked) {
                                // seat_plan_settings.block[block].seat_plan[jj][ii].lavel_id = lavelId;
                                // $("#seat_" + block + "_" + jj + "_" + ii).html(getColorImage(lavelId, block, jj, ii));
                                addLevelId(lavelId, block, jj, ii);
                            }
                        }

                    }

                }
            }
            else if (ca === 0 || cc === 0 || cd === 0) {
                var lavelId = parseInt(action.replace("col_add_to_", ""));
                if (cc === 0 || cd === 0) {
                    lavelId = 0;
                }
                if (!isNaN(lavelId)) {
                    if (seat_plan_type == "Rectangular") {
                        for (ii = 1; ii <= seat_plan_settings.SeatPlanBlocks[block].total_row; ii++) {
                            if (seat_plan_settings.block[block].seat_plan[ii][col] && !seat_plan_settings.block[block].seat_plan[ii][col].booked) {
                                // seat_plan_settings.block[block].seat_plan[ii][col].lavel_id = lavelId;
                                // $("#seat_" + block + "_" + ii + "_" + col).html(getColorImage(lavelId, block, ii, col));

                                if (cd === 0) {
                                    seat_plan_settings.block[block].seat_plan[ii][col].deleted =1;
                                    var old_lavel_id = seat_plan_settings.block[block].seat_plan[ii][col].lavel_id;
                                    total_available_seat(block,ii,col,old_lavel_id,-1);
                                }
                                addLevelId(lavelId, block, ii, col);
                            }
                        }
                    }
                    else if (seat_plan_type == "RectangularTable") {
                        for (ii = 1; ii <= 4; ii++) {
                            if (ii % 2 == row % 2) {
                                if (seat_plan_settings.block[block].seat_plan[ii][col] && !seat_plan_settings.block[block].seat_plan[ii][col].booked) {
                                    // seat_plan_settings.block[block].seat_plan[ii][col].lavel_id = lavelId;
                                    // $("#seat_" + block + "_" + ii + "_" + col).html(getColorImage(lavelId, block, ii, col));
                                    addLevelId(lavelId, block, ii, col);
                                }
                            }

                        }
                    }
                }
            }
            else if (a === 0) {
                var lavelId = parseInt(action.replace("add_to_", ""));
                if (!isNaN(lavelId)) {
                    // seat_plan_settings.block[block].seat_plan[row][col].lavel_id = lavelId;
                    // _that.html( getColorImage(lavelId,block,row,col) );
                    addLevelId(lavelId, block, row, col);
                }
            }
            else if (action === "clear") {
                // seat_plan_settings.block[block].seat_plan[row][col].lavel_id = 0;
                // _that.html( getColorImage(seat_plan_settings.block[block].seat_plan[row][col].lavel_id,block,row,col) );
                addLevelId(0, block, row, col);
            }
            // else if(action=="disable"){
            //     if (seat_plan_settings.block[block].seat_plan[row][col] && !seat_plan_settings.block[block].seat_plan[row][col].booked) {
            //         _that.attr('disable', "1");
            //         seat_plan_settings.block[block].seat_plan[row][col].disabled = 1;
            //         _that.html(getColorImage(seat_plan_settings.block[block].seat_plan[row][col].lavel_id, block, row, col));
            //     }
            // }
            // else if(action=="enable"){
            //     _that.removeAttr('disable');
            //     seat_plan_settings.block[block].seat_plan[row][col].disabled = 0;
            //     _that.html( getColorImage(seat_plan_settings.block[block].seat_plan[row][col].lavel_id,block,row,col) );
            // }
            else if(action=="addNew"){
                seat_plan_settings.block[block].seat_plan[row][col].deleted = 0;
                var old_lavel_id = seat_plan_settings.block[block].seat_plan[row][col].lavel_id;
                total_available_seat(block,row,col,old_lavel_id,1);
                addLevelId(0, block, row, col);
                var target = $("#inner-body-seat-" + block);
                if (seat_plan_type == "Rectangular") {
                    // create_rectangular_block_html(block, false,target);
                }
                else if (seat_plan_type == "RectangularTable") {
                    create_rectangular_table_block_html(block, false,target);
                }
                else if (seat_plan_type == "CircularTable") {
                    create_circular_table_block_html(block, false,target)   ;
                }
            }
            else if((action=="delete" && !seat_plan_settings.block[block].seat_plan[row][col].booked)){
                seat_plan_settings.block[block].seat_plan[row][col].deleted = 1;
                var old_lavel_id = seat_plan_settings.block[block].seat_plan[row][col].lavel_id;
                total_available_seat(block,row,col,old_lavel_id,-1);
                addLevelId(0, block, row, col);
                var target = $("#inner-body-seat-" + block);
                if (seat_plan_type == "Rectangular") {
                    // create_rectangular_block_html(block, false,target);
                }
                else if (seat_plan_type == "RectangularTable") {
                    create_rectangular_table_block_html(block, false,target);
                }
                else if (seat_plan_type == "CircularTable") {
                    create_circular_table_block_html(block, false,target)   ;
                }
            }

            showSeatCounter();


        },
        items: items
    });


    for (i in items) {
        if (i != "block") {
            delete items[i];
        }
    }

    if (items["block"]['items']) {
        items = $.extend({}, items["block"]['items']);
        items.sep40 = {"type": "cm_separator", visible: visible};
        items.addNew = {name: "Add a new seat", icon: false,visible:visible};
        items.delete = {name: "Delete 1 seat", icon: false,visible:visible};
        items.sep4 = {"type": "cm_separator"};
        items.quit = {
            name: "Quit", icon: function () {
                return 'context-menu-icon context-menu-icon-quit';
            }
        };

        $.contextMenu('destroy', '.table-box');
        $.contextMenu('destroy', '.table_row_ul');
        $.contextMenu('destroy', '.circular_table_center');
        $.contextMenu({
            selector: '.table-box',
            autoHide: true,
            callback: function(action, options){ return contextMenuCallback(this,action, options)},
            items: items
        });
        $.contextMenu({
            selector: '.table_row_ul',
            autoHide: true,
            callback: function(action, options){ return contextMenuCallback(this,action, options)},
            items: items
        });
        $.contextMenu({
            selector: '.circular_table_center',
            autoHide: true,
            callback: function(action, options){ return contextMenuCallback(this,action, options)},
            items: items
        });
    }

    var  contextMenuCallback = function (_that, action, options) {
        var m = "clicked: " + action;


        var invalid = false;
        var block = _that.attr('block');
        var row = _that.attr('row');
        var col = 0;

        if(action=="addNew" || action=="delete"){
            if(block && row && seat_plan_settings.block && seat_plan_settings.block[block] && seat_plan_settings.block[block].seat_plan[row]) {
                if (action == "addNew") {
                    for(var aa in seat_plan_settings.block[block].seat_plan[row]){
                        if(seat_plan_settings.block[block].seat_plan[row][aa]['deleted'] && !seat_plan_settings.block[block].seat_plan[row][aa].booked){
                            if(!col){
                                col = aa;
                                break;
                            }
                        }
                    }
                }
                else if (action == "delete") {
                    for(var aa in seat_plan_settings.block[block].seat_plan[row]){
                        if(!seat_plan_settings.block[block].seat_plan[row][aa]['deleted'] && !seat_plan_settings.block[block].seat_plan[row][aa].booked){

                            col = aa;
                        }
                    }
                }

                if(!col){
                    return false;
                }
            }
            else{
                return false;
            }
        }

        if (!block || !seat_plan_settings.block || !seat_plan_settings.block[block]) {
            return;
        }

        var ba = action.indexOf("block_add_to_");
        var bc = action.indexOf("clear_block_");


        if (ba === 0 || bc === 0) {
            var lavelId = parseInt(action.replace("block_add_to_", ""));
            if (bc === 0) {
                lavelId = 0;
            }
            if (!isNaN(lavelId)) {
                if (seat_plan_type == "Rectangular" || seat_plan_type == "CircularTable") {
                    for (jj = 1; jj <= seat_plan_settings.SeatPlanBlocks[block].total_row; jj++) {
                        for (ii = 1; ii <= seat_plan_settings.SeatPlanBlocks[block].total_col; ii++) {
                            if (seat_plan_settings.block[block].seat_plan[jj][ii] && !seat_plan_settings.block[block].seat_plan[jj][ii].booked) {
                                // seat_plan_settings.block[block].seat_plan[jj][ii].lavel_id = lavelId;
                                // $("#seat_" + block + "_" + jj + "_" + ii).html(getColorImage(lavelId, block, jj, ii));
                                addLevelId(lavelId, block, jj, ii);
                            }
                        }
                    }
                }
                else if (seat_plan_type == "RectangularTable") {
                    for (jj = 1; jj <= 4; jj++) {
                        // For horizontal seat
                        for (ii = 1; ii <= seat_plan_settings.SeatPlanBlocks[block].total_col; ii++) {
                            if (seat_plan_settings.block[block].seat_plan[jj][ii] && !seat_plan_settings.block[block].seat_plan[jj][ii].booked) {
                                // seat_plan_settings.block[block].seat_plan[jj][ii].lavel_id = lavelId;
                                // $("#seat_" + block + "_" + jj + "_" + ii).html(getColorImage(lavelId, block, jj, ii));
                                addLevelId(lavelId, block, jj, ii);
                            }
                        }

                        // For vertical seat
                        for (ii = 1; ii <= seat_plan_settings.SeatPlanBlocks[block].total_row; ii++) {
                            if (seat_plan_settings.block[block].seat_plan[jj][ii] && !seat_plan_settings.block[block].seat_plan[jj][ii].booked) {
                                // seat_plan_settings.block[block].seat_plan[jj][ii].lavel_id = lavelId;
                                // $("#seat_" + block + "_" + jj + "_" + ii).html(getColorImage(lavelId, block, jj, ii));
                                addLevelId(lavelId, block, jj, ii);
                            }
                        }
                    }
                }
            }
        }
        else if(action=="addNew"){
            seat_plan_settings.block[block].seat_plan[row][col].deleted = 0;
            var old_lavel_id = seat_plan_settings.block[block].seat_plan[row][col].lavel_id;
            total_available_seat(block,row,col,old_lavel_id,1);
            addLevelId(0, block, row, col);
            var target = $("#inner-body-seat-" + block);
            if (seat_plan_type == "Rectangular") {
                // create_rectangular_block_html(block, false,target);
            }
            else if (seat_plan_type == "RectangularTable") {
                create_rectangular_table_block_html(block, false,target);
            }
            else if (seat_plan_type == "CircularTable") {
                create_circular_table_block_html(block, false,target)   ;
            }
        }
        else if((action=="delete" && !seat_plan_settings.block[block].seat_plan[row][col].booked)){
            seat_plan_settings.block[block].seat_plan[row][col].deleted = 1;
            var old_lavel_id = seat_plan_settings.block[block].seat_plan[row][col].lavel_id;
            total_available_seat(block,row,col,old_lavel_id,-1);
            addLevelId(0, block, row, col);
            var target = $("#inner-body-seat-" + block);
            if (seat_plan_type == "Rectangular") {
                // create_rectangular_block_html(block, false,target);
            }
            else if (seat_plan_type == "RectangularTable") {
                create_rectangular_table_block_html(block, false,target);
            }
            else if (seat_plan_type == "CircularTable") {
                create_circular_table_block_html(block, false,target)   ;
            }
        }

        showSeatCounter();

    }


    function getContextMenuItems(){
        var items = {};

        if (!isEmpty(event_levels)) {
            for (lavelId in event_levels) {

                if ($.trim(event_levels[lavelId].level_name) == "") {
                    event_levels[lavelId].level_name = "Lavel ID " + event_levels[lavelId].id
                }
                items["add_to_" + event_levels[lavelId].id] = {
                    name: "Add this seat to level " + event_levels[lavelId].level_name,
                    icon: false,
                    disabled: false,
                    visible: visible
                };

            }
            items.sep1 = {"type": "cm_separator", icon: false, disabled: false, visible: visible};
            items["clear"] = {name: "Disable this seat", icon: false, disabled: false, visible: visible};
            items.sep2 = {"type": "cm_separator", icon: false, disabled: false, visible: visible};


            items["block"] = {name: "Block", items: {}};
            if (seat_plan_type == "RectangularTable" || seat_plan_type == "CircularTable") {
                items["block"] = {name: "Table", items: {}};
            }

            items["row"] = {name: "Row", items: {}};
            items["col"] = {name: "Column ", items: {}};
            for (lavelId in event_levels) {
                items["block"].items["block_add_to_" + event_levels[lavelId].id] = {name: "Add to level " + event_levels[lavelId].level_name};
                items["row"].items["row_add_to_" + event_levels[lavelId].id] = {name: "Add to level " + event_levels[lavelId].level_name};
                items["col"].items["col_add_to_" + event_levels[lavelId].id] = {name: "Add to level " + event_levels[lavelId].level_name};
            }


            items["block"].sep1 = {"type": "cm_separator", icon: false};
            items["row"].sep1 = "---------";
            items["col"].sep1 = "---------";
            items["block"].items["clear_block_" + event_levels[lavelId].id] = {name: "Disable"};
            items["row"].items["clear_row_" + event_levels[lavelId].id] = {name: "Disable"};
            items["col"].items["clear_col_" + event_levels[lavelId].id] = {name: "Disable"};

            if (seat_plan_type == "Rectangular"){
                items["row"].items["delete_row_" + event_levels[lavelId].id] = {name: "Delete"};
                items["col"].items["delete_col_" + event_levels[lavelId].id] = {name: "Delete"};
            }

            items.sep3 = {"type": "cm_separator", icon: false, disabled: false, visible: visible};


            if (seat_plan_type == "CircularTable") {
                delete  items["row"];
                delete  items["col"];
                delete  items["sep3"];
            }

        }


        items.sep40 = {"type": "cm_separator", visible: visible};
        items.addNew = {name: "Add a new seat", icon: false,visible:visible};
        // items.disable = {name: "Disable", icon: false,disabled:disabled,visible:visible};
        // items.enable = {name: "Enable", icon: false,disabled:disabled,visible:visible};
        items.delete = {name: "Delete 1 seat", icon: false,visible:visible};
        items.sep4 = {"type": "cm_separator"};
        items.quit = {
            name: "Quit", icon: function () {
                return 'context-menu-icon context-menu-icon-quit';
            }
        };

        return items;
    }
    function disabled (action, options,_that) {

        if(!_that){
            var _that = this;
        }


        var block = _that.attr('block');
        var row = _that.attr('row');
        var col = _that.attr('col');

        if(action == "enable" && seat_plan_settings.block[block].seat_plan[row][col].disabled == 1){
            return false;
        }
        else if(seat_plan_settings.block[block].seat_plan[row][col].disabled == 1){
            return true;
        }
        else{
            return false;
        }
    }
    function visible (action, options, _that) {


        if(!_that){
            var _that = this;
        }

        var block = _that.attr('block');
        var row = _that.attr('row');
        var col = _that.attr('col');




        if(action=="addNew" || action=="delete" || action=="sep40"){
            col = 0;
            if(block && row && seat_plan_settings.block && seat_plan_settings.block[block] && seat_plan_settings.block[block].seat_plan[row]) {
                if (action == "addNew" || action == "sep40") {
                    for(var aa in seat_plan_settings.block[block].seat_plan[row]){
                        if(seat_plan_settings.block[block].seat_plan[row][aa]['deleted'] && !seat_plan_settings.block[block].seat_plan[row][aa].booked){
                            if(!col){
                                col = aa;
                                break;
                            }
                        }
                    }
                }

                if (action == "delete" || action == "sep40") {
                    for(var aa in seat_plan_settings.block[block].seat_plan[row]){
                        if(!seat_plan_settings.block[block].seat_plan[row][aa]['deleted'] && !seat_plan_settings.block[block].seat_plan[row][aa].booked){
                            col = aa;
                        }
                    }
                }


                if(!col){
                    return false;
                }
                else{
                    return true;
                }
            }
            else{
                return false;
            }
        }



        if(seat_plan_settings.block[block].seat_plan[row][col].booked){
            return false;
        }

        if(action == "addNew" && seat_plan_settings.block[block].seat_plan[row][col].deleted == 1){
            return true;
        }
        else if(seat_plan_settings.block[block].seat_plan[row][col].deleted == 1){
            return false;
        }

        if(action == "enable" && seat_plan_settings.block[block].seat_plan[row][col].disabled == 1){
            return true;
        }
        else if(seat_plan_settings.block[block].seat_plan[row][col].disabled == 1){
            return false;
        }

        if(action == "addNew" || action == "enable"){
            return false;
        }
        return true;

    }
    $('.context-menu-one').on('click', function(e){
//            // console.log('clicked', this);
    })
}

function addLevelId(lavelId,block,row,col){
    if (seat_plan_settings.block[block].seat_plan[row][col] && !seat_plan_settings.block[block].seat_plan[row][col].booked) {

        if(!seat_plan_settings.count['lavel'][lavelId]){
            seat_plan_settings.count['lavel'][lavelId] = {
                'total_seat' : 0,
                'total_valid' : 0,
                'total_available' : 0,
                'total_disabled' : 0,
                'total_delete' : 0
            };
        }


        var old_lavelId = seat_plan_settings.block[block].seat_plan[row][col].lavel_id;
        if(!seat_plan_settings.count['lavel'][old_lavelId]){
            seat_plan_settings.count['lavel'][old_lavelId] = {
                'total_seat' : 0,
                'total_valid' : 0,
                'total_available' : 0,
                'total_disabled' : 0,
                'total_delete' : 0
            };
        }


        if (lavelId == 0) {
            if (seat_count.lavels[old_lavelId]) {
                seat_count.lavels[old_lavelId]--;

                seat_plan_settings.count['lavel'][old_lavelId]['total_seat']--;
                seat_plan_settings.count['lavel'][old_lavelId]['total_available']--;
                seat_plan_settings.count['lavel'][old_lavelId]['total_valid']--;
            }
            seat_plan_settings.block[block].seat_plan[row][col].lavel_id = lavelId;
            $("#seat_" + block + "_" + row + "_" + col).html(getColorImage(lavelId, block, row, col));
        }
        else if (event_levels[lavelId] && (event_levels[lavelId]['total_ticket_per_level'] || seat_plan_settings.is_restrict_total_ticket<=0)) {
            if (!seat_count.lavels) {
                seat_count.lavels = {};
            }

            if (!seat_count.lavels[lavelId]) {
                seat_count.lavels[lavelId] = 0;
            }


            if (seat_count.lavels[lavelId] < event_levels[lavelId]['total_ticket_per_level'] || seat_plan_settings.is_restrict_total_ticket<=0) {
                seat_count.lavels[lavelId]++;
                seat_plan_settings.count['lavel'][lavelId]['total_seat']--;
                seat_plan_settings.count['lavel'][lavelId]['total_available']--;
                seat_plan_settings.count['lavel'][lavelId]['total_valid']--;

                if (seat_count.lavels[old_lavelId]) {
                    seat_count.lavels[old_lavelId]--;
                    seat_plan_settings.count['lavel'][old_lavelId]['total_seat']--;
                    seat_plan_settings.count['lavel'][old_lavelId]['total_available']--;
                    seat_plan_settings.count['lavel'][old_lavelId]['total_valid']--;
                }
                seat_plan_settings.block[block].seat_plan[row][col].lavel_id = lavelId;
                $("#seat_" + block + "_" + row + "_" + col).html(getColorImage(lavelId, block, row, col));
            }

        }
    }

}

function showSeatCounter(){
    str = "";
    seat_count = {};
    seat_count.status = false;
    seat_count.lavels = {};
    seat_count.total_seat = 0;
    seat_count.total_booked = 0;
    seat_count.total_disabled = 0;
    seat_count.total_deleted = 0;
    for(level_id in event_levels){
        seat_count.lavels[level_id] = 0;
    }
    if(seat_plan_settings && seat_plan_settings.block){
        for(block in seat_plan_settings.block){
            var seat_plan = seat_plan_settings.block[block].seat_plan;

            for(row in seat_plan){
                for(col in seat_plan[row]){
                    var seat = seat_plan[row][col];
                    if(!seat.deleted){
                        seat_count.total_seat++;
                        if(seat.disabled==0 && event_levels[seat.lavel_id]){
                            seat_count.lavels[seat.lavel_id]++;
                            if(seat.booked){
                                seat_count.total_booked++;
                            }
                        }
                        else{
                            seat_count.total_disabled++;
                        }
                    }
                    else{
                        seat_count.total_deleted++;
                    }
                }

            }
        }
    }



    str = "<div class='all-cat-seat flex-container'>";
    for(level_id in seat_count.lavels){

        if(str==""){
            str = str+"<p>"+event_levels[level_id].level_name+"-<span> "+seat_count.lavels[level_id]+"</span></p> ";
        }
        else{
            str = str+"<p>"+event_levels[level_id].level_name+"-<span> "+seat_count.lavels[level_id]+"</span>,</p> ";
        }
    }

    str = str+"<p>Unavailable-<span> "+seat_count.total_disabled+"</span></p> ";
    str = str + "</div>"
    str = str+"<div class='total-seat'><p>Total Seat:<span> "+seat_count.total_seat+"</span></p></div>";
    $(".seat-count").html(str);
    seat_count.status = true;
}





// End Seat Plan JS -- Rakib
// ----------------------------------------------------------------------