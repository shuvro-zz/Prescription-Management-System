<div class="col-sm-6">
    <div class="form-group">
        <label class="name">Diagnosis Name<span class="required" aria-required="true"></span></label>
        <div class="inputs diagnosis_area">
            <?php echo $this->Form->input('diagnosis_list_id', ['options' => $diagnosis_list, 'default'=>(isset($diagnosi['diagnosis_list_id']))? $diagnosi['diagnosis_list_id']:'', 'class'=> 'tokenize-sortable-demo1 diagnosis_list',  'label'=>false, 'multiple'=>true ]); ?>
        </div>
    </div>
</div>
<div class="col-sm-6">
    <div class="form-group">
        <label class="name">Instructions<span class="" aria-required="true"></span></label>
        <div class="inputs">
            <?php echo $this->Form->input('instructions', ['class' => 'form-control', 'value' => $diagnosi->instructions, 'label' => false, 'type' =>'text']); ?>
        </div>
    </div>
</div>
<div class="col-sm-6">
    <div class="form-group">
        <div class="inputs">
            <?php echo $this->Form->input('medicines._ids', ['options' => $medicines, 'default' => isset($default_medicines)?$default_medicines:'', 'class' => 'tokenize-sortable-demo1 medicine']); ?>
        </div>
    </div>
</div>
<div class="col-sm-6">
    <div class="form-group">
        <div class="inputs">
            <?php  echo $this->Form->input('tests._ids', ['options' => $tests, 'default' => isset($default_tests)?$default_tests:'', 'class' => 'tokenize-sortable-demo1 test']); ?>
        </div>
    </div>
</div>
