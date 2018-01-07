<div class="container">

    <div class="col-md-12 margin-top-20">
        <?php echo $this->Flash->render('admin_success'); ?>
        <?php echo $this->Flash->render('admin_error'); ?>
    </div>

    <div class="panel panel-info margin-top-70">
        <div class="panel-heading">
            <h3 class="panel-title">Change Password</h3>
        </div>
        <div class="panel-body">

            <?php echo $this->Form->create('Users',array('id'=>'change-password-form','novalidate'=>true)); ?>

            <div class="form-group">
                <label control-label">Password</label>
                <?php echo $this->Form->input('password',array('default'=>'', 'type'=>'password','class' => 'form-control', 'label' => false)); ?>
            </div>

            <div class="form-group">
                <label control-label">Confirm Password</label>
                <?php echo $this->Form->input('confirm_password',array('type'=>'password','class' => 'form-control', 'label' => false, 'equalTo'=>"#password")); ?>
            </div>


            <button type="submit" class="btn btn-default">Submit</button>

            <?php echo $this->Form->end(); ?>

        </div>
    </div>
</div>

<style>
    .margin-top-20{
        margin-top: 20px;
    }
</style>

<script type="text/javascript">
    $(document).ready(function(){
        $("#change-password-form").validate({
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