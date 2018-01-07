<!DOCTYPE html>
<html>
    <head>
        <?php echo $this->Html->charset() ?>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <title>Lean Health</title>
        

        <?php //echo $this->Html->meta('icon') ?>

        <script type="text/javascript">var SITE_URL="<?php echo $this->Url->build('/',true);?>"</script>

        <?php echo $this->element('parts/site_styles');?>

        <?php echo $this->element('parts/site_scripts');?>

    </head>
    <body class="home">

        <?php echo $this->element('home_header');?>

        <?php echo $this->fetch('content') ?>

    </body>
</html>
