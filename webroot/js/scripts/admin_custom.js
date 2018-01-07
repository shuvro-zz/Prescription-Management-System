/**
 * Created by bakar on 11/19/2015.
 */
jQuery(document).ready(function(){
    jQuery("#site-nav").addClass("nav-expand ps-container ps-active-y");
    jQuery("#admin_navigation li").each(function(){
        //console.log(jQuery(this).attr('id'));
        console.log(controller)
        if(jQuery(this).attr('id')==controller){
            jQuery(this).attr('class','open');
        }
    });

    jQuery( "#sortable" ).sortable();
    jQuery( "#sortable" ).disableSelection();

});