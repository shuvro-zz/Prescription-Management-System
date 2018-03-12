
<?= $this->Form->create($prescription,['id' => 'prescription-form']); ?>
<section class="workspace">
    <div class="workspace-body">

        <div class="main-container" style="background: #E08D2C">
            <div class="content" style="padding: 0px 38px">

                <?php include('element.ctp'); ?>
                <input type="hidden" id="prescription-id" value="<?php echo $prescription['id']; ?>" >

            </div>
        </div>
    </div>
    
</section>
<?= $this->Form->end() ?>
