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

</body>
</html>