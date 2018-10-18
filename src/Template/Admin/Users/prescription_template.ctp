<?= $this->Form->create('', array('id' => 'prescriptionTemplateForm')) ?>
<section class="workspace">
    <div class="workspace-body">
        <div class="page-heading">
            <ol class="breadcrumb breadcrumb-small">
                <li class="active"><a href="#"><?= __('Change Prescription Template') ?></a></li>
            </ol>
        </div>

        <div class="main-container" style="height: calc(100vh - 155px);">
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
                                    <div class="panel-heading"><?= __('Select Template') ?></div>
                                    <div class="panel-body">

                                        <div id="prescription_template_area">
                                            <?php foreach ($prescription_templates as $prescription_template) { ?>
                                                <div class="col-sm-3">
                                                    <div class="prescription_template">

                                                        <h5 style="margin-top: 0px!important;">
                                                            <input id="templateRadioBtn" style="margin-right: 5px;height: 20px; width: 20px;" type="radio"
                                                                   name="prescription_template_id" value="<?php echo $prescription_template['id'] ?>"
                                                                <?php echo ($user['prescription_template_id']==$prescription_template['id'])?'checked':'' ?>>

                                                            <span style="position: absolute;top: 2px;"><?php echo $prescription_template['name'] ?></span>
                                                        </h5>

                                                        <a title="<?php echo ucfirst($prescription_template['name']) ?> Template" href="<?php echo $this->request->webroot.'uploads/prescription_templates/'.$prescription_template['image']; ?>"><img class="prescription_img" src="<?php echo $this->request->webroot.'uploads/prescription_templates/'.$prescription_template['image']; ?>" alt="" /></a>

                                                    </div>
                                                </div>
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
    </div>

</section>
<?= $this->Form->end() ?>

<script src="<?php echo $this->request->webroot.'js/lib/jquery.imageview.js'; ?>"></script>
<script>

    $(document).ready(function(){
        $(document).on('click', '#templateRadioBtn', function (e) {
            $(this).closest("#prescriptionTemplateForm").submit();
        });
    });

    $('#prescription_template_area').imageview();
</script>


