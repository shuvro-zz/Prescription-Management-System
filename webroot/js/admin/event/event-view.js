
processEventView();

function processEventView() {
    var pathname = window.location.pathname;
    var url      = window.location.href;
    var url_method = pathname.split('/')[3];

    if(url_method == 'view'){

        $('.event-view-control-section').removeClass('hide');
        $('.event-create-control-section').addClass('hide');
        $('.seat-plan').addClass('hide');
        $('.cb-wrap').addClass('hide');
        $('.level-row-dom-remove').addClass('hide');
        $('.level-row-dom-add').addClass('hide');

        $('.level-color-picker').removeClass('level-color-picker');

        disableAllInputs($(".content"));
    }

}

function disableAllInputs(t,form_inputs) {
    if(!t){
        t = document;
    }
    if(!form_inputs  || !$.isArray(form_inputs)){
        var form_inputs = [ "input", "select", "textarea","button"];
    }
    if(typeof t == "string"){
        t = $(t);
    }
    if(t.length == 0){
        return false;
    }
    
    for (var i = 0; i < form_inputs.length; i++) {
        $(form_inputs[i],t).each(function(){
            var el = $(this);
            el.prop("read-only",true);
            el.attr("disabled","disabled").addClass("disabled");
        });

    }
}