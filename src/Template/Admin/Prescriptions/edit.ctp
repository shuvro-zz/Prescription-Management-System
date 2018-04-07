
<?= $this->Form->create('',['id' => 'prescription-form']); ?>
<section class="workspace work_section">
    <div class="workspace-body work_body_section">

        <div class="main-container main_container_section">
            <div class="content prescription_content">
                <?php include('element.ctp'); ?>
                <input type="hidden" id="prescription-id" value="<?php echo $prescription['id']; ?>" >
            </div>
        </div>
    </div>
    
</section>
<?= $this->Form->end() ?>
