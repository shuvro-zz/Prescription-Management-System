<?php $this->layout = 'loginLayout'; ?>

<div class="login-area">
    <div class="login-box v-middle ">

        <h3>Forgot Password</h3>
        <div class="row">
            <div class="col-md-12">
                <?php echo $this->Flash->render('admin_success'); ?>
                <?php echo $this->Flash->render('admin_error'); ?>
            </div>
        </div>
        <?php echo $this->Form->create(null, [
            'url' => ['controller' => 'Users', 'action' => 'forgotPassword'],
            'class' => 'form-horizontal',
            'id' => 'admin-forgot-password-form'
        ]); ?>
            <div class="form-area">
                <input type="email" name="email"  class="md-input" placeholder="Email Address">
                <input type="submit" value="Submit">
            </div>
        <?php echo $this->Form->end() ?>

        <div class="login_bottom">
            <a class="registration" style="float:left" href="<?php echo $this->Url->build(array( 'controller' => 'users','action' => 'registration' )); ?>" title="Registration">Registration</a>
            <a class="reset_password" style="float:right" href="<?php echo $this->Url->build(array( 'controller' => 'users','action' => 'login' )); ?>" title="Login">Login</a>

        </div>
    </div>
</div>


<script type="text/javascript">
	$(document).ready(function(){
		$("#admin-forgot-password-form").validate({
			rules:{
				"email": "required"
			},
			messages:{
				"email": "Please enter a Valid Email Address"
			}
		});
	});
</script>




