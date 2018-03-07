
<?= $this->Form->create($prescription,['id' => 'prescription-form']) ?>
<section class="workspace">
    <div class="workspace-body">

        <?php /*pr($this->name); die; */?>
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

</section>
<?= $this->Form->end() ?>
