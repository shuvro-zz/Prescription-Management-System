
<?= $this->Form->create($prescription,['id' => 'prescription-form']) ?>
<section class="workspace">
    <div class="workspace-body">
        <div class="page-heading">
            <ol class="breadcrumb breadcrumb-small">
                <li><a href="<?=$this->Url->build(array('action' => 'index' )) ?>" title="<?= __('Prescription') ?>"> <?= __('Prescription') ?></a></li>
                <li class="active"><a href="#">Add <?= __('Prescription') ?></a></li>
            </ol>
        </div>

        <div class="main-container" style="background: #E08D2C">
            <div class="content" style="padding: 0px 38px">
                <div class="col-md-12">
                    <?php echo $this->Flash->render('admin_success'); ?>
                    <?php echo $this->Flash->render('admin_error'); ?>
                    <?php echo $this->Flash->render('admin_warning'); ?>
                </div>

                <?php include('element.ctp'); ?>

            </div>
        </div>
    </div>

    <footer class="footer ">
        <div class="flex-container">
            <a href="<?php echo $this->Url->build(array('action' => 'index' )) ?>" class="btn btn-default  btn-cancel" title="Cancel">Cancel</a>
            <div class="flex-item">
                <?= $this->Form->button(__('Save'), ['class' => 'btn save event-save']) ?>
            </div>
            <div class="flex-item">
                <?= $this->Form->button(__('Save & Print'), ['class' => 'btn save event-save', 'type' => 'button', 'onclick' => 'saveAndPrint()']) ?>
            </div>
        </div>
    </footer>

</section>
<?= $this->Form->end() ?>
