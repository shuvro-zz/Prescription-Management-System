    <?php
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

    <div class="row">
        <div class="col-sm-4">
            <div class="patient_info_section">
                <h6>Patient Details</h6>
                <div class="patient_details single_block">

                    <label class="name" >Name<span class="required" aria-required="true"></span>
                        <?php if(strtolower($this->request->params['action']) == 'add'){
                            echo '<span class="fa fa-pencil-square" id="new_patient" title="New Patient"></span>';
                        } ?>
                    </label>
                    <div class="inputs"  id='patient_drop_down' >
                        <?php
                        if(strtolower($this->request->params['action']) == 'edit'){
                            echo $this->Form->input('user_id', ['options' => $users, 'empty' => 'Select',  'class'=>' selectpicker', 'data-live-search'=>true, 'label'=>false, 'required'=>true,'onchange'=>'getUserInfo(this.value)'  ]);
                        }else{
                            echo $this->Form->input('user_id', ['options' => $users, 'default'=>(isset($prescription->user['id']))? $prescription->user['id']:'', 'empty' => 'Select', 'class'=>' selectpicker', 'data-live-search'=>true,'onchange'=>'getUserInfo(this.value)','label'=>false,  ]);
                        }
                        ?>
                    </div>

                    <div class="inputs hide" id='patient_field'>
                        <?php echo $this->Form->input('patients.first_name', ['class' => 'form-control patient_name_width', 'label' => false, 'type' =>'text']); ?>
                    </div> <br>

                    <label>Mobile:</label>
                    <div class="inputs">
                        <?php echo $this->Form->input('patients.phone', ['class' => 'form-control reset_patient mobile_width',  'value' => (isset($prescription->user['phone']))? $prescription->user['phone']:'',  'label' => false, 'required' => true, 'type' =>'text', 'id' => 'user-phone']); ?>
                    </div><br>

                    <label>Age:</label>
                    <div class="inputs">
                        <?php echo $this->Form->input('patients.age', ['class' => 'form-control reset_patient age_width',  'value' => (isset($prescription->user['age']))? $prescription->user['age']:'', 'label' => false, 'type' =>'text', 'id'=>'user-age']); ?>
                    </div>

                    <label>Address:</label>
                    <div class="inputs">
                        <?php echo $this->Form->input('patients.address_line1', ['class' => 'form-control reset_patient address_width',  'value' => (isset($prescription->user['address_line1']))? $prescription->user['address_line1']:'', 'id'=>'user-address', 'label' => false, 'type' =>'text']); ?>
                    </div>

                </div>
            </div>
        </div>
        <div class="col-sm-3">
            <div class="patient_info_section">
                <h6>Health Data</h6>
                <div class="health_data single_block">
                    <label>BP:</label>
                    <div class="inputs">
                        <?php echo $this->Form->input('blood_pressure', ['class' => 'form-control bp_width', 'label' => false, 'type' =>'text']);?>
                    </div>

                    <label>Temperature:</label>
                    <div class="inputs">
                        <?php echo $this->Form->input('temperature', [ 'class'=>'form-control temp_width','label'=>false, ]);?>
                    </div>

                    <label>Last Visit Date:</label>
                    <div class="inputs" id="last-visit-date">
                        <?php echo $last_visit_date ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-3">
            <div class="patient_info_section">
                <h6>Doctors Notes</h6>
                <div class=" doctors_note">
                    <?php echo $this->Form->input('doctores_notes', ['class' => 'form-control ', 'id' => 'all_instructions', 'label' => false, 'type' =>'textarea']); ?>
                </div>
            </div>
        </div>
        <div class="col-sm-2">
            <div class="patient_info_section">
                <h6>Prescriptions</h6>
                <div class="prescriptions single_block ">
                    <ul id="prescriptions-link" class="reset_prescriptions">
                        <?php echo $prescriptions_link ?>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-6">
            <div class="left_side">
                <div class="diagnosis">
                    <h6>Diagnosis</h6>
                    <div class=" diagnosis_info">
                        <?php foreach($diagnosis as $id=>$name){ ?>
                            <div class="checkbox" style="margin-top: 0px">
                                <label for="diagnosis-ids-<?php echo $id ?>"><input type="checkbox" name="diagnosis[]" value="<?php echo $id ?>" <?php echo isset($prescription_diagnosis)?selected($id, $prescription_diagnosis):'' ?> id="diagnosis-ids-<?php echo $id ?>" onclick="getDiagnosis(this)" ><?php echo $name ?></label>
                            </div>
                        <?php } ?>
                    </div>
                </div>

                <div class="examinations_section">
                    <h6>Examinations</h6>
                    <div class="tests examinations">
                        <?php  echo $this->Form->input('tests._ids', ['options' => $tests, 'label' => false, 'class' => 'tokenize-sortable-demo1']); ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="right_side">

                <div class="medicines_section">
                    <h6>Medicines</h6>
                    <div class=" medicines">
                        <?php echo $this->Form->input('medicines._ids', ['options' => $medicines, 'label' => false, 'class' => 'tokenize-sortable-demo1', 'id'=> 'prescription_medicines']); ?>
                    </div>
                </div>

                <div class="other_instruction_section">
                    <h6>Other Instructions</h6>
                    <div class="other_instruction">
                        <?php echo $this->Form->input('is_print', ['id'=> 'is-print', 'type' => 'hidden', 'value' => 0]); ?>
                        <?php echo $this->Form->input('other_instructions', [ 'class'=>'form-control','label'=>false, 'type' =>'textarea' ]);?>
                    </div>
                </div>
            </div>
        </div>
    </div>



