<!DOCTYPE html>
<html>
    <head>
        <?php echo $this->Html->charset() ?>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="title" content="PMS"/>
        <meta name="description" content="Patient Management System"/>

        <title>PMS</title>
        <?php echo $this->Html->meta('icon') ?>

        <?php echo $this->fetch('meta') ?>
        <?php echo $this->fetch('css') ?>

        <script type="text/javascript">var SITE_URL="<?php echo $this->Url->build('/',true);?>"</script>
        <script type="text/javascript">var WEB_ROOT="<?php echo $this->request->webroot;?>"</script>
        
        <?php echo $this->element('parts/site_styles');?>

        <?php echo $this->Html->css('style.css?v='.$version); ?>
        
        <?php echo $this->element('parts/site_scripts');?>

        <?php echo $this->fetch('script') ?>

    </head>
    <body>

        <?php echo $this->element('default_header');?>

        <?php echo $this->fetch('content') ?>

        <?php echo $this->element('default_footer');?>

    </body>
</html>
