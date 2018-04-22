    <?php
        if((strtolower($this->request->params['action']) == 'edit')){
            $edit = 'disabled';
        }

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
        <div class="col-sm-3">
            <div class="patient_info_section">
                <h6>Patient Details</h6>
                <div class="patient_details single_block">

                    <label class="name" >Name<span class="required" aria-required="true"></span>
                        <?php if((strtolower($this->request->params['action']) == 'add') AND $users != ''){
                            echo '<span class="fa fa-pencil-square" id="new_patient" title="New Patient"></span>';
                        } ?>
                    </label>
                    <div class="inputs"  id='patient_drop_down' >
                        <?php
                        if(strtolower($this->request->params['action']) == 'edit'){
                            echo $this->Form->input('user_id', ['options' => $users, 'default'=>(isset($prescription->user['id']))? $prescription->user['id']:'', 'empty' => 'Select', 'required' => true, 'class'=>' selectpicker', 'data-live-search'=>true, 'label'=>false, 'onchange'=>'getUserInfo(this.value)'  ]);
                        }else{
                            if($users != ''){
                                echo $this->Form->input('user_id', ['options' => $users, 'default'=>(isset($prescription->user['id']))? $prescription->user['id']:'', 'required' => true, 'empty' => 'Select', 'class'=> 'selectpicker', 'data-live-search' => true, 'onchange'=>'getUserInfo(this.value)', 'required' => true, 'label'=>false ]);
                            }else{
                                echo $this->Form->input('patients.first_name', ['class' => 'form-control patient_name_width', 'label' => false, 'required' => true, 'type' =>'text']);
                            }
                        }
                        ?>
                    </div>

                    <div class="inputs hide" id='patient_field'>
                        <?php echo $this->Form->input('patients.first_name', ['class' => 'form-control patient_name_width', 'required' => true, 'label' => false, 'type' =>'text']); ?>
                    </div> <br>

                    <label>Mobile:</label>
                    <div class="inputs">
                        <?php echo $this->Form->input('patients.phone', ['class' => 'form-control reset_patient mobile_width', 'disabled' => isset($edit), 'value' => (isset($prescription->user['phone']))? $prescription->user['phone']:'',  'label' => false, 'required' => true, 'type' =>'text', 'id' => 'user-phone']); ?>
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
                        <?php echo $this->Form->input('blood_pressure', ['class' => 'form-control bp_width', 'value' => (isset($prescription['blood_pressure']))? $prescription['blood_pressure']:'', 'label' => false, 'id' => 'blood-pressure', 'type' =>'text']);?>
                    </div>

                    <label>Temperature:</label>
                    <div class="inputs">
                        <?php echo $this->Form->input('temperature', [ 'class'=>'form-control temp_width', 'value' => (isset($prescription['temperature']))? $prescription['temperature']:'', 'label'=>false, ]);?>
                    </div>

                    <label>Last Visit Date:</label>
                    <div class="inputs" id="last-visit-date">
                        <?php echo $last_visit_date ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-4">
            <div class="patient_info_section">
                <h6>Doctors Notes</h6>
                <div class=" doctors_note">
                    <?php echo $this->Form->input('doctores_notes', ['class' => 'form-control', 'value' => (isset($prescription['doctores_notes']))? $prescription['doctores_notes']:'', 'id' => 'all_instructions', 'label' => false, 'type' =>'textarea']); ?>
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

    <div style="height: 12px; color:#fff; text-align: center"><div id="loading" class="hide"> <i class="fa fa-spinner fa-spin" style="font-size:32px; margin-top: -5px"></i> </div></div>

    <div class="row">
        <div class="col-sm-6">
            <div class="left_side">
                <div class="diagnosis">
                    <h6>Diagnosis</h6>
                    <div class=" diagnosis_info diagnosis_box">
                        <?php foreach($diagnosis as $id=>$name){ ?>
                            <div class="checkbox" style="margin-top: 0px">
                                <label for="diagnosis-ids-<?php echo $id ?>"><input type="checkbox" name="diagnosis[]" value="<?php echo $id ?>" <?php echo isset($prescription_diagnosis)?selected($id, $prescription_diagnosis):'' ?> id="diagnosis-ids-<?php echo $id ?>" onclick="getDiagnosis(this)"  required id="test"><?php echo ucfirst($name) ?></label>
                            </div>
                        <?php } ?>
                    </div>
                </div>

                <div class="other_instruction_section">
                    <h6>Other Instructions</h6>
                    <div class="other_instruction">
                        <?php echo $this->Form->input('is_print', ['id'=> 'is-print', 'type' => 'hidden', 'value' => 0]); ?>
                        <?php echo $this->Form->input('other_instructions', [ 'class'=>'form-control', 'value' => (isset($prescription['other_instructions']))? $prescription['other_instructions']:'', 'label'=>false, 'type' =>'textarea' ]);?>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="right_side">
                <div class="medicines_section">
                    <button type="button" id="addMoreMedicine" class="add_more_btn"><span class="fa fa-plus"></span></button>
                    <h6>Medicines</h6>
                    <div class="medicines medicine_box">
                        <?php
                            echo '<div class="medicines_wrap" id="medicinesWrap">';
                                foreach($prescription_medicines as $prescription_medicine){
                                    $field_medicine = '<div class="medicines_row">';
                                    $field_medicine .= '<div class="col-sm-3 medicine_name" onmouseover="setzIndex(this)"  onmouseout="unsetzIndex(this)">';
                                    $field_medicine .= '<div class="inputs">';
                                    $field_medicine .=  $this->Form->input('medicines.medicine_id[]', ['options' => $medicines, 'default' => (isset($prescription_medicine->medicine_id))? $prescription_medicine->medicine_id:'', 'class' => 'tokenize-sortable-demo1 prescription_medicine', 'label'=>false, 'multiple'=>true]);
                                    $field_medicine .= '</div>';
                                    $field_medicine .= '</div>';

                                    $field_medicine .= '<div class="col-sm-2 medicine_rule">';
                                    $field_medicine .= '<div class="inputs">';
                                    $field_medicine .=  $this->Form->input('medicines.rule[]', ['class'=>'form-control', 'default' => (isset($prescription_medicine->rule))? $prescription_medicine->rule:'', 'placeholder'=>'0-1-0', 'label'=>false]);
                                    $field_medicine .= '</div>';
                                    $field_medicine .= '</div>';

                                    $field_medicine .=  '<div class="col-sm-1">';
                                    $field_medicine .= '<div class="inputs">';
                                    $field_medicine .= '<button type="button" id="dle_medicine_btn" class="dle_medicine_btn" onclick="removeField(this);"><span class="fa fa-minus"></span></button>';
                                    $field_medicine .= '</div>';
                                    $field_medicine .= '</div>';
                                    $field_medicine .= '</div>';

                                    if(strtolower($this->request->params['action']) == 'edit' && isset($prescription_medicine->medicine_id) ){
                                        echo  $field_medicine;
                                    }

                                }
                            echo '</div>';
                        ?>
                    </div>
                </div>

                <div class="examinations_section">
                    <h6>Examinations</h6>
                    <div class="tests examinations">
                        <?php  echo $this->Form->input('tests._ids', ['options' => $tests, 'default' => isset($default_tests)?$default_tests:'', 'label' => false, 'class' => 'tokenize-sortable-demo1 test']); ?>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <div class="row">
        <div class="prescription_button_section">
            <a href="<?php echo $this->Url->build(array('action' => 'index' )) ?>" class="btn btn-default  btn-cancel" title="Cancel">Cancel</a>
            <div class="flex-item">
                <?= $this->Form->button(__('Save'), ['class' => 'btn save event-save']) ?>
            </div>
            <div class="flex-item">
                <?= $this->Form->button(__('Save & Print'), ['class' => 'btn save event-save', 'type' => 'button', 'onclick' => 'saveAndPrint()']) ?>
            </div>
        </div>
    </div>


<script type="text/javascript">
    $(document).ready(function(){

        jQuery('#prescription-form').validate({

        });

        // Add Medicine field
        $("#addMoreMedicine").click(function(){
            $("#medicinesWrap").append('<?php echo $field_medicine ?>').find('select').last().val('');

            $('.prescription_medicine').tokenize2({
                dataSource: function(search, object){
                    $.ajax(home_url+'admin/medicines/medicine-list/'+search, {
                        dataType: 'json',
                        success: function(data){
                            object.trigger('tokenize:dropdown:fill', [data]);
                        }
                    });
                },
                sortable: true,
                displayNoResultsMessage: true,
                tokensMaxItems: 1
            });
            //$('.selectpicker').selectpicker('refresh');

        });
    });

    // Delete field
    function removeField(e){
        $(e).parents('.medicines_row').remove();
    }

    function getDiagnosis(e){
        var checkedVals = $('input:checkbox:checked').map(function() {
            return this.value;
        }).get();

        var all_id = checkedVals.join("_");

        $('.tests .tokenize-sortable-demo1').trigger('tokenize:clear');
        $('.prescription_medicine .tokenize-sortable-demo1').trigger('tokenize:clear');
        $('#all_instructions').val('');
        $('#medicinesWrap').html('');

        if(all_id!=''){
            $('#loading').removeClass('hide');

            var prescription_id = $('#prescription-id').val();
            if (typeof prescription_id == 'undefined'){
                prescription_id = 'undefined';
            }

            $.post(home_url+'admin/diagnosis/get-diagnosis/'+all_id+'/'+prescription_id ,function(response){
                $.each(response.medicines, function( index, value ) {
                    $("#medicinesWrap").append('<?php echo $field_medicine ?>');
                });


                $('.prescription_medicine').tokenize2({
                    dataSource: function(search, object){
                        $.ajax(home_url+'admin/medicines/medicine-list/'+search, {
                            dataType: 'json',
                            success: function(data){
                                object.trigger('tokenize:dropdown:fill', [data]);
                            }
                        });
                    },
                    sortable: true,
                    displayNoResultsMessage: true,
                    tokensMaxItems: 1
                });

                console.log(response);

                $( ".medicines_row" ).each(function( index, element ) {
                    $(element).closest('select').trigger('tokenize:tokens:add', [response.medicines[index].id, response.medicines[index].name, true]);
                    $(element).closest('input').val(response.medicines[index].rule);
                });

                //$('.selectpicker').selectpicker('refresh');

                $.each(response.tests, function( id, value ) {
                    $('.tests .tokenize-sortable-demo1').trigger('tokenize:tokens:add', [id, value, true]);
                });

                $('#all_instructions').val(response.all_instructions);
                $('#loading').addClass('hide');

            },'json');
        }
    }

</script>
