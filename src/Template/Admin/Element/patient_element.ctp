<div class="panel-body">
    <h2>Patient Info</h2>
    <?php if(strtolower($this->name) == 'prescriptions'){ ?>
        <div class="col-sm-4">
            <div class="form-row">
                <label class="name">Name<span class="required" aria-required="true"></span>
                    <?php if(strtolower($this->request->params['action']) == 'add'){
                        echo '<span class="fa fa-pencil-square" id="new_patient" title="New Patient"></span>';
                    } ?>
                </label>
                <div class="inputs"  id='patient_drop_down' >
                    <?php
                    if(strtolower($this->request->params['action']) == 'edit'){
                        echo $this->Form->input('user_id', ['options' => $users, 'empty' => 'Select',  'class'=>'form-control selectpicker', 'data-live-search'=>true, 'label'=>false, 'required'=>true,'onchange'=>'getUserInfo(this.value)'  ]);
                    }else{
                        echo $this->Form->input('user_id', ['options' => $users, 'default'=>(isset($prescription->user['id']))? $prescription->user['id']:'', 'empty' => 'Select', 'class'=>'form-control selectpicker', 'data-live-search'=>true,'onchange'=>'getUserInfo(this.value)','label'=>false,  ]);
                    }
                    ?>
                </div>
                <?php
                if(strtolower($this->request->params['action']) == 'add'){
                ?>
                <div class="inputs hide" id='patient_field'>
                    <?php echo $this->Form->input('patients.first_name', ['class' => 'form-control', 'label' => false, 'type' =>'text']); ?>
                </div>
                <?php } ?>

            </div>
        </div>
        <div class="col-sm-3">
            <div class="form-row">
                <label class="name">Phone<span class="required" aria-required="true"></span></label>
                <div class="inputs">
                   <?php echo $this->Form->input('patients.phone', ['class' => 'form-control reset_patient',  'value' => (isset($prescription->user['phone']))? $prescription->user['phone']:'',  'label' => false, 'required' => true, 'type' =>'text', 'id' => 'user-phone']); ?>
                </div>
            </div>
        </div>
        <div class="col-sm-3">
            <div class="form-row">
                <label class="name">Email<span class="required" aria-required="true"></span></label>
                <div class="inputs">
                   <?php echo $this->Form->input('patients.email', ['class' => 'form-control reset_patient',  'value' => (isset($prescription->user['email']))? $prescription->user['email']:'',  'label' => false, 'type' =>'email','id'=>'user-email']); ?>
                </div>
            </div>
        </div>
        <div class="col-sm-2">
            <div class="form-row">
                <label class="name">Age<span class="required" aria-required="true"></span></label>
                <div class="inputs">
                   <?php echo $this->Form->input('patients.age', ['class' => 'form-control reset_patient',  'value' => (isset($prescription->user['age']))? $prescription->user['age']:'', 'label' => false, 'type' =>'text','id'=>'user-age']); ?>
                </div>
            </div>
        </div>
    <?php }else{ ?>
        <div class="col-sm-6">
            <div class="form-row">
                <label class="name">Name<span class="required" aria-required="true"></span></label>
                <div class="inputs">
                    <?php
                        echo $this->Form->input('first_name', ['class' => 'form-control', 'label' => false, 'required' => true, 'type' =>'text']);
                    ?>
                </div>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="form-row">
                <label class="name">Phone<span class="required" aria-required="true"></span></label>
                <div class="inputs">
                    <?php echo $this->Form->input('phone', ['class' => 'form-control ',  'label' => false, 'required' => true, 'type' =>'text']); ?>
                </div>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="form-row">
                <label class="name">Email<span class="required" aria-required="true"></span></label>
                <div class="inputs">
                    <?php echo $this->Form->input('email', ['class' => 'form-control', 'label' => false, 'type' =>'email']); ?>
                </div>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="form-row">
                <label class="name">Age<span class="required" aria-required="true"></span></label>
                <div class="inputs">
                    <?php echo $this->Form->input('age', ['class' => 'form-control', 'label' => false, 'required' => true, 'type' =>'text']); ?>
                </div>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="form-row">
                <label class="name">Address<span aria-required="true"></span></label>
                <div class="inputs">
                    <?php echo $this->Form->input('address_line1', ['class' => 'form-control', 'label' => false, 'required' => true, 'type' =>'text']); ?>
                </div>
            </div>
        </div>
    <?php } ?>
</div>