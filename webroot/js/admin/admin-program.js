$(document).ready(function(){
    $("#number_of_tickets_for_social_program").keyup(function(event){
        var pre_price = $("#total_price_of_tickets_for_social_program").attr("value");
        if(isNaN(pre_price)){
            pre_price=0;
        }

        var orginal_value = $("#number_of_tickets_for_social_program").attr("value");
        if((event.keyCode<48 || (event.keyCode>57&&event.keyCode<96) || event.keyCode>105) && event.keyCode != 8){
            orginal_value=orginal_value.substring(0, orginal_value.length - 1);
            $("#number_of_tickets_for_social_program").attr("value", orginal_value);
        }
        orginal_value = $("#number_of_tickets_for_social_program").attr("value");
        var price_per = $("#price_of_tickets_for_social_program").attr("value");
        var total_price=orginal_value*price_per;
        $("#total_price_of_tickets_for_social_program").attr("value", total_price);
        $("#total_price_of_tickets_for_social_program_view").html(total_price);
        adjust_new_price_program(pre_price);
    });
});

function adjust_new_price_program(pre_price){
    var new_price=$("#total_price_of_tickets_for_social_program").attr("value");
    if(isNaN(new_price)){
        new_price=0;
    }
    var total_amount = $("#total_amount_by_user").attr("value");
    var new_amount=parseInt(total_amount)+parseInt(new_price)-parseInt(pre_price);
    //alert(total_amount+"+"+new_price+"-"+pre_price+"="+new_amount);
    $("#total_amount_by_user").attr("value", new_amount);
}