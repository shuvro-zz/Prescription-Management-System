jQuery(document).ready(function(){

    $(".admin_complementary").change(function() {
        if(this.checked) {
            $('#card_section').hide();
        } else {
            $('#card_section').show();
        }
    });
    
    // control day indicate
    $('#card_expiry_year').change(function(){
        jQuery("#card_expiry_year-error").remove();
        //$('#card_expiry_month').validate().element('#card_expiry_month');
        $('#card_expiry_year').validate().element('#card_expiry_year');
    });

    $('#expiry_month').change(function(){
        jQuery("#card_expiry_year-error").remove();
        $('#card_expiry_year').validate().element('#card_expiry_year');

    });

    $(".control_day_indecate").click(function(){
        $(".spacific_day").attr('checked',false);
        if($(this).is(":checked")){
            $(".indicate_day").show();
            $("#default_spacific_day").prop('checked',true);
        }else{
            $(".indicate_day").hide();
        }
    });

    $(".control_day_indecate_reg4").click(function(){
        if($(this).is(":checked")){
            $(".spacific_day_reg4").prop('checked',true);
            $(".indicate_day_reg4").show();
        }else{
            $(".spacific_day_reg4").prop('checked',false);
            $(".indicate_day_reg4").hide();
        }
    });

    function getExpirationYear(){
        return $('#card_expiry_year').val();
    }

    function getExpirationMonth(){
        return $('#expiry_month').val();
    }

    function getPresentMonth(){
        var d = new Date();
        var month = d.getMonth()+1;
        return month;
    }

    function getPresentYear(){
        var d = new Date();
        var year = d.getFullYear();
        return year;
    }

    $.validator.addMethod("checkMonthYear", function(value, element) {

        var present_month = getPresentMonth();
        var present_year = getPresentYear();

        var expiration_year = getExpirationYear();
        var expiration_month = getExpirationMonth();

        if((expiration_year == present_year) && (expiration_month < present_month)){

            if(!$('#expiry_month').hasClass('error')){
                $('#expiry_month').addClass('error')
            }
            var expiration_time_validation = false;
        } else if (expiration_year < present_year) {

            if(!$('#card_expiry_year').hasClass('error')){
                $('#card_expiry_year').addClass('error')
            }
            var expiration_time_validation = false;
        } else {

            $('#expiry_msg').html('');
            $('#expiry_month').removeClass('error');
            $('#card_expiry_year').removeClass('error');
            var expiration_time_validation = true;
        }

        return expiration_time_validation;

    }, "Invalid Card Expiration Time");

    $.validator.addMethod("checkCardNumber", function(value, element, params) {

        var cc_number = $("#card_number").val();
        var card_type = getCartType(cc_number);

        if(card_type == false){
            return false;
        }else{
            return true;
        }

    }, 'Please Enter Valid CVC');

    $.validator.addMethod("cardSecurityCode", function(value, element) {

        var cc_number = $("#card_cvc").val();
        var card_type = getCartType(cc_number);
        var code_length = $('#card_cvc').val().length;

        if( (card_type == 'Master Card') || (card_type == 'Visa') ){

            if(code_length != 3){
                var validation = false;
            } else {
                var validation = true;
            }

        }else if(card_type=='AMEX'){

            if(code_length != 4){
                var validation = false;
            } else {
                var validation = true;
            }

        } else {

            if( (code_length < 3) || (code_length > 4) ){
                var validation = false;
            } else {
                var validation = true;
            }

        }

        return validation;

    }, "Please Enter Valid CVC");

    $("#registration").validate({
        rules: {
            'data[Delegate][title]':{
                required:true
            },
            'data[Delegate][given_name]':{
                required:true
            },
            'data[Delegate][family_name]':{
                required:true
            },
            'data[Delegate][organization]':{
                required:true
            },
            'data[Delegate][position]':{
                required:true
            },
            'data[Delegate][address1]':{
                required:true
            },
            'data[Delegate][city]':{
                required:true
            },
            'data[Delegate][state]':{
                required:true
            },
            'data[Delegate][postcode]':{
                required:true
            },
            'data[Delegate][mobile]':{
                required:true
            },
            'data[Delegate][email]': {
                required: true,
                email: true
            },
            'data[Delegate][preffered_badge_name]':{
                required:true
            },
            'data[Payment][card_holder_name]':{
                required:true
            },
            "data[Payment][card_number]": {
                checkCardNumber : true,            // Checking method
                required: true,
                maxlength: 16,
                number: true
            },
            "data[Payment][card_cvc]": {
                cardSecurityCode: true,           // Checking method
                number: true,
                maxlength: 4,
                minlength: 3
            },
            "data[Payment][card_expiry_year]": {
                checkMonthYear : true
            },
            "data[Payment][card_expiry_month]": {
                checkMonthYear : true
            }
        },
        errorPlacement: function(error, element) {
            if (element.attr("name") == "data[Payment][card_expiry_month]" || element.attr("name") == "data[Payment][card_expiry_year]" ) {
                $('#expiry_msg').show();
                $('#expiry_msg').html(error);
            } else if(element.attr("name") == "data[Delegate][title]"){
                error.insertAfter('#otherTitle');
            } else {
                error.insertAfter(element);
            }
        },
        submitHandler: function(form) {
            $('#orderSuccessPopupMessage').show();
            $('.btnsubmit').attr('disabled',true);
            registrationSubmit();
            //form.submit();

        }
    });

    function registrationSubmit(){
        var data = $('#registration').serialize();
        $.ajax({
            method:'POST',
            url: SITE_URL + 'workshops/process_registration',
            data:data,
            success:function(response){
                console.log(response);
            }
        });
    }

    $("body").delegate('.registration_qty', "keyup", function() {
        var qty = $(this).val();
        if(qty>0) {
            if (qty > 0) {
                $('.is_required').prop('required', false);
            } else {
                $('.is_required').prop('required', true);
            }

            var today = new Date();
            var dd = today.getDate();
            var mm = today.getMonth() + 1; //January is 0!
            var yyyy = today.getFullYear();

            $this_closest = $(this).closest('#register_tr');


            // 26/08/2016
            if ((mm == 8 && dd > 25) || mm > 8) {
                var amount = $this_closest.find('.register_standard').find('label').text();
            } else {
                var amount = $this_closest.find('.register_early_bird').find('label').text();
            }

            var amount = amount.replace("$", "");

            var first_option = $(this).hasClass('first_option');

            if (first_option) {
                var bonus = bonusCheck();
            } else {
                var bonus = 0;
            }


            var total = parseInt(amount) * (qty - bonus);

            $this_closest.find('.registration_fee_item_total').text('$' + total);

            showSumQty();

            showSumTotal();

            showPayment();
        }
    });

    $("body").delegate('.social_program_quantity', "keyup", function() {
        var qty = $(this).val();
        if(qty>0) {
            var cost_per_ticket = $(this).closest('.social_program_total_cost').find('.social_cost_per_ticket').html();
            var cost_per_ticket = cost_per_ticket.replace("$", "");
            var total = parseInt(cost_per_ticket) * qty
            $('.social_program_price').html('$' + total);
            $('#social_program_total_cost').val(total);

            showPayment();
        }
    });

    function getCartType(number) {
        var re = {
            visa: /^4[0-9]{12}(?:[0-9]{3})?$/,
            mastercard: /^5[1-5][0-9]{14}$/,
            amex: /^3[47][0-9]{13}$/,
            diners: /^3(?:0[0-5]|[68][0-9])[0-9]{11}$/,
            discover: /^6(?:011|5[0-9]{2})[0-9]{12}$/,
            jcb: /^(?:2131|1800|35\d{3})\d{11}$/
        };
        if (re.visa.test(number)) {
            return 'Visa';
        } else if (re.mastercard.test(number)) {
            return 'Master Card';
        } else if (re.amex.test(number)) {
            return 'AMEX';
        } else if (re.diners.test(number)) {
            return 'diners';
        } else if (re.discover.test(number)) {
            return 'discover';
        } else if (re.jcb.test(number)) {
            return 'jcb';
        }else{
            return false;
        }
    }

    function bonusCheck(){
        var two_day_register = $('.calculate_registration_fee tr').eq(2).find('.registration_qty').val();
        if(two_day_register>=6){
            var bonus = parseInt(two_day_register / 6);
        } else {
            var bonus = 0;
        }
        return bonus;
    }

});


function showPayment(){

    showSectionBPrice();

    showSectionBQty();

    showSectionFPrice();

    showSectionFQty();

    showPaymentTotal();

    showTotalQty();

}

function showSectionBPrice(){

    var section_bprice = $('#registration_total_amount').html();
    $('#summery_registration_fee').html(section_bprice);

}

function showSectionBQty(){

    var sectionb_qty = parseInt($('#registration_total_qty').html());
    $('.sectionb_qty').html(sectionb_qty);

}

function showSectionFPrice(){

    var section_fprice = $('.social_program_price').html();
    $('#summery_social_program').html(section_fprice);

}

function showSectionFQty(){

    var sectionf_qty = $('.social_program_quantity').val();
    $('.sectionf_qty').html(sectionf_qty);

}

function showPaymentTotal(){

    var section_bprice = $('#summery_registration_fee').html();
    section_bprice = removeDoller(section_bprice);

    var section_fprice = $('#summery_social_program').html();
    section_fprice = removeDoller(section_fprice);

    var payment_and_conditions_total = section_bprice + section_fprice;

    var sales_tax_amount = $('#hidden_sales_tax_amount').val();
    var sales_tax_total = (sales_tax_amount/100)*payment_and_conditions_total;
    var grand_total = payment_and_conditions_total + sales_tax_total;

    $('#show_sales_tax_total').html('$'+sales_tax_total.toFixed(2));
    $('#sales_tax_total').val(sales_tax_total);
    $('#payment_and_conditions_total').html('$'+grand_total.toFixed(2));
    $('#grand_total').val(grand_total);

}

function removeDoller(price){

    var price = price.replace('$','');
    var price = parseInt(price);
    if(!price){
        price = 0;
    }
    return price

}

function showTotalQty(){
    var sectionb_qty = $('.sectionb_qty').html();
    sectionb_qty = parseInt(sectionb_qty);
    if(!sectionb_qty){ sectionb_qty = 0; }

    var sectionf_qty = $('.sectionf_qty').html();
    sectionf_qty = parseInt(sectionf_qty);
    if(!sectionf_qty){ sectionf_qty = 0; }

    var total_qty = sectionb_qty + sectionf_qty;
    $('.payment_qty').html(total_qty);
}

function showSumTotal(){
    var total_amount = 0;
    $('.registration_fee_item_total').each(function(i, obj) {
        var total = $(this).html();
        var total = total.replace('$','');
        var total = parseInt(total);
        if(total){
            total_amount += total;
        }
    });
    $('#registration_total_amount').html('$'+total_amount);
}

function showSumQty(){
    var total_qty = 0;
    $('.registration_qty').each(function(i, obj) {
        var qty = parseInt($(this).val());
        if(qty){
            total_qty += qty;
        }
    });
    $('#registration_total_qty').html(total_qty);
}

function showGroupRegistration(qty) {

    $('.group_container').remove();

    if (qty>1){

        var group_html = '';
        for(var i=0; i<qty; i++) {
            group_html = group_html+""+'<table><tr><td><label>Name:</label><input type="text" name="data[Registration][group]['+i+'][name]" class="group" /></td><td><label>Email:</label><input type="email" name="data[Registration][group]['+i+'][email]" class="group" /> </td></tr></table>';
        }

        $('.fields_group_registration').after('<tr class="group_container"><td colspan="2">&nbsp;</td><td colspan="3">'+group_html+'</td></tr>');
        $('.group').prop('required',true);
    }
}

function showOthersField(val) {
    if(val=='Other'){
        $('#state_dropdown').show();
    }else{
        $('#state_dropdown').hide();
    }
}