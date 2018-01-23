

<aside class="left-sidebar">
    <nav class="leftside-navigation">
        <ul>
            <li class="navigation-item dashboard <?php if($this->name=='Dashboard') echo 'active'?>">
                <a href="<?php echo $this->Url->build(array( 'controller' => 'dashboard','action' => 'index' ));?>" title="Dashboard"><span class="nav-icon"><span class="icon"></span>
                </span><span class="nav-text">Dashboard</span></a>
            </li>
            <li class="navigation-item dashboard <?php if($this->name=='Medicines') echo 'active'?>">
                <a href="<?php echo $this->Url->build(array( 'controller' => 'medicines','action' => 'index' )); ?>" title="Medicines"><span class="nav-icon"><span class="icon"></span>
                </span><span class="nav-text">Medicines</span></a>
            </li>
            <li class="navigation-item dashboard <?php if($this->name=='Tests') echo 'active'?>">
                <a href="<?php echo $this->Url->build(array( 'controller' => 'tests','action' => 'index' )); ?>" title="Tests"><span class="nav-icon"><span class="icon"></span>
                </span><span class="nav-text">Tests</span></a>
            </li>
            <li class="navigation-item dashboard <?php if($this->name=='Users') echo 'active'?>">
                <a href="<?php echo $this->Url->build(array( 'controller' => 'users','action' => 'index' )); ?>" title="Patients"><span class="nav-icon"><span class="icon"></span>
                </span><span class="nav-text">Patients</span></a>
            </li>
            <li class="navigation-item dashboard <?php if($this->name=='Prescriptions') echo 'active'?>">
                <a href="<?php echo $this->Url->build(array( 'controller' => 'prescriptions','action' => 'index' )); ?>" title="Prescriptions"><span class="nav-icon"><span class="icon"></span>
                </span><span class="nav-text">Prescriptions</span></a>
            </li>



            <!--<li class="navigation-item dashboard <?php /*if($this->name=='Events') echo 'active'*/?>">
                <a href="<?php /*echo $this->Url->build(array( 'controller' => 'events','action' => 'index' ));*/?>" title="Events"><span class="nav-icon"><span class="icon"></span>
                </span><span class="nav-text">Events</span></a>
            </li>
            <li class="navigation-item dashboard <?php /*if($this->name=='Venues') echo 'active'*/?>">
                <a href="<?php /*echo $this->Url->build(array( 'controller' => 'venues','action' => 'index' ));*/?>" title="Venues"><span class="nav-icon"><span class="icon"></span>
                </span><span class="nav-text">Venues</span></a>
            </li>
            <li class="navigation-item dashboard <?php /*if($this->name=='Conferences') echo 'active'*/?>">
                <a href="<?php /*echo $this->Url->build(array( 'controller' => 'conferences','action' => 'index' ));*/?>" title="Conferences"><span class="nav-icon"><span class="icon"></span>
                </span><span class="nav-text">Conferences</span></a>
            </li>
            <li class="navigation-item dashboard <?php /*if($this->name=='Attendees') echo 'active'*/?>">
                <a href="<?php /*echo $this->Url->build(array( 'controller' => 'attendees','action' => 'index' ));*/?>" title="Attendees"><span class="nav-icon"><span class="icon"></span>
                </span><span class="nav-text">Attendees</span></a>
            </li>
            <li class="navigation-item dashboard <?php /*if($this->name=='AttendeeTypes') echo 'active'*/?>">
                <a href="<?php /*echo $this->Url->build(array( 'controller' => 'AttendeeTypes','action' => 'index' ));*/?>" title="Attendee Types"><span class="nav-icon"><span class="icon"></span>
                </span><span class="nav-text">Attendee Types</span></a>
            </li>
            <li class="navigation-item dashboard <?php /*if($this->name=='Reports') echo 'active'*/?>">
                <a href="#" title="Reports"><span class="nav-icon"><span class="icon"></span>
                </span><span class="nav-text">Reports</span></a>
            </li>-->
            <li class="navigation-item dashboard <?php if($this->name=='Settings') echo 'active'?>">
                <a href="<?php echo $this->Url->build(array( 'controller' => 'Settings','action' => 'add' )) ?>" title="Settings"><span class="nav-icon"><span class="icon"></span>
                </span><span class="nav-text">Settings</span></a>
            </li>

            <!--<li class="navigation-item ecommerce <?php /*if (in_array($this->name, array('customers', 'orders', 'order-tickets'))) echo 'active' */?> ">
                <a href="#" class="sub-navigation ecommerce-nav <?php /*if (in_array($this->name, array('customers', 'orders', 'order-tickets'))) echo 'active' */?>">
                          <span class="nav-icon">
                            <span class="icon"></span>
                          </span>Test</a>
                <ul class="sub-menu sub-menu-ecommerce-nav" <?php /*if (!in_array($this->name, array('customers', 'orders', 'order-tickets'))) echo 'style="display:none"' */?>>
                    <li class="navigation-item events <?php /*if ($this->name == 'customers') echo 'active' */?>">
                        <a href="<?php /*echo $this->Url->build(array('controller' => 'users', 'action' => 'index')); */?>"
                           title="Customers"><span class="nav-text">Customers</span></a>
                    </li>
                </ul>
            </li>

            <li class="navigation-item attendees <?php /*if (in_array($this->name, array('Students', 'OrderTicketAttendees'))) echo 'active' */?> ">
                <a href="#" class="sub-navigation attendees-nav <?php /*if (in_array($this->name, array('Students', 'OrderTicketAttendees'))) echo 'active' */?>">
                          <span class="nav-icon">
                            <span class="icon"></span>
                          </span>Test1</a>
                <ul class="sub-menu-attendees sub-menu" <?php /*if (!in_array($this->name, array('Students', 'OrderTicketAttendees'))) echo 'style="display:none"' */?>>
                    <li class="navigation-item customers <?php /*if ($this->name == 'Students') echo 'active' */?>">
                        <a href="<?php /*echo $this->Url->build(array('controller' => 'students', 'action' => 'index')); */?>"
                           title="Attendees - Eligible"><span class="nav-text">Attendees - Eligible</span></a>
                    </li>
                </ul>
            </li>-->
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