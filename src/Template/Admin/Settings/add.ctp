<?php $settings = $setting->toArray() ?>
<?= $this->Form->create() ?>
<section class="workspace">
    <div class="workspace-body">
        <div class="page-heading">
            <ol class="breadcrumb breadcrumb-small">
                <li><a href="<?=$this->Url->build(['controller' =>'dashboard', 'action' => 'index' ]) ?>" title="Dashboard">Dashboard</a></li>
                <li class="active"><a href="#">Update</a></li>
            </ol>
        </div>

        <div class="main-container">
            <div class="content">

                <div class="col-md-12">
                    <?php echo $this->Flash->render('admin_success'); ?>
                    <?php echo $this->Flash->render('admin_error'); ?>
                    <?php echo $this->Flash->render('admin_warning'); ?>
                </div>

                <div class="page-wrap">
                    <div class="col-sm-12 col-md-12">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="panel panel-default panel-hovered panel-stacked">
                                    <div class="panel-heading">Update Setting</div>
                                    <div class="panel-body">
                                        <?php foreach($settings as $key=>$val){ ?>
                                            <?php if($val['key_name'] == 'mode'){ ?>
                                                <div class="col-sm-6">
                                                    <div class="form-row">
                                                        <label class="name">Site Mode<span class="required" aria-required="true"></span></label>
                                                        <div class="inputs">
                                                            <select name="mode" class="form-control" required="required">
                                                                <option value="live" <?php if($val['value'] == 'live'){ echo 'selected'; } ?> >Live</option>
                                                                <option value="dev" <?php if($val['value'] == 'dev'){ echo 'selected'; } ?>>Dev</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            <?php } ?>

                                            <?php if($val['key_name'] == 'site_name'){ ?>
                                                <div class="col-sm-6">
                                                    <div class="form-row">
                                                        <label class="name">Site Name<span class="required" aria-required="true"></span></label>
                                                        <div class="inputs">
                                                            <input name="site_name" type="text" class="form-control" value="<?php echo $val['value']; ?>" required="required">
                                                        </div>
                                                    </div>
                                                </div>
                                            <?php } ?>

                                            <?php if($val['key_name'] == 'site_email'){ ?>
                                                 <div class="col-sm-6">
                                                    <div class="form-row">
                                                        <label class="name">Site Email<span class="required" aria-required="true"></span></label>
                                                        <div class="inputs">
                                                            <input name="site_email" type="text" class="form-control" value="<?php echo $val['value'] ?>" required="required">
                                                        </div>
                                                    </div>
                                                 </div>
                                            <?php } ?>
                                        <?php } ?>
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
            <a href="<?php echo $this->Url->build(['controller' =>'dashboard', 'action' => 'index' ]) ?>" class="btn btn-default  btn-cancel" >Cancel</a>
            <div class="flex-item">
                <?= $this->Form->button(__('Update'), ['class' => 'btn save event-save']) ?>
            </div>
        </div>
    </footer>
    
</section>
<?= $this->Form->end() ?>
