<?php use \Cake\Core\Configure; ?>
<div class="login-area">
	<div class="login-box v-middle ">

		<h3>Login</h3>
		<div class="row">
			<div class="col-md-12">
				<?php echo $this->Flash->render('admin_success'); ?>
				<?php echo $this->Flash->render('admin_error'); ?>
			</div>
		</div>
		<?php echo $this->Form->create(null, ['id' => 'admin-login-form']); ?>
		<div class="form-area">
			<input type="text" name="email" class="md-input" id="email" placeholder="Email Address" required="required">
			<input type="password" name="password" class="md-input" id="password" placeholder="Password" required="required" >
			<input type="submit" value="Login">
			
		</div>

		<div class="remeber-box flex-container">
			<!--<label for="log-rem"><input id="log-rem" type="checkbox" name="remember_me"> Remember Me</label>-->
			<!--<div class="forget"><a href="<?php /*echo $this->Url->build(array( 'controller' => 'users','action' => 'forgotPassword','prefix'=>false));*/?>">Forgot Password ?</a></div>-->
		</div>
		<?php echo $this->Form->end() ?>

        <div class="login_bottom">
            <a class="registration" style="float:left" href="<?php echo $this->Url->build(array( 'controller' => 'users','action' => 'registration' )); ?>" title="Registration">Registration</a>
            <?php if (Configure::read('email_send_allow')) { ?>
                <a class="reset_password" style="float:right" href="<?php echo $this->Url->build(array( 'controller' => 'users','action' => 'forgotPassword' )); ?>" title="Reset Password">Forgot Password</a>
            <?php } ?>
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
		$("#admin-login-form").validate({
			rules:{
				"email": "required",
				"password": "required"
			},
			messages:{
				"email": "Please enter a Valid Email Address",
				"password": "Please enter a Password"
			}
		});
	});
</script>