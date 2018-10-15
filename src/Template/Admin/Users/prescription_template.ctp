<?php echo $this->Form->create($user, [
    'url' => ['controller' => 'Users', 'action' => 'changeProfilePicture'],
    'class' => 'form-horizontal',
]); ?>
<section class="workspace">
    <div class="workspace-body">
        <div class="page-heading">
            <ol class="breadcrumb breadcrumb-small">
                <li><a href="<?=$this->Url->build(array('controller' => 'dashboard', 'action' => 'index' )) ?>" title="<?= __('Dashboard') ?>"> <?= __('Dashboard') ?></a></li>
                <li class="active"><a href="#"><?= __('Chance Profile Picture') ?></a></li>
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
                                    <div class="panel-heading"><?= __('Change Profile Picture') ?></div>
                                    <div class="panel-body">
                                        <h2>Prescription Template</h2>
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
            <a href="<?php echo $this->Url->build(array('controller' => 'dashboard', 'action' => 'index' )) ?>" class="btn btn-default  btn-cancel" title="Cancel">Cancel</a>
            <div class="flex-item">
                <?= $this->Form->button(__('Submit'), ['class' => 'btn save event-save']) ?>
            </div>
        </div>
    </footer>
</section>

<?= $this->Form->end() ?>

<script type="text/javascript">
    function showMyImage(fileInput) {
        $("#thumbnil").removeClass('hidden');
        var files = fileInput.files;
        for (var i = 0; i < files.length; i++) {
            var file = files[i];
            var img=document.getElementById("thumbnil");
            img.file = file;
            var reader = new FileReader();
            reader.onload = (function(aImg) {
                return function(e) {
                    aImg.src = e.target.result;
                };
            })(img);
            reader.readAsDataURL(file);
        }
    }
</script>



