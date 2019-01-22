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
        <div class="col-sm-4">
            <div class="patient_info_section">
                <h6>Patient Details</h6>
                <div class="patient_details single_block">

                    <div class="row">
                        <div class="col-sm-2" style="padding-right: 0px">
                            <label class="name">Name:
                                <?php if ((strtolower($this->request->params['action']) == 'add') AND $users != '') {
                                    echo '<span class="fa fa-pencil-square" id="new_patient" title="New Patient"></span>';
                                } ?>
                            </label>
                        </div>

                        <div class="col-sm-10" >
                            <div class="inputs" id='patient_drop_down'>
                                <?php
                                if (strtolower($this->request->params['action']) == 'edit') {
                                    echo $this->Form->input('user_id', ['options' => $users, 'default' => (isset($prescription->user['id'])) ? $prescription->user['id'] : '', 'empty' => 'Select', 'required' => true, 'class' => ' selectpicker', 'data-live-search' => true, 'label' => false, 'onchange' => 'getUserInfo(this.value)']);
                                } else {
                                    if ($users != '') {
                                        echo $this->Form->input('user_id', ['options' => $users, 'default' => (isset($prescription->user['id'])) ? $prescription->user['id'] : '', 'required' => true, 'empty' => 'Select', 'class' => 'selectpicker', 'data-live-search' => true, 'onchange' => 'getUserInfo(this.value)', 'required' => true, 'label' => false]);
                                    } else {
                                        echo $this->Form->input('patients.first_name', ['class' => 'form-control patient_name_width', 'label' => false, 'required' => true, 'type' => 'text']);
                                    }
                                }
                                ?>
                            </div>

                            <div class="inputs hide" id='patient_field'>
                                <?php echo $this->Form->input('patients.first_name', ['class' => 'form-control patient_name_width', 'required' => true, 'label' => false, 'type' => 'text']); ?>
                            </div>
                            <br>
                        </div>
                    </div>


                    <div class="row">
                        <div class="col-sm-2">
                            <label>Mobile:</label>
                        </div>
                        <div class="col-sm-10">
                            <div class="inputs">
                                <?php echo $this->Form->input('patients.phone', ['class' => 'form-control reset_patient mobile_width', 'disabled' => isset($edit), 'value' => (isset($prescription->user['phone']))? $prescription->user['phone']:'',  'label' => false, 'required' => true, 'type' =>'text', 'id' => 'user-phone']); ?>
                            </div><br>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-2">
                            <label>Address:</label>
                        </div>
                        <div class="col-sm-10">
                            <div class="inputs">
                                <?php echo $this->Form->input('patients.address_line1', ['class' => 'form-control reset_patient address_width',  'value' => (isset($prescription->user['address_line1']))? $prescription->user['address_line1']:'', 'id'=>'user-address', 'label' => false, 'type' =>'text']); ?>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-2">
                            <label style="margin-bottom: 0px">Age:</label>
                        </div>

                        <div class="col-sm-10">
                            <div class="inputs age_width">
                                <?php echo $this->Form->input('patients.age', ['class' => 'form-control reset_patient ',  'value' => (isset($prescription->user['age']))? $prescription->user['age']:'', 'label' => false, 'type' =>'text', 'id'=>'user-age']); ?>
                            </div>
                        </div>
                    </div>


                </div>
            </div>
        </div>

        <div class="col-sm-2">
            <div class="patient_info_section">
                <h6>Health Data</h6>
                <div class="health_data single_block">

                    <div class="row">
                        <div class="col-sm-5 padding_right_remove">
                            <label>BP:</label>
                        </div>
                        <div class="col-sm-7 padding_left_remove">
                            <div class="inputs bp_width">
                                <?php echo $this->Form->input('blood_pressure', ['class' => 'form-control ', 'value' => (isset($prescription['blood_pressure']))? $prescription['blood_pressure']:'', 'label' => false, 'id' => 'blood-pressure', 'type' =>'text']);?>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-5 padding_right_remove">
                            <label>Temperature:</label>
                        </div>
                        <div class="col-sm-7 padding_left_remove">
                            <div class="inputs temp_width">
                                <?php echo $this->Form->input('temperature', [ 'class'=>'form-control ', 'value' => (isset($prescription['temperature']))? $prescription['temperature']:'', 'label'=>false, ]);?>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-6 last_visit_date_level">
                            <label>Weight:</label>
                        </div>

                        <div class="col-sm-6 padding_right_remove">
                            <div class="inputs" id="weight">
                                <?php echo $this->Form->input('patients.weight', ['class' => 'form-control reset_patient ', 'value' => (isset($prescription->user['weight']))? $prescription->user['weight']:'', 'label' => false, 'type' =>'text', 'id'=>'user-weight']); ?>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-6 last_visit_date_level">
                            <label>Last Visit Date:</label>
                        </div>

                        <div class="col-sm-6 last_visit_date">
                            <div class="inputs " id="last-visit-date">
                                <?php echo $last_visit_date ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-4">
            <div class="patient_info_section">
                <h6>Doctors Notes</h6>
                <div class=" doctors_note single_block">
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

    <div style="height: 6px; color:#000; text-align: center"><div id="loading" class="hide"> <i class="fa fa-spinner fa-spin" style="font-size:32px; margin-top: -5px"></i> </div></div>

    <div class="row">
        <div class="col-sm-6">
            <div class="left_side">
                <div class="diagnosis">
                    <button type="button" id="addMoreDiagnosis" class="add_more_btn"><span class="fa fa-plus"></span></button>
                    <div class="panel-heading pescription_panel_heading">Diagnosis</div>
                    <div class="diagnosis_info diagnosis_box">
                        <?php foreach($diagnosis as $id=>$name){ ?>
                            <div class="checkbox" style="margin-top: 0px">
                                <label for="diagnosis-ids-<?php echo $id ?>"><input type="checkbox" name="diagnosis[]" value="<?php echo $id ?>" <?php echo isset($prescription_diagnosis)?selected($id, $prescription_diagnosis):'' ?> id="diagnosis-ids-<?php echo $id ?>" onclick="getDiagnosis(this)" id="test"><?php echo ucfirst($name) ?></label>
                            </div>
                        <?php } ?>

                        <div id="diagnosisWrap">

                            <?php
                                $new_diagnosis = '<div class="col-sm-4 new_diagnosis_row padding_remove">';
                                    $new_diagnosis .= '<div class="col-sm-10 padding_remove">';
                                        $new_diagnosis .= $this->Form->input('new_diagnosis[]', [ 'class'=>'form-control new_diagnosis_name', 'label'=>false, ]);
                                    $new_diagnosis .= '</div>';

                                    $new_diagnosis .= '<div class="col-sm-2">';
                                        $new_diagnosis .= '<button type="button"  class="dle_diagnosis_btn" onclick="removeDiagnosisField(this);"><span class="fa fa-minus"></span></button>';
                                    $new_diagnosis .= '</div>';
                                $new_diagnosis .= '</div>';
                            ?>

                        </div>

                    </div>
                </div>

                <div class="examinations_section">
                    <div class="panel-heading pescription_panel_heading">Examinations</div>
                    <div class="tests examinations">
                        <?php  echo $this->Form->input('tests._ids', ['options' => $tests, 'default' => isset($default_tests)?$default_tests:'', 'label' => false, 'class' => 'tokenize-sortable-demo1 test']); ?>
                    </div>
                </div>

            </div>
        </div>
        <div class="col-sm-6">
            <div class="right_side">
                <div class="medicines_section">
                    <button type="button" id="addMoreMedicine" class="add_more_btn"><span class="fa fa-plus"></span></button>
                    <div class="panel-heading pescription_panel_heading">Medicines</div>
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
                                    $field_medicine .= '<button type="button"  class="dle_medicine_btn" onclick="removeMedicineField(this);"><span class="fa fa-minus"></span></button>';
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

                <div class="other_instruction_section">
                    <div class="panel-heading pescription_panel_heading">Other Instructions</div>
                    <div class="other_instruction">
                        <?php echo $this->Form->input('is_print', ['id'=> 'is-print', 'type' => 'hidden', 'value' => 0]); ?>
                        <?php echo $this->Form->input('other_instructions', [ 'class'=>'form-control', 'value' => (isset($prescription['other_instructions']))? $prescription['other_instructions']:'', 'label'=>false, 'type' =>'textarea', 'placeholder'=>'Type here...' ]);?>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <div class="row">
        <div class="prescription_button_section">
            <a href="<?php echo $this->Url->build(array('action' => 'index' )) ?>" class="btn btn-default btn-cancel prescription_btn" title="Cancel">Cancel</a>
            <div class="flex-item">
                <?= $this->Form->button(__('Save'), ['class' => 'btn save event-save prescription_btn']) ?>
            </div>
            <div class="flex-item">
                <?= $this->Form->button(__('Save & Print'), ['class' => 'btn save event-save prescription_btn', 'type' => 'button', 'onclick' => 'saveAndPrint()']) ?>
            </div>
        </div>
    </div>


<script type="text/javascript">
    $(document).ready(function(){

        jQuery('#prescription-form').validate({

        });

        // Add Diagnosis field
        $("#addMoreDiagnosis").click(function(){
            $("#diagnosisWrap").append('<?php echo $new_diagnosis ?>');
        });

        // Add Medicine field
        $("#addMoreMedicine").click(function(){
            $("#medicinesWrap").append('<?php echo $field_medicine ?>').find('select').last().val('');
            $("#medicinesWrap").find('input').last().val('');

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

    // Delete Diagnosis field
    function removeDiagnosisField(e){
        $(e).parents('.new_diagnosis_row').remove();
    }

    // Delete Medicine field
    function removeMedicineField(e){
        $(e).parents('.medicines_row').remove();
    }

    function getDiagnosis(e){
        var checkedVals = $('input:checkbox:checked').map(function() {
            return this.value;
        }).get();

        var all_id = checkedVals.join("_");

        $('.tests .tokenize-sortable-demo1').trigger('tokenize:clear');
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

                $( ".medicines_row" ).each(function( index, element ) {
                    $(element).find('select').trigger('tokenize:clear');
                    $(element).find('select').trigger('tokenize:tokens:add', [response.medicines[index].id, response.medicines[index].name, true]);
                    $(element).find('input').val(response.medicines[index].rule);
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
