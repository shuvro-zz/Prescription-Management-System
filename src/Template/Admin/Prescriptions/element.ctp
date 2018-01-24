    <?php

    echo'<div class="col-sm-6">
        <div class="form-row">
            <label class="name">Patients<span class="required" aria-required="true"></span></label>
            <div class="inputs">';
                echo $this->Form->input('user_id', ['options' => $users,'class'=>'form-control','label'=>false]);
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
    </div>';

    echo '<div id="medicinesWrap">
        <div class="medicines_row" id="medicinesRow">
            <div class="col-sm-5">
                <div class="form-row">
                    <label class="name">Medicines<span class="required" aria-required="true"></span></label>
                    <div class="inputs">';
                        echo $this->Form->input('medicines._ids', ['options' => $medicines,'class'=>'form-control', 'label'=>false]);
                    echo '</div>
                </div>
            </div>';

            echo '<div class="col-sm-5">
                <div class="form-row">
                    <label class="name">Medicines<span class="required" aria-required="true"></span></label>
                    <div class="inputs">';
            echo $this->Form->input('medicines._ids', ['options' => $medicines,'class'=>'form-control', 'label'=>false]);
            echo '</div>
                </div>
            </div>';

            echo '<div class="col-sm-2">
                <div class="form-row">
                    <div class="inputs">
                        <button type="button" id="addMoreBtn">Add More</button>
                    </div>
                </div>
            </div>
        </div>
    </div>';


    echo '<div class="col-sm-6">
        <div class="form-row">
            <label class="name">Tests<span class="required" aria-required="true"></span></label>
            <div class="inputs">';
                echo $this->Form->input('tests._ids', ['options' => $tests,'class'=>'form-control','label'=>false]);
            echo '</div>
        </div>
    </div>'; ?>



<script type="text/javascript">
    $(document).ready(function(){
        var get_content = document.getElementById ("medicinesRow");
        $("#addMoreBtn").click(function(){
            console.log(get_content);
            $("#medicinesWrap").append(get_content);

        });



        /*$("article.postContent").append(footer);


        // Add field
        $("#fcu_add_fild_btn").click(function(){
        $("#fcu_custom_field_con").append('<?php //echo $field_append ?>');
        });

        // Delete field
        $(".fcu_custom_field_con").on('click','.fcu_del_fild_btn',function(){
        $(this).parent('p').remove();
        });*/

    });

</script>



