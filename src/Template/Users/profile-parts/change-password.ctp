<?php echo $this->Form->create('User', ['url' => ['action' => 'userPasswordChange'],'novalidate'=>'true', 'id'=>'user-password-chnage-form']); ?>

    <header>
        <h2>Chnage Password</h2>
    </header>

    <div class="form-inner-content">
        <div class="row">
            <div class="col-sm-12">

                <div class="form-group">
                    <label for="exampleInputPassword1">Present Password<em>*</em></label>
                    <?php echo $this->Form->input('current_password',array('type'=>'password','div'=>'false','class'=>'form-control','label'=>false,'required'=>true));?>
                </div>

                <div class="form-group">
                    <label for="exampleInputPassword1">Password<em>*</em><small class="pull-right">Minimum Length 8</small></label>
                    <?php echo $this->Form->input('new_password',array('type'=>'password','div'=>'false','class'=>'form-control','label'=>false,'required'=>true,'minlength'=>8));?>
                </div>

                <div class="form-group">
                    <label for="exampleInputPassword1">Confirm Password<em>*</em></label>
                    <?php echo $this->Form->input('confirm_password',array('type'=>'password','div'=>'false','class'=>'form-control','label'=>false,'required'=>true,'minlength'=>8, 'equalTo'=>"#new-password"));?>
                </div>

            </div>
        </div>
    </div>

    <footer>
        <button type="submit" class="button">Submit</button>
    </footer>

<?php echo $this->Form->end(); ?>

<script type="text/javascript">
    $(document).ready(function(){

        countryAutocomplete();

        $("#user-password-chnage-form").validate({
            rules:{

            },
            messages:{
                "current_password": "Please enter your Current Password",
                "password": "Please enter your New Password",
                "confirm_password":{
                    equalTo:"Confirm Password didn't match with Password",
                    required:'This field is required'
                }
            }

        });

    });
</script>

