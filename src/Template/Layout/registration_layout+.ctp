<!DOCTYPE html>
<html>
    <head>
        <?php echo $this->Html->charset() ?>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <title>Leanhealthatstanford</title>
        <?php echo $this->Html->meta('icon') ?>

        <?php echo $this->fetch('meta') ?>
        <?php echo $this->fetch('css') ?>

        <script type="text/javascript">var SITE_URL="<?php echo $this->Url->build('/',true);?>"</script>
        <script type="text/javascript">var WEB_ROOT="<?php echo $this->request->webroot;?>"</script>
        
        <?php echo $this->element('parts/site_styles');?>

        <?php echo $this->Html->css('style_registration.css?v='.$version); ?>

        <?php echo $this->element('parts/site_scripts');?>

        <?php echo $this->fetch('script') ?>

    </head>
    <body>

        <?php echo $this->element('registration_header');?>

        <?php echo $this->fetch('content') ?>

        <?php echo $this->element('registration_footer');?>

    </body>
</html>
