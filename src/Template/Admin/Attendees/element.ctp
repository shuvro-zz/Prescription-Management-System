<div class="panel-body">
    <div class="col-sm-6">
        <div class="form-row">
            <label class="name">First Name<span class="required" aria-required="true"></span></label>
            <div class="inputs">
                <?php echo $this->Form->input('first_name', ['class' => 'form-control', 'label' => false, 'required' => true, 'type' =>'text']) ?>
            </div>
        </div>
    </div>
    <div class="col-sm-6">
        <div class="form-row">
            <label class="name">Surname<span class="required" aria-required="true"></span></label>
            <div class="inputs">
                <?php echo $this->Form->input('surname', ['class' => 'form-control', 'label' => false, 'required' => true, 'type' =>'text']) ?>
            </div>
        </div>
    </div>
    <div class="col-sm-6">
        <div class="form-row">
            <label class="name">Date of Birth<span class="required" aria-required="true"></span></label>
            <div class="inputs">
                <div class="input-group">
                    <?php echo $this->Form->input('dob', ['class' => 'form-control date', 'placeholder' => 'DD/MM/YY', 'label' => false, 'div' => false, 'required' => true, 'type' =>'text']) ?>
                    <span class="input-group-addon">
                        <?php echo $this->Html->image('/css/admin_styles/images/icon-calender.png') ?>
                    </span>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-6">
        <div class="form-row">
            <label class="name">Mobile<span class="required" aria-required="true"></span></label>
            <div class="inputs">
                <?php echo $this->Form->input('mobile', ['class' => 'form-control', 'label' => false, 'required' => true, 'type' =>'text']) ?>
            </div>
        </div>
    </div>
    <div class="col-sm-6">
        <div class="form-row">
            <label class="name">Telephone<span class="required" aria-required="true"></span></label>
            <div class="inputs">
                <?php echo $this->Form->input('telephone', ['class' => 'form-control', 'label' => false, 'required' => true, 'type' =>'text']) ?>
            </div>
        </div>
    </div>
    <div class="col-sm-6">
        <div class="form-row">
            <label class="name">Address Line1<span class="required" aria-required="true"></span></label>
            <div class="inputs">
                <?php echo $this->Form->input('address_line1', ['class' => 'form-control', 'label' => false, 'required' => true, 'type' =>'text']) ?>
            </div>
        </div>
    </div>
    <div class="col-sm-6">
        <div class="form-row">
            <label class="name">Address Line2<span class="required" aria-required="true"></span></label>
            <div class="inputs">
                <?php echo $this->Form->input('address_line2', ['class' => 'form-control', 'label' => false, 'required' => true, 'type' =>'text']) ?>
            </div>
        </div>
    </div>
    <div class="col-sm-6">
        <div class="form-row">
            <label class="name">Email<span class="required" aria-required="true"></span></label>
            <div class="inputs">
                <?php echo $this->Form->input('email', ['class' => 'form-control', 'label' => false, 'required' => true, 'type' =>'email' ] )  ?>
            </div>
        </div>
    </div>
    <div class="col-sm-6">
        <div class="form-row">
            <label class="name">Post Code<span class="required" aria-required="true"></span></label>
            <div class="inputs">
                <?php echo $this->Form->input('post_code', ['class' => 'form-control', 'label' => false, 'required' => true, 'type' =>'text']) ?>
            </div>
        </div>
    </div>
    <div class="col-sm-6">
        <div class="form-row">
            <label class="name">City<span class="required" aria-required="true"></span></label>
            <div class="inputs">
                <?php echo $this->Form->input('city', ['class' => 'form-control', 'label' => false, 'required' => true, 'type' =>'text']) ?>
            </div>
        </div>
    </div>
    <div class="col-sm-6">
        <div class="form-row">
            <label class="name">State<span class="required" aria-required="true"></span></label>
            <div class="inputs">
                <?php echo $this->Form->input('state', ['class' => 'form-control', 'label' => false, 'required' => true, 'type' =>'text']) ?>
            </div>
        </div>
    </div>
    <div class="col-sm-6">
        <div class="form-row">
            <label class="name">Country<span class="required" aria-required="true"></span></label>
            <div class="inputs">
                <?php echo $this->Form->input('country_id', ['class' => 'form-control', 'label' => false, 'required' => true, 'options' => $countries, 'empty' => 'Select' ]) ?>
            </div>
        </div>
    </div>
    <div class="col-sm-6">
        <div class="form-row">
            <label class="name">Attendee Type<span class="required" aria-required="true"></span></label>
            <div class="inputs">
                <?php echo $this->Form->input('attendee_type_id', ['class' => 'form-control', 'label' => false, 'required' => true, 'options' => $attendeeTypes, 'empty' => 'Select'] ) ?>
            </div>
        </div>
    </div>
</div>