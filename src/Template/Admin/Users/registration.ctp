<?php $this->layout = 'loginLayout'; ?>
<div class="login-area">
    <div class="login-box v-middle ">

        <h3>Registration</h3>
        <div class="row">
            <div class="col-md-12">
                <?php echo $this->Flash->render('admin_success'); ?>
                <?php echo $this->Flash->render('admin_error'); ?>
            </div>
        </div>
        <?php echo $this->Form->create(null, ['id' => 'user-registration-form']); ?>
        <div class="form-area">

            <input type="text" name="first_name" class="md-input" id="firstName" placeholder="First Name" required="required">
            <input type="text" name="last_name" class="md-input" id="lastName" placeholder="Last Name" required="required">
            <input type="text" name="email" class="md-input" id="email" placeholder="Email" required="required">
            <input type="password" name="password" class="md-input" id="password" placeholder="Password" required="required" >
            <input type="password" name="confirm_password" class="md-input" id="confirm_password" placeholder="Confirm Password" required="required" equalTo="#password" >
            <input type="submit" value="Registration">

        </div>
        <?php echo $this->Form->end() ?>

        <div class="login_bottom">
            <a class="registration" style="float:left" href="<?php echo $this->Url->build(array( 'controller' => 'Users','action' => 'login' )); ?>" title="Login">Login</a>
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
         $("#user-registration-form").validate({
             rules:{
                 "email": "required",
                 "password": "required"
             },
             messages:{
                 "email": "Please enter a Valid Email Address",
                 "password": "Please enter Password",
                 "confirm_password":{
                     equalTo:"Confirm Password didn't match with Password",
                     required:'Please enter Confirm Password'
                 }
             }
         });
    });
</script>
