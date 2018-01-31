<p>Hi <?php echo $data['User']['first_name'].' '.$data['User']['first_name']; ?>,</p>
<p>Please click on the link to reset your password <?php echo $data['base_url'].'admin/users/reset_password/'. $data['User']['token'] ?> </p>

<div>Kind regards,</div>
<div>PMS</div>
<p>&nbsp;</p>


