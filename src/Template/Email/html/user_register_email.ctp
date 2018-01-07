<?php
$delegate = $post_data['Delegate'];
?>

<img src="<?php echo $this->Url->Build('/img/banner.jpg',true);?>" alt="email">


<p style="font-family:Calibri, Tahoma, Arial;">Hi <?php echo $delegate['given_name'].' '.$delegate['family_name']; ?>,</p>

<?php include('register_email.ctp'); ?>

<div style="font-family:Calibri, Tahoma, Arial;">Kind regards,</div>
<div style="font-family:Calibri, Tahoma, Arial;">Lean Healthcare Academic Conference at Stanford</div>
<p style="font-family:Calibri, Tahoma, Arial;">Enquiries regarding registration for the Lean Healthcare Academic Conference at Stanford please email <a href="mailto:lisa@lean.org.au">lisa@lean.org.au</a></p>


<p>&nbsp;</p>


