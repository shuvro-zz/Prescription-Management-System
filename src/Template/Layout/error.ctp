
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

        <?php echo $this->Html->css('style'); ?>

        <?php echo $this->element('parts/site_scripts');?>

        <?php echo $this->fetch('script') ?>

    </head>

    <body>
        <div id="container">
            <div class="error-page">
                <h1>O<span>ops</span>!</h1>
                <h2>404 Error </h2>
                <p>Oh Dear! We can't find the page you were looking for. Isn't that annoying? Sorry for the inconvenience.</p>
            </div>
        </div>
    
    </body>

</html>
