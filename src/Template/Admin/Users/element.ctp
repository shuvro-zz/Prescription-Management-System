<div class="panel-body">
    <?php
    echo'<div class="col-sm-6">
        <div class="form-row">
            <label class="name">First Name<span class="required" aria-required="true"></span></label>
            <div class="inputs">';
                echo $this->Form->input('first_name', ['class' => 'form-control', 'label' => false, 'required' => true, 'type' =>'text']);
            echo '</div>

            <label class="name">Last Name<span class="required" aria-required="true"></span></label>
            <div class="inputs">';
                echo $this->Form->input('last_name', ['class' => 'form-control', 'label' => false, 'required' => true, 'type' =>'text']);
            echo '</div>

            <label class="name">Phone<span class="required" aria-required="true"></span></label>
            <div class="inputs">';
                echo $this->Form->input('phone', ['class' => 'form-control', 'label' => false, 'required' => true, 'type' =>'text']);
            echo '</div>

            <label class="name">Email<span class="required" aria-required="true"></span></label>
            <div class="inputs">';
                echo $this->Form->input('email', ['class' => 'form-control', 'label' => false, 'type' =>'email']);
            echo '</div>

            <label class="name">Age<span class="required" aria-required="true"></span></label>
            <div class="inputs">';
                echo $this->Form->input('age', ['class' => 'form-control', 'label' => false, 'required' => true, 'type' =>'text']);
            echo '</div>';

        echo '</div>
    </div>';
    ?>
</div>