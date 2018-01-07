<?php if(isset($_SESSION['error']) && $_SESSION['error'] != ''): ?>
    <h2 style="color:#FF0000;"><?php echo $_SESSION['error']; unset($_SESSION['error']); ?></h2>
<?php endif; ?>
<?php

/*
<p>
    <a href="https://leanhealthatstanford.org/form/workshops/">
        <?php echo $this->Html->image('/img/old_img/regopenwide.jpg', ['alt' => 'lady-womeo', 'class'=>'lady-wome']); ?>
        <!--<img src="assets/regopenwide.jpg" style="width: 955px; margin-top: 0px;">-->
    </a>
</p>
*/ ?>

<h2><b>Purpose of this event</b></h2>
<p>
    This academic meeting is designed to foster an <b>increased and deeper understanding</b> of lean improvement in healthcare, with a focus on academic teaching hospitals around the world. An international call for abstracts will be the basis for program design, with more than half of the program dedicated to delegate contribution. Delegate contribution may occur through oral presentation of poster format. <a style="text-decoration: none" href="abstracts-application"><b>Click here</b></a> for more information on the Call for Abstracts. Abstract submissions close <b>Friday July 14, 2017</b>.
</p>

<!--<h2 style="text-align: center; font-size: 19px; padding:15px 0 15px 0; color: #263f8f;"><b>Call for abstracts deadline extended to July 1, 2016</b></h2>

<a href="abstract.php" class="submit abstracts-application" />Call For Abstracts</a>-->

<table class="main-home-content" width="100%" border="0">
    <tr>
        <td width="65%">
            <h2><b>Location</b></h2>
            <p>
                The conference will take place on the beautiful Stanford Campus, at the Paul Brest Hall on September 27-28, 2017.
            </p>
            <p>
                The event organizers have secured discounted rates at local hotels and further information will be provided in the coming weeks. Accommodation in Palo Alto is expensive, cheaper accommodation may be found in Redwood City and Mountain View with access to the Stanford Campus via Caltrain Service to Palo Alto from these locations.
            </p>
        </td>
        <td width="5%"></td>
        <td width="30%"><h3>Early Bird<br> Registration Closes<br>August 27</h3> </td>
    </tr>
</table>





<!--<h2 style="text-align: center"><strong>The Stanford Lean Healthcare Academic Conference organizers, <br> acknowledge the support of the following organization</strong></h2>
    <p>&nbsp;</p>-->

<!--<p style="padding-top:15px; padding-bottom: 15px;  text-align: center; ">-->


<!--
<img style="margin-right: 30px;" width="280" src="assets/lean-logo-body.jpg" />
<img width="280" style=" margin-top: 25px; margin-right: 20px" src="assets/lean-logo-body-right.jpg" /> </p>
-->
<a href="workshops" class="btn-full ">Online Registration is now Open <span class='arrow-right'></span></a>
<h2 style="text-align: center; line-height: 24px;"><b>The Lean Healthcare Academic Conference at Stanford Organizers Acknowledge the Support of the Following Organizations</b></h2>
<!--<p>&nbsp;</p>-->
<p style="text-align: center">
<?php  echo $this->Html->image('/img/lean.jpg', ['alt' => 'lady-womeo', 'class'=>'lady-wome']); ?>
<?php  echo $this->Html->image('/img/catalysis.png', ['alt' => 'lady-womeo', 'class'=>'lady-wome']); ?>
</p>
<p style="margin-top:15px;">
    <?php echo $this->Html->image('/img/old_img/abstrac-img-bottom.jpg', ['alt' => 'lady-womeo', 'class'=>'lady-wome']); ?>

    <!-- <img style="margin-top:15px;" src="assets/abstrac-img-bottom.jpg" /> -->
</p>



