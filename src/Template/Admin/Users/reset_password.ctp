<?php $this->layout = 'loginLayout'; ?>

<div class="login-area">
    <div class="login-box v-middle ">

        <h3>Reset Password</h3>
        <div class="row">
            <div class="col-md-12">
                <?php echo $this->Flash->render('admin_success'); ?>
                <?php echo $this->Flash->render('admin_error'); ?>
            </div>
        </div>
        <?php echo $this->Form->create(null, [
            'url' => ['controller' => 'Users', 'action' => 'resetPassword'],
            'class' => 'form-horizontal',
            'id' => 'admin-reset-password-form'
        ]); ?>
        <div class="form-area">
            <input type="password" name="password"  class="md-input" placeholder="Password" id="password">
            <input type="password" name="confirm_password"  class="md-input" placeholder="Confirm Password" equalTo="#password" >

            <input type="hidden" name="token" value="<?php echo $token ?>"  >

            <input type="submit" value="Reset">
        </div>
        <?php echo $this->Form->end() ?>

        <div class="login_bottom">
            <a class="registration" style="float:left" href="<?php echo $this->Url->build(array( 'controller' => 'users','action' => 'registration' )); ?>" title="Registration">Registration</a>
            <a class="reset_password" style="float:right" href="<?php echo $this->Url->build(array( 'controller' => 'users','action' => 'login' )); ?>" title="Login">Login</a>

        </div>
    </div>
</div>

<style>
    .error{
        color: red;;
    }
</style>

<script type="text/javascript">
$(document).ready(function(){

    $('#UserPassword').val('');

    $("#admin-reset-password-form").validate({
        rules:{
            "password": "required",
            "confirm_password": "required"
        },
        messages:{
            "password": "Password must have a minimum of 8 characters!",
            "confirm_password":{
                equalTo:"Confirm Password didn't match with Password",
                required:'Please enter Confirm Password'
            }
        }
    });

});
</script>
