<?= $this->Form->create($user) ?>
<section class="workspace">
    <div class="workspace-body">
        <div class="page-heading">
            <ol class="breadcrumb breadcrumb-small">
                <li><a href="<?=$this->Url->build(array('action' => 'index' )) ?>" title="<?= __('Doctor') ?>"> <?= __('Doctor') ?></a></li>
                <li class="active"><a href="#"><?= __('Chance Password') ?></a></li>
            </ol>
        </div>
        <div class="main-container">
            <div class="content">
                <div class="page-wrap">
                    <div class="col-sm-12 col-md-12">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="panel panel-default panel-hovered panel-stacked">
                                    <div class="panel-heading"><?= __('Change Password') ?></div>
                                    <div class="panel-body">

                                        <?php echo $this->Form->create(null, [
                                                'url' => ['controller' => 'Users', 'action' => 'changePassword'],
                                                'class' => 'form-horizontal',
                                                'id' => 'admin-forgot-password-form'
                                        ]); ?>

                                        <h3 class="text-center mb20">Change password form</h3>
                                        <p class="text-center mb20">Enter your new password.</p>

                                        <input type="hidden" name="token" value="<?php echo $token; ?>">


                                        <div class="form-group">
                                            <label control-label">Password</label>
                                            <?php echo $this->Form->input('password',array('default'=>'', 'type'=>'password','class' => 'form-control', 'label' => false)); ?>
                                        </div>

                                        <div class="form-group">
                                            <label control-label">Confirm Password</label>
                                            <?php echo $this->Form->input('confirm_password',array('type'=>'password','class' => 'form-control', 'label' => false, 'equalTo'=>"#password")); ?>
                                            <?php echo $this->Form->input('token',array('type'=>'hidden', 'label' => false)); ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <footer class="footer ">
        <div class="flex-container">
            <a href="<?php echo $this->Url->build(array('action' => 'index' )) ?>" class="btn btn-default  btn-cancel" title="Cancel">Cancel</a>
            <div class="flex-item">
                <?= $this->Form->button(__('Submit'), ['class' => 'btn save event-save']) ?>
            </div>
        </div>
    </footer>
</section>

<?= $this->Form->end() ?>

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



