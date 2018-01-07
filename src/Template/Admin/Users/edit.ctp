<div class="page page-forms-elements">

    <ol class="breadcrumb breadcrumb-small">
        <li><?php echo $this->Html->link('Dashboard',['controller' => 'dashboard', 'action' => 'index', '_full' => true]); ?></li>
        <li class="active"><a href="#">Edit User</a></li>
    </ol>

    <div class="page-wrap">
        <div class="row">

            <div class="col-md-12">
                <?php echo $this->Flash->render('admin_success'); ?>
                <?php echo $this->Flash->render('admin_error'); ?>
            </div>

            <?php echo $this->Form->create($user, ['class' => 'form-horizontal']); ?>


            <div class="col-sm-12 col-md-12">

                <div class="panel panel-lined panel-hovered mb20 table-responsive basic-table">
                    <div class="panel-body dataTables_wrapper no-footer">
                        <div class="clearfix left">
                            <h4>Edit User</h4>
                        </div>
                        <div class="clearfix right">
                            <button type="submit" class="btn btn-primary mr5 waves-effect">Submit</button>
                            <button class="btn btn-default waves-effect btn-cancel">Cancel</button>
                        </div>
                    </div>
                </div>

                <div class="panel panel-default panel-hovered panel-stacked mb30">
                    <div class="panel-heading">User Details</div>
                    <div class="panel-body">


                        <div class="media">
                            <div class="media-left">
                                <a href="#">
                                    <?php //echo $this->Html->image('uploads/user_images/admin.jpg', array('alt' => 'media','class' => 'media-objec')); ?>

                                </a>
                            </div>
                            <div class="media-body">
                                <div class="form-group">
                                    <label class="col-md-3 control-label">First Name</label>
                                    <div class="col-md-9">
                                        <?php echo $this->Form->input('first_name', ['class' => 'form-control', 'label' => false]); ?>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-md-3 control-label">last name</label>
                                    <div class="col-md-9">
                                        <?php echo $this->Form->input('last_name', ['class' => 'form-control', 'label' => false]); ?>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-md-3 control-label">Email</label>
                                    <div class="col-md-9">
                                        <?php echo $this->Form->input('email', ['class' => 'form-control', 'label' => false]); ?>
                                    </div>
                                </div>


                            </div>
                        </div>


                    </div>



                </div>
            </div>


            <?php echo $this->Form->end() ?>

        </div>

    </div>

</div>
