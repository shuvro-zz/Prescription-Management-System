<?php $this->layout = 'loginLayout'; ?>

<!-- main-container -->
<div class="main-container clearfix">

	<!-- content-here -->
	<div class="content-container">
		<div class="page page-auth">

			<div class="auth-container">

				<div class="form-head mb20">
					<h1 class="site-logo h2 mb5 mt5 text-center text-uppercase text-bold"><a href="/">Lean Health</a></h1>
				</div>

				<div class="row">
					<div class="col-md-12">
						<?php echo $this->Flash->render('admin_success'); ?>
						<?php echo $this->Flash->render('admin_error'); ?>
					</div>
				</div>

				<div class="form-container">

					<?php echo $this->Form->create(null, [
							'url' => ['controller' => 'Users', 'action' => 'forgotPassword'],
							'class' => 'form-horizontal',
							'id' => 'admin-forgot-password-form'
					]); ?>

					<p class="small text-center mb20">Enter your email address you've registered with you. We'll send you reset link to that address.</p>
					<div class="md-input-container md-float-label">
						<input type="email" name="email"  class="md-input">
						<label>Email Address</label>
					</div>

					<button type="submit" class="btn btn-primary btn-block text-uppercase btn-lg">Submit</button>

					<div class="clearfix mb15" style="margin-top: 10px;">
						<?php echo $this->Html->link(
							'Back to login',
							'/admin'
						); ?>
					</div>

					<?php echo $this->Form->end() ?>
				</div>

			</div>
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




