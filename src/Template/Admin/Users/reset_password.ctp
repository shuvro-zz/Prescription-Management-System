

<div class="page page-forms-elements">
    <ol class="breadcrumb breadcrumb-small">
        <li><?php echo $this->Html->link('Dashboard',array('controller' => 'dashboards', 'action' => 'display')); ?></li>

    <li class="active"><a href="#">Reset Password</a></li>
    </ol>
    <?php echo $this->Form->create('User',array('id' => 'reset-pass-form','class' => 'form-horizontal', 'url'=>array('action'=>'reset_password')));?>

    <?php echo $this->Form->input('user_id',array('type' => 'hidden','value' => $user_id)); ?>

    <div class="page-wrap">

        <div class="row">

            <div class="col-sm-12 col-md-12">
                <div class="panel panel-lined panel-hovered mb20 table-responsive basic-table">
                    <div class="panel-body dataTables_wrapper no-footer">
                        <div class="clearfix left">
                            <h4>Reset Password</h4>
                        </div>
                        <div class="clearfix right">
                            <button type="submit" class="btn btn-primary mr5 waves-effect">Submit</button>
                            <button class="btn btn-default waves-effect btn-cancel">Cancel</button>
                        </div>
                    </div>
                </div>
                <div class="panel panel-default panel-hovered panel-stacked mb30">
                    <div class="panel-heading">Enter Your New Password</div>
                    <div class="panel-body">

                        <div class="form-group">
                            <label class="col-md-3 control-label">Password</label>
                            <div class="col-md-9">
                                <?php echo $this->Form->input('password',array('default'=>'', 'type'=>'password','class' => 'form-control', 'label' => false)); ?>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-3 control-label">Confirm Password</label>
                            <div class="col-md-9">
                                <?php echo $this->Form->input('confirm_password',array('type'=>'password','class' => 'form-control', 'label' => false, 'equalTo'=>"#password")); ?>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

        </div>


    </div>


    </div>
    <?php echo $this->Form->end();?>

    </div>

<script type="text/javascript">
$(document).ready(function(){

    $('#UserPassword').val('');

    $("#reset-pass-form").validate({
        rules:{
            "password": "required",
            "confirm_password": "required"
        },
        messages:{
            "password": "Password must have a mimimum of 8 characters!",
            "confirm_password":{
                equalTo:"Confirm Password didn't match with Password",
                required:'Please enter Confirm Password'
            }
        }
    });

});
</script>
