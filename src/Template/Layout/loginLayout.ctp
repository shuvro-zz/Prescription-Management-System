<!DOCTYPE html>
<html>
<head>

    <?php echo $this->Html->charset() ?>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
	<meta name="description" content="You can easily manage your Patients">
	<meta name="keywords" content="Healthtechbd">
    <meta property="og:title" content="Healthtechbd">

    <title>PMS</title>
    <?php echo $this->Html->meta('icon') ?>

    <?php
    echo $this->Html->script([
        'jquery.min.js',
        'jquery.validate',
    ]);
    ?>
    <?php echo $this->Html->css('admin_styles/css/login') ?>
    <?php echo $this->Html->css('admin_styles/css/font-awesome.min.css') ?>


</head>
<body id="app" class="app off-canvas body-full">

    <?php
        echo $this->fetch('content');
    ?>

</body>
</html>