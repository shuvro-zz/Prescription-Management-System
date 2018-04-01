
<?= $this->Form->create('tests', ['type' => 'file', 'id' => 'testForm']); ?>
<section class="workspace">
    <div class="workspace-body">
        <div class="page-heading">
            <ol class="breadcrumb breadcrumb-small">
                <li><a href="<?=$this->Url->build(array('action' => 'index' )) ?>" title="<?= __('Tests') ?>"> <?= __('Tests') ?></a></li>
                <li class="active"><a href="#">Import <?= __('Tests') ?></a></li>
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
                                    <div class="panel-heading"><?= __('Import Tests') ?></div>
                                    <div class="panel-body">
                                        <div class="col-sm-6">
                                            <div class="form-row">
                                                <label class="name">File<span class="required" aria-required="true"></span></label>
                                                <div class="inputs">
                                                    <?php echo $this->Form->input('csv_file', ['class' => '', 'id' => 'test_file', 'label' => false, 'required' => true, 'type' =>'file']); ?>
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
        </div>
    </div>

    <footer class="footer ">
        <div class="flex-container">
            <a href="<?php echo $this->Url->build(array('action' => 'index' )) ?>" class="btn btn-default  btn-cancel" title="Cancel">Cancel</a>
            <div class="flex-item">
                <?= $this->Form->button(__('Submit'), ['class' => 'btn save event-save']) ?>
            </div>
        </div>
    </footer>

</section>
<?= $this->Form->end() ?>
