<div class="panel-body">
    <h2>Patient Info</h2>
    <div class="col-sm-6">
        <div class="form-group">
            <label class="name">Name<span class="required" aria-required="true"></span></label>
            <div class="inputs">
                <?php
                    echo $this->Form->input('first_name', ['class' => 'form-control', 'label' => false, 'required' => true, 'type' =>'text']);
                ?>
            </div>
        </div>
    </div>
    <div class="col-sm-6">
        <div class="form-group">
            <label class="name">Phone<span class="required" aria-required="true"></span></label>
            <div class="inputs">
                <?php echo $this->Form->input('phone', ['class' => 'form-control ', 'id' => 'userPhone',  'label' => false, 'required' => true, 'type' =>'text']); ?>
            </div>
        </div>
    </div>
    <div class="col-sm-6">
        <div class="form-group">
            <label class="name">Email<span class="required" aria-required="true"></span></label>
            <div class="inputs">
                <?php echo $this->Form->input('email', ['class' => 'form-control', 'label' => false, 'type' =>'email']); ?>
            </div>
        </div>
    </div>
    <div class="col-sm-6">
        <div class="form-group">
            <label class="name">Age<span class="required" aria-required="true"></span></label>
            <div class="inputs">
                <?php echo $this->Form->input('age', ['class' => 'form-control', 'label' => false, 'required' => true, 'type' =>'text']); ?>
            </div>
        </div>
    </div>
    <div class="col-sm-6">
        <div class="form-group">
            <label class="name">Address<span aria-required="true"></span></label>
            <div class="inputs">
                <?php echo $this->Form->input('address_line1', ['class' => 'form-control', 'label' => false, 'required' => true, 'type' =>'text']); ?>
            </div>
        </div>
    </div>

    <?php echo $this->Form->input('id', ['type' =>'hidden', 'id' => 'patient-id', 'value' => (isset($id)? $id:'') ]); ?>
</div>