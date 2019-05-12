<style>
    .dropdown-menu{
        overflow-y: scroll!important;
        max-height: 300px!important;
    }
</style>

<div class="col-sm-12">
    <div class="form-group">
        <label class="name">Template Name *<span class="" aria-required="true"></span></label>
        <div class="inputs">
            <?php echo $this->Form->input('template_name', ['class' => 'form-control', 'required' => 'true', 'value' => isset($diagnosi->template_name)?$diagnosi->template_name:'', 'label' => false, 'type' =>'text']); ?>
        </div>
    </div>
</div>

<div class="col-sm-12">
    <div class="form-group">
        <label class="name">Diagnosis Name *<span class="required" aria-required="true"></span></label>
        <div class="inputs diagnosis_area">
            <?php echo $this->Form->input('diagnosis_list_id', ['options' => $diagnosis_list, 'required' => 'true', 'default'=>(isset($diagnosi['diagnosis_list_id']))? $diagnosi['diagnosis_list_id']:'', 'class'=> 'tokenize-sortable-demo1 diagnosis_list', 'label'=>false, 'multiple'=>true ]); ?>
        </div>
    </div>
</div>

<div class="col-sm-12">
    <div class="form-group">
        <label class="name">Chief Complain<span class="" aria-required="true"></span></label>
        <div class="inputs">
            <?php echo $this->Form->input('chief_complain', ['class' => 'form-control', 'value' => isset($diagnosi->chief_complain)?$diagnosi->chief_complain:'', 'rows' => '7', 'label' => false, 'type' =>'textarea']); ?>
        </div>
    </div>
</div>

<div class="col-sm-12">
    <div class="form-group">
        <label class="name">On Examination<span class="" aria-required="true"></span></label>
        <div class="inputs">
            <?php echo $this->Form->input('on_examination', ['class' => 'form-control', 'value' => isset($diagnosi->on_examination)?$diagnosi->on_examination:'', 'rows' => '7', 'label' => false, 'type' =>'textarea']); ?>
        </div>
    </div>
</div>

<div class="col-sm-12">
    <div class="medicines_section">
        <button type="button" id="addMoreMedicine" class="add_more_btn" title="Add more medicine"><span class="fa fa-plus"></span></button>
        <label class="name">Medicines<span class="" aria-required="true"></span></label>
        <div class="medicines medicine_box diagnosis_template_medicine_box">
            <?php
            echo '<div class="medicines_wrap" id="medicinesWrap">';
            foreach($diagnosis_medicines as $diagnosis_medicine){
                $field_medicine = '<div class="medicines_row">';
                $field_medicine .= '<div class="col-sm-3 medicine_name" onmouseover="setzIndex(this)"  onmouseout="unsetzIndex(this)">';
                $field_medicine .= '<div class="inputs">';
                $field_medicine .=  $this->Form->input('medicines.medicine_id[]', ['options' => $medicines, 'default' => (isset($diagnosis_medicine->medicine_id))? $diagnosis_medicine->medicine_id:'', 'class' => 'tokenize-sortable-demo1 prescription_medicine', 'label'=>false, 'multiple'=>true]);
                $field_medicine .= '</div>';
                $field_medicine .= '</div>';

                $field_medicine .= '<div class="col-sm-2 medicine_rule">';
                $field_medicine .= '<div class="inputs">';
                $field_medicine .=  $this->Form->input('medicines.rule[]', ['class'=>'form-control', 'default' => (isset($diagnosis_medicine->rule))? $diagnosis_medicine->rule:'', 'placeholder'=>'0-1-0', 'label'=>false]);
                $field_medicine .= '</div>';
                $field_medicine .= '</div>';

                $field_medicine .=  '<div class="col-sm-1">';
                $field_medicine .= '<div class="inputs">';
                $field_medicine .= '<button type="button"  class="dle_medicine_btn" onclick="removeMedicineField(this);"><span class="fa fa-minus"></span></button>';
                $field_medicine .= '</div>';
                $field_medicine .= '</div>';
                $field_medicine .= '</div>';

                //dd($diagnosis_medicine);

                if(strtolower($this->request->params['action']) == 'edit' && isset($diagnosis_medicine->medicine_id) ){
                    echo  $field_medicine;
                }

            }
            echo '</div>';
            ?>
        </div>
    </div>
</div>

<div class="col-sm-12">
    <div class="form-group">
        <label class="name">Examinations<span class="" aria-required="true"></span></label>
        <div class="inputs">
            <?php echo $this->Form->input('tests._ids', ['options' => $tests, 'label' => false, 'default' => isset($default_tests)?$default_tests:'', 'class' => 'tokenize-sortable-demo1 test']); ?>
        </div>
    </div>
</div>

<div class="col-sm-12">
    <div class="form-group">
        <label class="name">Other Instruction<span class="" aria-required="true"></span></label> <!--Instruction-->
        <div class="inputs">
            <?php echo $this->Form->input('instructions', ['class' => 'form-control', 'value' => isset($diagnosi->instructions)?$diagnosi->instructions:'', 'rows' => '7', 'label' => false, 'type' =>'textarea']); ?>
        </div>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function(){

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

    // Delete Medicine field
    function removeMedicineField(e){
        $(e).parents('.medicines_row').remove();
    }

</script>