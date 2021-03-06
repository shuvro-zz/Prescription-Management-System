
<?= $this->Form->create($prescription,['id' => 'prescription-form']) ?>
<section class="workspace work_section">
    <div class="workspace-body work_body_section">
        <div class="main_container_section">
            <div class="content prescription_content">
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
                                    <div class="panel-body prescription_body">
                                        <?php include('element.ctp'); ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</section>
<?= $this->Form->end() ?>
