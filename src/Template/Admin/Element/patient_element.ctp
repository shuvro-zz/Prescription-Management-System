<div class="panel-body">
    <?php if($this->request->session()->read('Auth.User.role_id') == 1){ ?>
        <h2>Doctor Info</h2>
    <?php }else{ ?>
        <h2>Patient Info</h2>
    <?php } ?>

    <?php if($this->request->session()->read('Auth.User.role_id') == 1){ ?>
        <div class="col-sm-6">
            <div class="form-group">
                <label class="name">Expire Date<span class="required" aria-required="true"></span></label>
                <div class="inputs">
                    <?php echo $this->Form->input('expire_date', ['class' => 'form-control date', 'value' =>  (isset($user->expire_date))? $user->expire_date:'', 'label' => false, 'required' => true, 'placeholder' => 'DD/MM/YY', 'type' =>'text']); ?>
                </div>
            </div>
        </div>
    <?php }else{ ?>
        <div class="row">
            <div class="col-sm-6">
                <div class="form-group">
                    <label class="name">Name<span class="required" aria-required="true"></span></label>
                    <div class="inputs">
                        <?php echo $this->Form->input('first_name', ['class' => 'form-control', 'value' => (isset($user->first_name))? $user->first_name:'', 'label' => false, 'required' => true, 'type' =>'text']); ?>
                    </div>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="form-group">
                    <label class="name">Phone<span class="required" aria-required="true"></span></label>
                    <div class="inputs">
                        <?php echo $this->Form->input('phone', ['class' => 'form-control ','value' => (isset($user->phone))? $user->phone:'', 'id' => 'userPhone',  'label' => false, 'required' => true, 'type' =>'text']); ?>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-6">
                <div class="form-group">
                    <label class="name">Email<span class="required" aria-required="true"></span></label>
                    <div class="inputs">
                        <?php echo $this->Form->input('email', ['class' => 'form-control','value' => (isset($user->email))? $user->email:'',  'label' => false, 'type' =>'email']); ?>
                    </div>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="form-group">
                    <label class="name">Age<span class="required" aria-required="true"></span></label>
                    <div class="inputs">
                        <?php echo $this->Form->input('age', ['class' => 'form-control','value' => (isset($user->age))? $user->age:'',  'label' => false, 'required' => true, 'type' =>'text']); ?>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-6">
                <div class="form-group">
                    <label class="name">Address<span aria-required="true"></span></label>
                    <div class="inputs">
                        <?php echo $this->Form->input('address_line1', ['class' => 'form-control','value' => (isset($user->address_line1))? $user->address_line1:'', 'label' => false, 'type' =>'text']); ?>
                    </div>
                </div>
            </div>
        </div>

    <?php }?>

    <?php echo $this->Form->input('id', ['type' =>'hidden', 'id' => 'patient-id', 'value' => (isset($id)? $id:'') ]); ?>
</div>
