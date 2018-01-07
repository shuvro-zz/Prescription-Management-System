$(document).ready(function(){

    $('body').delegate('.btn-cancel','click', function(e){
        e.preventDefault();
        var url = home_url+'admin/'+current_controller;
        location.href = url;
    });

});
