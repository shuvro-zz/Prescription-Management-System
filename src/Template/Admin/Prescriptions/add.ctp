
<?= $this->Form->create($prescription) ?>
<section class="workspace">
    <div class="workspace-body">
        <div class="page-heading">
            <ol class="breadcrumb breadcrumb-small">
                <li><a href="<?=$this->Url->build(array('action' => 'index' )) ?>" title="<?= __('Prescription') ?>"> <?= __('Prescription') ?></a></li>
                <li class="active"><a href="#">Add <?= __('Prescription') ?></a></li>
            </ol>
        </div>

        <div class="main-container" style="background: #E08D2C">
            <div class="content" style="padding: 0px 38px">
                <div class="col-md-12">
                    <?php echo $this->Flash->render('admin_success'); ?>
                    <?php echo $this->Flash->render('admin_error'); ?>
                    <?php echo $this->Flash->render('admin_warning'); ?>
                </div>

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
                                <?php
                                if(strtolower($this->request->params['action']) == 'add'){
                                    ?>
                                    <div class="inputs hide" id='patient_field'>
                                        <?php echo $this->Form->input('patients.first_name', ['class' => 'form-control patient_name_width', 'label' => false, 'type' =>'text']); ?>
                                    </div>
                                <?php } ?><br>

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
                                    <?php echo $this->Form->input('patients.address_line1', ['class' => 'form-control reset_patient address_width',  'value' => (isset($prescription->user['address_line1']))? $prescription->user['address_line1']:'', 'id'=>'user-address', 'label' => false, 'required' => true, 'type' =>'text']); ?>
                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="patient_info_section">
                            <h6>Health Data</h6>
                            <div class="health_data single_block">
                                <label>BP:</label>
                                <input type="text" style="width: 200px"><br>

                                <label>Temperature:</label>
                                <input type="text" style="width: 144px">
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="patient_info_section">
                            <h6>Doctors Notes</h6>
                            <div class=" doctors_note">
                                <?php echo $this->Form->input('doctores_notes', ['class' => 'form-control', 'id' => 'all_instructions', 'label' => false, 'type' =>'textarea']); ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-2">
                        <div class="patient_info_section">
                            <h6>Prescriptions</h6>
                            <div class="prescriptions single_block">
                                <ul>
                                    <li> <a href="">Prescription 1</a> </li>
                                    <li> <a href="">Prescription 2</a> </li>
                                    <li> <a href="">Prescription 3</a> </li>
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

                            <div class="examination">
                                <h6>Examinations</h6>
                                <div class=" tests">
                                    <?php  echo $this->Form->input('tests._ids', ['options' => $tests, 'label' => false, 'class' => 'tokenize-sortable-demo1']); ?>
                                </div>
                            </div>
                            <div class="button_section">
                                <button>Save</button>
                                <button>Print</button>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="right_side">

                            <div class="medicine">
                                <h6>Medicines</h6>
                                <div class=" medicines">
                                    <?php echo $this->Form->input('medicines._ids', ['options' => $medicines, 'label' => false, 'class' => 'tokenize-sortable-demo1', 'id'=> 'prescription_medicines']); ?>
                                </div>
                            </div>

                            <div class="other_instruction">
                                <h6>Other Instructions</h6>
                                <textarea rows="6"></textarea>
                            </div>
                            <div class="button_section">
                                <button>Save</button>
                                <button>Print</button>
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
