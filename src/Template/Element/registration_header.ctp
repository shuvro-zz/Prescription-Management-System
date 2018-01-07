<header id="header" class="header-inner">
    <div class="top-header">
        <div class="main-container-top">
            <div class="company-logo">
                <?php echo $this->Html->image('banner.jpg', ['alt' => 'Banner',  'url'=>['controller' => 'Workshops']]); ?>
            </div>
        </div>
        <div class="header-main-menu">
            <?php echo $this->element('site_menu');?>
        </div>
    </div>
</header>

