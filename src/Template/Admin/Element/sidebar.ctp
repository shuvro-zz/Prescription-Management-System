<aside class="left-sidebar">
    <!--<div class="logo">
        <a href="<?php /*echo $this->Url->build('/admin/dashboard');*/?>" title="">
            <h1 style="margin-bottom: 0px">HEALTHTECHBD</h1>

            <?php /*echo $this->Html->image('/css/admin_styles/images/logo.jpg', ['alt' => 'Logo']) */?>
        </a>
    </div>-->
    <nav class="leftside-navigation">
        <ul>
            <li class="navigation-item dashboard <?php if($this->name=='Dashboard') echo 'active'?>">
                <a href="<?php echo $this->Url->build(array( 'controller' => 'dashboard','action' => 'index' ));?>"><span class="nav-icon"><i class="fa fa-tachometer" aria-hidden="true"></i>
                </span><span class="nav-text">Dashboard</span></a>
            </li>

            <?php
            if( $this->request->session()->read('Auth.User.role_id') == 1){ // Admin role id ?>
                <li class="navigation-item dashboard <?php if($this->name=='Users' and $this->request->session()->read('Auth.User.role_id') == 1) echo 'active'?>">
                    <a href="<?php echo $this->Url->build(array( 'controller' => 'users','action' => 'index' )) // Admin role id  ;?>"><span class="nav-icon"><i class="fa fa-user-md" aria-hidden="true"></i>
                    </span><span class="nav-text">Doctors</span></a>
                </li>
            <?php } ?>
            <li class="navigation-item dashboard <?php if($this->name=='DiagnosisLists') echo 'active'?>">
                <a href="<?php echo $this->Url->build(array( 'controller' => 'diagnosisLists','action' => 'index' )); ?>"><span class="nav-icon"><i class="fa fa-heartbeat" aria-hidden="true"></i>
                </span><span class="nav-text">Diagnosis</span></a>
            </li>
            <li class="navigation-item dashboard <?php if($this->name=='Medicines') echo 'active'?>">
                <a href="<?php echo $this->Url->build(array( 'controller' => 'medicines','action' => 'index' )); ?>"><span class="nav-icon"><i class="fa fa-medkit" aria-hidden="true"></i>
                </span><span class="nav-text">Medicines</span></a>
            </li>
            <li class="navigation-item dashboard <?php if($this->name=='Tests') echo 'active'?>">
                <a href="<?php echo $this->Url->build(array( 'controller' => 'tests','action' => 'index' )); ?>"><span class="nav-icon"><i class="fa fa-thermometer-empty" aria-hidden="true"></i>
                </span><span class="nav-text">Examinations</span></a>
            </li>

            <?php if( $this->request->session()->read('Auth.User.role_id') != 1){ ?> <!--Admin role id-->
                <li class="navigation-item dashboard <?php if($this->name=='Users') echo 'active'?>">
                    <a href="<?php echo $this->Url->build(array( 'controller' => 'users','action' => 'reset' )) ?>"><span class="nav-icon"><i class="fa fa-user-circle-o" aria-hidden="true"></i>
                    </span><span class="nav-text">Patients</span></a>
                </li>
                <li class="navigation-item dashboard <?php if($this->name=='Appointments') echo 'active'?>">
                    <a href="<?php echo $this->Url->build(array( 'controller' => 'Appointments','action' => 'index' )) ?>"><span class="nav-icon"><i class="fa fa-calendar" aria-hidden="true"></i>
                    </span><span class="nav-text">Future Appointments</span></a>
                </li>
                <li class="navigation-item dashboard <?php if($this->name=='Diagnosis') echo 'active'?>">
                    <a href="<?php echo $this->Url->build(array( 'controller' => 'diagnosis','action' => 'index' )); ?>"><span class="nav-icon"><i class="fa fa-file-text" aria-hidden="true"></i>
                    </span><span class="nav-text">Diagnosis Templates</span></a>
                </li>
                <li class="navigation-item dashboard <?php if($this->name=='Prescriptions') echo 'active'?>">
                    <a href="<?php echo $this->Url->build(array( 'controller' => 'prescriptions','action' => 'patientIdReset' )); ?>"><span class="nav-icon"><i class="fa fa-product-hunt" aria-hidden="true"></i>
                    </span><span class="nav-text">Prescriptions</span></a>
                </li>

                <li class="navigation-item dashboard <?php if($this->name=='Library') echo 'active'?>">
                    <a href="<?php echo $this->Url->build(array( 'controller' => 'library','action' => 'index' )); ?>"><span class="nav-icon"><i class="fa fa-book" aria-hidden="true"></i>
                    </span><span class="nav-text">Library</span></a>
                </li>

                <!--<li class="navigation-item dashboard <?php /*if($this->name=='Templatesettings') echo 'active'*/?>">
                    <a href="<?php /*echo $this->Url->build(array( 'controller' => 'templatesettings','action' => 'add' )); */?>"><span class="nav-icon"><i class="fa fa-product-hunt" aria-hidden="true"></i>
                    </span><span class="nav-text">Templates Settings</span></a>
                </li>-->
            <?php } ?>

            <?php if( $this->request->session()->read('Auth.User.role_id') == 1){ // Admin role id ?>
                <li class="navigation-item dashboard <?php if($this->name=='Settings') echo 'active'?>">
                    <a href="<?php echo $this->Url->build(array( 'controller' => 'Settings','action' => 'add' )) ?>"><span class="nav-icon"><i class="fa fa-cog" aria-hidden="true"></i>
                    </span><span class="nav-text">Settings</span></a>
                </li>
            <?php } ?>

        </ul>
    </nav>
</aside>

<script type="text/javascript">
    $(document).ready(function(){
        jQuery('.sub-navigation').click(function(e){
            e.preventDefault();

            jQuery(this).next('.sub-menu-ecommerce-nav').slideToggle('slow',function(){
                setTimeout(function(){
                    $( ".ecommerce-nav").toggleClass('active');
                    $( ".sub-navigation" ).not(".ecommerce-nav").removeClass("active");
                    $( ".sub-menu").not(".sub-menu-ecommerce-nav").slideUp('slow');
                },0);
            });

            jQuery(this).next('.sub-menu-attendees').slideToggle('slow',function(){
                setTimeout(function(){
                    $( ".attendees-nav" ).toggleClass("active");
                    $( ".sub-navigation" ).not(".attendees-nav").removeClass("active");
                    $( ".sub-menu").not(".sub-menu-attendees").slideUp('slow');
                },0);
            });
        });
    });
</script>