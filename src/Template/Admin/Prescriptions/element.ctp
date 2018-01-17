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

    echo '<div class="col-sm-6">
        <div class="form-row">
            <label class="name">Medicines<span class="required" aria-required="true"></span></label>
            <div class="inputs">';
                echo $this->Form->input('medicines._ids', ['options' => $medicines,'class'=>'form-control', 'label'=>false]);
            echo '</div>
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