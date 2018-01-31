jQuery(document).ready(function () {
    //create slug
    jQuery('#name').keyup(function(){
        jQuery('#slug').val(slug(jQuery('#name').val()));
    });

    var slug = function(str) {
        var $slug = '';
        var trimmed = jQuery.trim(str);
        $slug = trimmed.replace(/[^a-z0-9-]/gi, '-').
        replace(/-+/g, '-').
        replace(/^-|-$/g, '');
        return $slug.toLowerCase();
    }
    
});

function initDatePicker(){

    $(".datetime").each(function(){
        var format = $(this).attr('format')
        if(!format || $.trim(format)==""){
            format = 'Y/m/d g:i A'
        }
        var formatTime = $(this).attr('formatTime')
        if(!formatTime || $.trim(formatTime)==""){
            formatTime = 'h:m A'
        }

        $('.datetime').datetimepicker({
            format:'Y/m/d g:i A',
            formatTime:formatTime
        });

    });

    $(".date").each(function(){
        $(this).datetimepicker({
            timepicker:false,
            format: 'd/m/Y'
        });
    });


    $('.time').datetimepicker({
        datepicker:false,
        format:'H:i'
    });

    $(".date").readOnly(true);
    $(".time").readOnly(true);
}

function printPrescription() {

    var toPrint = document.getElementById('printable_area');

    var popupWin = window.open('', '_blank', 'width=1000,height=800,location=no,left=200px');

    popupWin.document.open();

    popupWin.document.write('<html><title>::Preview::</title></head><body onload="window.print()">');

    popupWin.document.write(toPrint.innerHTML);

    popupWin.document.write('</html>');

    popupWin.document.close();

}

/*function printPreviewPrescription() {

    var toPrint = document.getElementById('printable_area');

    var popupWin = window.open('', '_blank', 'width=350,height=150,location=no,left=200px');

    popupWin.document.open();

    popupWin.document.write('<html><title>::Print Preview::</title><link rel="stylesheet" type="text/css" href="Print.css" media="screen"/></head><body">')

    popupWin.document.write(toPrint.innerHTML);

    popupWin.document.write('</html>');

    popupWin.document.close();

}*/
