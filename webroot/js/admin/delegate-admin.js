 var four_plus_default;
    var pre_reg_type;
    var remove;
    var basic_amount=0;
    $(document).ready(function(){
        $("#type_of_registration_early_standard").change(function(){
            var pre_price=$("#Delegate_registration_price").attr("value");

            var val = $("#type_of_registration_early_standard").attr("value");
            var current_reg_id = $("#type_of_registration_name").attr("value");
            var price_id=current_reg_id+val;
            price_id=price_id.replace(" ", "_");
            var price_new = $("#"+price_id).attr("value");
            $("#delegate_price_for_user").html("$"+price_new);
            $("#Delegate_registration_price").attr("value", price_new);

            calculate_reg_price(pre_price, price_new);
        });

        $("#type_of_registration_name").change(function(){
            var pre_price=$("#Delegate_registration_price").attr("value");

            var val = $("#type_of_registration_early_standard").attr("value");
            var current_reg_id = $("#type_of_registration_name").attr("value");
            var price_id=current_reg_id+val;
            price_id=price_id.replace(" ", "_");
            var price_new = $("#"+price_id).attr("value");
            $("#delegate_price_for_user").html("$"+price_new);
            $("#Delegate_registration_price").attr("value", price_new);
            var category_name=$("#type_of_registration_name option:selected").text();

            if(category_name == "Standard Registration" || category_name == "Complimentary Booking"){
                $("#four_plus_grou_registration").html("");
                $("#total_number_of_registrations").attr("value", "0");
            }else if(category_name == "4+ Group Registration (each)"){
                $("#four_plus_grou_registration").html(four_plus_default);
                $("#total_number_of_registration").attr("value", "4");
            }

            calculate_reg_price(pre_price, price_new);
        });
    });

    function removeRow(cl){
        $("#"+cl).remove();
        var total_number_of_regr=parseInt($("#total_number_of_registration").attr("value"));
        total_number_of_regr--;
        $("#total_number_of_registration").attr("value", total_number_of_regr);

        var pre_price=$("#Delegate_registration_price").attr("value");
        calculate_reg_price(pre_price, pre_price);
    }

    function removeRowPre(cl, memberId){
        $("#remove"+cl).remove();
        $("form #rows_deleted_from_group_member tr:last-child").after("<tr><td><input type='hidden' name='data[DeleteGroupMember][]' value="+memberId+" /></td></tr>");
        var total_number_of_regr=parseInt($("#total_number_of_registration").attr("value"));
        total_number_of_regr--;
        $("#total_number_of_registration").attr("value", total_number_of_regr);

        var pre_price=$("#Delegate_registration_price").attr("value");
        calculate_reg_price(pre_price, pre_price);
    }

    function calculate_reg_price(pre_price, price_new){
        var basic = parseInt($("#basic_amount_of_user").attr("value"));
        var inc=price_new - pre_price;
        var reg = parseInt($("#total_number_of_registration").attr("value"));
        var category_name=$("#type_of_registration_name option:selected").text();
        if(category_name!="4+ Group Registration (each)"){
            reg = 1;
        }
        var total_amount=basic+(price_new*reg);
        $("#total_amount_by_user").attr("value", total_amount);
        //alert(basic+"+("+price_new+"*"+reg+")=");
    }