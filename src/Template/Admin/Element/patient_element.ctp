<div class="panel-body">
    <?php if($this->request->session()->read('Auth.User.role_id') == 1){ ?>
        <h2>Doctor Info</h2>
    <?php }else{ ?>
        <h2>Patient Info</h2>
    <?php } ?>

    <?php if($this->request->session()->read('Auth.User.role_id') == 1){ ?>
        <div class="row">
            <div class="col-sm-6">
                <div class="form-group">
                    <label class="name">Expire Date<span class="required" aria-required="true"></span></label>
                    <div class="inputs">
                        <?php echo $this->Form->input('expire_date', ['class' => 'form-control date', 'value' =>  (isset($user->expire_date))? $user->expire_date:'', 'label' => false, 'required' => true, 'placeholder' => 'DD/MM/YY', 'type' =>'text']); ?>
                    </div>
                </div>
            </div>
        </div>

    <?php }else{ ?>
        <div class="row">
            <div class="col-sm-6">
                <div class="form-group">
                    <label class="name">Name*<span class="required" aria-required="true"></span></label>
                    <div class="inputs">
                        <?php echo $this->Form->input('first_name', ['class' => 'form-control', 'id' => 'userName', 'value' => (isset($user->first_name))? $user->first_name:'', 'label' => false, 'required' => true, 'type' =>'text']); ?>
                    </div>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="form-group">
                    <label class="name">Phone*<span class="required" aria-required="true"></span></label>
                    <div class="inputs">
                        <?php

                            $session = $this->request->session();
                            if($session->check('users_search_from_dashboard')) {
                                $phone = $session->read('users_search_from_dashboard');
                            }else{
                                $phone = (isset($user->phone))? $user->phone:'';
                            }

                        ?>
                        <?php echo $this->Form->input('phone', ['class' => 'form-control ','value' => $phone, 'id' => 'userPhone',  'label' => false, 'required' => true, 'type' =>'text']); ?>
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
                    <label class="name">Age*<span class="required" aria-required="true"></span></label>
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

            <div class="col-sm-6">
                <div class="form-group">
                    <label class="name">Weight<span aria-required="true"></span></label>
                    <div class="inputs">
                        <?php echo $this->Form->input('weight', ['class' => 'form-control','value' => (isset($user->weight))? $user->weight:'', 'label' => false, 'type' =>'text']); ?>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-6">
                <div class="form-group">
                    <label class="name">Sex<span aria-required="true"></span></label>
                    <div class="inputs">
                        <?php echo $this->Form->input('sex', ['options' => ['Male' => 'Male', 'Female' => 'Female'], 'default' => (isset($user->sex)) ? $user->sex : '', 'empty' => 'Select', 'required' => false, 'class' => 'form-control', 'label' => false]); ?>
                    </div>
                </div>
            </div>

            <div class="col-sm-3">
                <div class="form-group">

                    <input id="today-appointment" type="radio" name="appointment_date" value="today_appointment" <?php echo (isset($user->appointment_date))?((date_format($user->appointment_date, 'Y-m-d') == date('Y-m-d'))? "checked":""):"" ?>>
                    <label for="today-appointment" class="cursore_pointer">Today's Appointment</label><br>

                    <span id="serial-no-section" class="<?php echo (isset($user->appointment_date))?"":"hidden" ?>">
                        <label>Serial No</label> <i class="fa fa-magic cursore_pointer" onclick="setAppointmentLastSerialNo()" title="Automatic make last serial no" aria-hidden="true"></i>

                        <span class="hide" id="today-appointment-loading"><i class="fa fa-spinner fa-spin today_appointment_loading" style=""></i></span>

                        <input id="serial-no" type="number" min="1" name="serial_no" required value="<?php echo (isset($user->serial_no))? $user->serial_no:'' ?>" class="serail_no">
                    </span>

                </div>

            </div>


            <div class="col-sm-3">
                <div class="form-group">

                    <input id="appointments" type="radio" name="appointment_date" value="appointments" <?php echo (isset($user->appointment_date))?(((strtotime($user->appointment_date)) != strtotime(date('d-m-Y')))? "checked":""):"" ?>>
                    <label for="appointments" class="cursore_pointer">Future Appointments</label><br>

                    <span id="appointment_calender_date" class="hidden">
                        <label class="name">Date</label>
                        <input type="text" id="appointment-calender-date" name="appointment_calender_date" required value="<?php echo isset($user->appointment_date)?date( 'd-m-Y', strtotime($user->appointment_date)):'' ?>" placeholder="Click here" autocomplete="off" class="appointment_calender_date">
                    </span>

                </div>
            </div>


        </div>
    <?php }?>

    <?php echo $this->Form->input('id', ['type' =>'hidden', 'id' => 'patient-id', 'value' => (isset($id)? $id:'') ]); ?>
</div>
