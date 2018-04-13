
<div class="col-sm-6">
    <div class="form-row">
        <label class="name">Name<span class="required" aria-required="true"></span></label>
        <div class="inputs">
            <?php echo $this->Form->input('name', ['class' => 'form-control', 'value' => $diagnosis->name, 'label' => false, 'id' => 'diagnosisName', 'required' => true, 'type' =>'text']); ?>
        </div>
    </div>
</div>
