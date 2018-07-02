
<?= $this->Form->create('',['id' => 'prescription-form']); ?>
<section class="workspace work_section">
    <div class="workspace-body work_body_section">

        <div class="page-heading">
            <ol class="breadcrumb breadcrumb-small">
                <li><a href="<?=$this->Url->build(array('action' => 'index' )) ?>" title="<?= __('Prescription') ?>">  <?= __('Prescription') ?></a></li>
                <li class="active"><a href="#">Edit <?= __('Prescription') ?></a></li>
            </ol>
        </div>

        <div class="main-container main_container_section">
            <div class="content prescription_content">
                <div class="page-wrap">
                    <div class="col-sm-12 col-md-12">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="panel panel-default panel-hovered panel-stacked">
                                    <div class="panel-heading add_prescription_heading"><?= __('Edit Prescription') ?></div>
                                    <div class="panel-body">
                                        <?php include('element.ctp'); ?>
                                        <input type="hidden" id="prescription-id" value="<?php echo $prescription['id']; ?>" >
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
