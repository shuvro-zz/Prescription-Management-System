<?php $this->layout = 'loginLayout'; ?>

<!-- main-container -->
<div class="main-container clearfix">

	<!-- content-here -->
	<div class="content-container">
		<div class="page page-auth">

			<div class="auth-container">

				<div class="form-head mb20">
					<h1 class="site-logo h2 mb5 mt5 text-center text-uppercase text-bold"><a href="/">Ring Creation</a></h1>
				</div>

				<!-- Show Flash Data -->
				<?php echo $this->Flash->render('admin_success'); ?>
				<?php echo $this->Flash->render('admin_error'); ?>

				<div class="form-container">

					<?php echo $this->Form->create(null, [
							'url' => ['controller' => 'Users', 'action' => 'changePassword'],
							'class' => 'form-horizontal',
							'id' => 'admin-forgot-password-form'
					]); ?>

					<h3 class="small text-center mb20">Reset password form</h3>
					<p class="small text-center mb20">Enter your new password.</p>

					<input type="hidden" name="token" value="<?php echo $token; ?>">


					<div class="form-group">
						<label control-label">Password</label>
						<?php echo $this->Form->input('password',array('default'=>'', 'type'=>'password','class' => 'form-control', 'label' => false)); ?>
					</div>

					<div class="form-group">
						<label control-label">Confirm Password</label>
						<?php echo $this->Form->input('confirm_password',array('type'=>'password','class' => 'form-control', 'label' => false, 'equalTo'=>"#password")); ?>
					</div>


					<button type="submit" class="btn btn-primary btn-block text-uppercase btn-lg">Submit</button>

					<?php echo $this->Form->end() ?>
				</div>

			</div>
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
		$("#admin-forgot-password-form").validate({
			rules:{
				"password": "required",
				"confirm_password": "required"
			},
			messages:{
				"password": "Please enter Password",
				"confirm_password":{
					equalTo:"Confirm Password didn't match with Password",
					required:'Please enter Confirm Password'
				}
			}
		});
	});
</script>



