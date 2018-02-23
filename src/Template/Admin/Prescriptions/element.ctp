    <?php
        echo $this->element('patient_element');

        function selected($id,$prescription_diagnosis){
            if(isset($prescription_diagnosis)){
                foreach($prescription_diagnosis as $item ){

                    if($item->diagnosis_id == $id){
                     return 'checked';
                    }
                }
            }
        }
    ?>

<div class="panel-body diagnosis_section">
    <h2>Diagnosis</h2>
    <div class="col-sm-12">
        <div class="form-row">
            <div style="height: 20px;text-align: center"><div id="loading" class="hide"> <i class="fa fa-spinner fa-spin" style="font-size:36px;"></i> </div></div>
            <div class="inputs diagnosis_info">
                <?php foreach($diagnosis as $id=>$name){ ?>
                <div class="checkbox" style="margin-top: 0px">
                    <label for="diagnosis-ids-<?php echo $id ?>"><input type="checkbox" name="diagnosis[]" value="<?php echo $id ?>" <?php echo isset($prescription_diagnosis)?selected($id, $prescription_diagnosis):'' ?> id="diagnosis-ids-<?php echo $id ?>" onclick="getDiagnosis(this)" ><?php echo $name ?></label>
                </div>
                <?php } ?>
            </div>
        </div>
    </div>

    <h2>Prescription Info</h2>
    <div class="col-sm-12">
        <div class="form-row">
            <div class="inputs medicines">
                <?php echo $this->Form->input('medicines._ids', ['options' => $medicines, 'class' => 'tokenize-sortable-demo1', 'id'=> 'prescription_medicines']); ?>
            </div>
        </div>
    </div>
    <div class="col-sm-12">
        <div class="form-row">
            <div class="inputs tests">
                <?php  echo $this->Form->input('tests._ids', ['options' => $tests,  'class' => 'tokenize-sortable-demo1']); ?>
            </div>
        </div>
    </div>

    <div class="col-sm-6">
        <div class="form-row">
            <label class="name">Temperature</label>
            <div class="inputs">
                <?php echo $this->Form->input('temperature', [ 'class'=>'form-control','label'=>false, ]);?>
            </div>
        </div>
    </div>

    <div class="col-sm-6">
        <div class="form-row">
            <label class="name">Blood Pressure</label>
            <div class="inputs">
                <?php echo $this->Form->input('blood_pressure', ['class' => 'form-control', 'label' => false, 'type' =>'text']);?>
            </div>
        </div>
    </div>

<?php
    echo'<div class="clearfix">
        <div class="col-sm-12">
            <div class="form-row">
                <label class="name">Doctor\'s Note</label>
                <div class="inputs">';
                    echo $this->Form->input('doctores_notes', ['class' => 'form-control', 'id' => 'all_instructions', 'label' => false, 'type' =>'textarea']);
                echo '</div>
            </div>
        </div>
    </div>
</div>';
    ?>



