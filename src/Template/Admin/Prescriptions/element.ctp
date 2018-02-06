    <?php

    echo'<div class="clearfix">
        <div class="col-sm-6">
            <div class="form-row">
                <label class="name">Patients<span class="required" aria-required="true">*</span></label>
                <div class="inputs">';
                    echo $this->Form->input('user_id', ['options' => $users, 'empty' => 'Select', 'class'=>'form-control selectpicker', 'data-live-search'=>true, 'label'=>false, 'required'=> true ]);
                echo '</div>
            </div>
        </div>';

        echo'<div class="col-sm-6">
            <div class="form-row">
                <label class="name">Diagnosis<span class="required" aria-required="true"></span></label>
                <div class="inputs">';
                    echo $this->Form->input('diagnosis', ['class' => 'form-control', 'label' => false, 'required' => true, 'type' =>'text']);
                echo '</div>
            </div>
        </div>
    </div>';

    echo'<div class="clearfix">
        <div class="col-sm-6">
            <div class="form-row">
                <label class="name">Temperature</label>
                <div class="inputs">';
                    echo $this->Form->input('temperature', [ 'class'=>'form-control','label'=>false, 'required'=> true ]);
                echo '</div>
            </div>
        </div>';

        echo'<div class="col-sm-6">
            <div class="form-row">
                <label class="name">Blood Pressure</label>
                <div class="inputs">';
                    echo $this->Form->input('blood_pressure', ['class' => 'form-control', 'label' => false, 'required' => true, 'type' =>'text']);
                echo '</div>
            </div>
        </div>
    </div>';

    echo '<div class="medicines_wrap" id="medicinesWrap">
        <button type="button" id="addMoreMedicine" class="add_more_btn"><span class="fa fa-plus"></span></button>';
         foreach($prescription_medicines as $prescription_medicine){
        $field_medicine = '<div class="medicines_row clearfix">';
            $field_medicine .= '<div class="col-sm-5">';
                $field_medicine .= '<div class="form-row">';
                    $field_medicine .= '<label class="name">Medicines<span class="required" aria-required="true"></span></label>';
                        $field_medicine .= '<div class="inputs">';
                            $field_medicine .=  $this->Form->input('medicines.medicine_id[]', ['options' => $medicines, 'default' => (isset($prescription_medicine->medicine_id))? $prescription_medicine->medicine_id:'', 'empty' => 'Select', 'class'=>'form-control selectpicker', 'data-live-search'=>true, 'label'=>false]);
                    $field_medicine .= '</div>';
                $field_medicine .= '</div>';
            $field_medicine .= '</div>';

            $field_medicine .= '<div class="col-sm-5">';
                $field_medicine .= '<div class="form-row">';
                    $field_medicine .= '<label class="name">Rule<span class="required" aria-required="true"></span></label>';
                        $field_medicine .= '<div class="inputs">';
                            $field_medicine .=  $this->Form->input('medicines.rule[]', ['class'=>'form-control', 'default' => (isset($prescription_medicine->rule))? $prescription_medicine->rule:'', 'placeholder'=>'0-1-0', 'label'=>false]);
                        $field_medicine .=  '</div>';
                $field_medicine .= '</div>';
            $field_medicine .= '</div>';

            $field_medicine .=  '<div class="col-sm-2">';
                $field_medicine .= '<div class="inputs">';
                    $field_medicine .= '<button type="button" class="dle_medicine_btn" onclick="removeField(this);"><span class="fa fa-minus"></span></button>';
                $field_medicine .= '</div>';
            $field_medicine .= '</div>';
        $field_medicine .= '</div>';
        echo  $field_medicine;
        }
    echo '</div>';

    echo '<div class="tests_wrap" id="testsWrap">
        <button type="button" id="addMoreTest" class="add_more_btn"><span class="fa fa-plus"></span></button>';
        foreach($prescription_tests as $prescription_test){
        $field_test = '<div class="medicines_row clearfix">';
            $field_test .= '<div class="col-sm-5">';
                $field_test .= '<div class="form-row">';
                    $field_test .= '<label class="name">Tests<span class="required" aria-required="true"></span></label>';
                         $field_test .= '<div class="inputs">';
                             $field_test .=  $this->Form->input('tests.test_id[]', ['options' => $tests, 'default' => (isset($prescription_test->test_id))? $prescription_test->test_id:'', 'empty' => 'Select', 'class'=>'form-control selectpicker', 'data-live-search'=>true, 'label'=>false]);
                    $field_test .= '</div>';
                $field_test .= '</div>';
            $field_test .= '</div>';

            $field_test .= '<div class="col-sm-5">';
                $field_test .= '<div class="form-row">';
                    $field_test .= '<label class="name">Note<span class="required" aria-required="true"></span></label>';
                        $field_test .= '<div class="inputs">';
                            $field_test .=  $this->Form->input('tests.note[]', ['class'=>'form-control', 'default' => (isset($prescription_test->note))? $prescription_test->note:'', 'placeholder'=>'Type notes', 'label'=>false]);
                    $field_test .=  '</div>';
                $field_test .= '</div>';
            $field_test .= '</div>';

            $field_test .=  '<div class="col-sm-2">';
                $field_test .= '<div class="inputs">';
                    $field_test .= '<button type="button" class="dle_medicine_btn" onclick="removeField(this);"><span class="fa fa-minus"></span></button>';
                $field_test .= '</div>';
            $field_test .= '</div>';
        $field_test .= '</div>';
        echo  $field_test;
    }
    echo '</div>';

    echo'<div class="clearfix">
        <div class="col-sm-12">
            <div class="form-row">
                <label class="name">Doctor\'s Note</label>
                <div class="inputs">';
                    echo $this->Form->input('doctores_notes', ['class' => 'form-control', 'label' => false, 'type' =>'textarea']);
                echo '</div>
            </div>
        </div>
    </div>';
    ?>

<script type="text/javascript">
    $(document).ready(function(){
        // Add Medicine field
        $("#addMoreMedicine").click(function(){
            $(".dle_medicine_btn").css('display');
            $("#medicinesWrap").append('<?php echo $field_medicine ?>');
            $(".selectpicker").selectpicker('refresh');
        });

        // Add Test field
        $("#addMoreTest").click(function(){
            $(".dle_medicine_btn").css('display');
            $("#testsWrap").append('<?php echo $field_test ?>');
            $(".selectpicker").selectpicker('refresh');
        });
    });

    // Delete field
    function removeField(e){
        $(e).parents('.medicines_row').remove();
    }

</script>



