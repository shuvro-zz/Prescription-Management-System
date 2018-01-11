<!DOCTYPE html>
<html>
<head>

    <?php echo $this->Html->charset() ?>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
	<meta name="description" content="WebAlive - Admin Template">
	<meta name="keywords" content="webalive, webapp, admin, dashboard, template, ui">

    <title>PMS</title>
    <?php echo $this->Html->meta('icon') ?>



    <?php
    echo $this->Html->script([
        'jquery.min.js',
        'jquery.validate',
    ]);
    ?>
    <?php echo $this->Html->css('admin_styles/css/login') ?>


</head>
<body id="app" class="app off-canvas body-full">

    <?php
        echo $this->fetch('content');
    ?>

    <footer>

    </footer>



<script>
    /*if(typeof autocomplete_off != "function"){
        var autocomplete_off = function (){
            var auto_complete_html = "<div id='autocomplete_off' style='height: 0px !important; width: 0px !important; margin-left: -1700px !important; overflow: hidden !important; position: fixed !important;'>" +
                "<input style='display:none'>" +
                "<input type='password' style=''>" +
                "<input type='text'  autocomplete='chrome' />" +
                "</div>" ;
            $('form,input,select,textarea').attr("autocomplete", "off");
            $('form').each(function(){
                $("#autocomplete_off",$(this)).remove();
                $(this).prepend(auto_complete_html);
            });
        }
    }
    autocomplete_off();*/
</script>

</body>
</html>