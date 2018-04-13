<div class="col-sm-6">
    <div class="form-group">
        <label class="name">Diagnosis Name<span class="required" aria-required="true"></span></label>
        <div class="inputs diagnosis_area">
            <?php echo $this->Form->input('diagnosis_list_id', ['options' => $diagnosis_list, 'default'=>(isset($diagnosi['diagnosis_list_id']))? $diagnosi['diagnosis_list_id']:'', 'empty' => 'Select', 'class'=> 'selectpicker', 'data-live-search' => true, 'label'=>false, 'onchange' => 'getDiagnosisInfo(this.value)' ]); ?>
        </div>
    </div>
</div>
<div class="col-sm-6">
    <div class="form-group">
        <label class="name">Instructions<span class="required" aria-required="true"></span></label>
        <div class="inputs">
            <?php echo $this->Form->input('instructions', ['class' => 'form-control', 'value' => $diagnosi->instructions, 'label' => false, 'required' => true, 'type' =>'text']); ?>
        </div>
    </div>
</div>
<div class="col-sm-6">
    <div class="form-group">
        <div class="inputs">
            <?php echo $this->Form->input('medicines._ids', ['options' => $medicines, 'default' => isset($default_medicines)?$default_medicines:'', 'class' => 'tokenize-sortable-demo1']); ?>
        </div>
    </div>
</div>
<div class="col-sm-6">
    <div class="form-group">
        <div class="inputs">
            <?php  echo $this->Form->input('tests._ids', ['options' => $tests, 'default' => isset($default_tests)?$default_tests:'', 'class' => 'tokenize-sortable-demo1']); ?>
        </div>
    </div>
</div>




