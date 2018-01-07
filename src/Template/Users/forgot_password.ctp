<div class="container forgot-password">
    <div class="row">
        <div class="col-sm-12">
            <?php echo $this->Flash->render('admin_success'); ?>
            <?php echo $this->Flash->render('admin_error'); ?>
        </div>
    </div>

    <h1 class="text-uppercase">Forgot Your Password?</h1>

    <div class="forgot-password-form">
        <?php echo $this->Form->create('Users',array('id'=>'forgot-password-form','novalidate'=>true)); ?>
        <div class="inner">
            <fieldset>
                <legend>Retrieve your password here</legend>
            </fieldset>

            <fieldset class="form-group">Please enter your email address below. You will receive a link to reset your password.</fieldset>

            <fieldset class="form-group">
                <label for="exampleInputEmail1" class="control-label">Email Address <em>*</em></label>
                <?php echo $this->Form->input('email',array('label'=>false,'type'=>'email','required'=>true, 'div'=>false, 'class'=>'form-control', 'id'=>'field-email', 'label'=>false));?>

            </fieldset>
        </div>
        <footer>
            <div class="buttons-wrapper">
                <button type="submit" title="Submit" class="btn pull-left">Submit</button>
                <a class="back-link pull-right" href="<?php echo $this->Url->build('/login',true);?>">Back to Login</a>
            </div>
        </footer>

        <?php echo $this->Form->end(); ?>
    </div>

</div>


<script type="text/javascript">
    $(document).ready(function(){

        $("#forgot-password-form").validate({
            rules:{
                "email": {
                    required: true,
                    email: true
                }
            },
            messages:{
                "email": "Please enter your Valid Email",
            }
        });

    });
</script>
