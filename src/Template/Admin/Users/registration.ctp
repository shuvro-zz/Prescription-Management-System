
<div class="login-area">
    <div class="login-box v-middle ">

        <h3>Registration</h3>
        <div class="row">
            <div class="col-md-12">
                <?php echo $this->Flash->render('admin_success'); ?>
                <?php echo $this->Flash->render('admin_error'); ?>
            </div>
        </div>
        <?php echo $this->Form->create(); ?>
        <div class="form-area">

            <input type="text" name="first_name" class="md-input" id="firstName" placeholder="First Name" required="required">
            <input type="text" name="last_name" class="md-input" id="lastName" placeholder="Last Name" required="required">
            <input type="text" name="email" class="md-input" id="email" placeholder="Email" required="required">
            <input type="password" name="password" class="md-input" id="password" placeholder="Password" required="required" >
            <input type="password" name="password" class="md-input" id="password" placeholder="Comfarim Password" required="required" >
            <input type="submit" value="Registration">

        </div>
        <?php echo $this->Form->end() ?>

        <div class="login_bottom">
            <a class="registration" style="float:left" href="<?php echo $this->Url->build(array( 'controller' => 'Users','action' => 'login' )); ?>" title="Login">Login</a>
            <a class="reset_password" style="float:right" href="<?php echo $this->Url->build(array( 'controller' => 'Users','action' => 'reset_password' )); ?>" title="Reset Password">Reset Password</a>

        </div>
    </div>
</div>

<script type="text/javascript">
    /*$(document).ready(function(){
     $("#admin-login-form").validate({
     rules:{
     "email": "required",
     "password": "required"
     },
     messages:{
     "email": "Please enter a Valid Email Address",
     "password": "Please enter a Password",
     }
     });
     });*/
</script>


