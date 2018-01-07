<div class="container login-page">
    <div class="row">
        <div class="col-sm-12">
            <?php echo $this->Flash->render('admin_success'); ?>
            <?php echo $this->Flash->render('admin_error'); ?>
        </div>
    </div>

    <h1 class="text-uppercase">Login or Create an Account</h1>

    <?php echo $this->Form->create('Users',array('id'=>'UserLoginForm', 'class'=>'login-form','novalidate'=>true)); ?>
    <div class="row">
        <div class="col-sm-6 new-users">
            <header>
                <h2>New Customers</h2>
            </header>

            <div class="boxed">
                <p>By creating an account with our store, you will be able to move through the checkout process faster, store multiple shipping addresses, view and track your orders in your account and more.</p>
            </div>

            <footer>
                <a class="btn" href="<?php echo $this->Url->build('/signup',true);?>">Create an Account</a>
            </footer>

        </div>

        <div class="col-sm-6 registered-users">
            <header>
                <h2>Registered Customers</h2>
            </header>

            <div class="boxed">
                <p>If you have an account with us, please log in.</p>
                <div class="form-list">
                    <div class="form-group">
                        <label for="Email Address" class="control-label">Email Address <em>*</em></label>
                        <?php echo $this->Form->input('email',array('label'=>false,'type'=>'email','required'=>true, 'div'=>false, 'class'=>'form-control', 'id'=>'field-email', 'label'=>false));?>
                    </div>

                    <div class="form-group">
                        <label for="Email Address" class="control-label">Password <em>*</em></label>
                        <?php echo $this->Form->input('password',array('div'=>'false','class'=>'form-control','label'=>false,'required'=>true));?>
                    </div>
                </div>
            </div>

            <footer>
                <a class="pull-left" href="<?php echo $this->Url->build('/forgot-password',true);?>">Forgot Your Password?</a>
                <button type="submit" class="btn pull-right" title="Login" name="send" id="send2">Login</button>
            </footer>

        </div>
    </div>
    <?php echo $this->Form->end(); ?>
</div>

<script type="text/javascript">
    $(document).ready(function(){

        $("#UserLoginForm").validate({
            rules:{
                "password": "required",
                "email": {
                    required: true,
                    email: true
                }
            },
            messages:{
                "email": "Please enter your Email",
                "password": "Please enter your Password"
            }
        });

    });
</script>
