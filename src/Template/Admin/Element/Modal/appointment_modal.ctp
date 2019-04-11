<div id="serial-no-modal" class="modal fade" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Add appointment</h4>
            </div>
            <?php echo $this->Form->create('', array('id' => 'appointment-form','url'=>array('action'=>'addAppointment'),'method'=>'post'));?>

            <div class="modal-body">
                <div class="col-sm-4">
                    <div class="form-group">

                        <input id="today-appointment" type="radio" required name="appointment_date" value="today_appointment" <?php echo (isset($user->appointment_date))?((date_format($user->appointment_date, 'Y-m-d') == date('Y-m-d'))? "checked":""):"" ?>>
                        <label for="today-appointment" class="cursore_pointer">Today's Appointment</label><br>

                        <span id="serial-no-section" class="hidden">
                            <label>Serial No</label> <i class="fa fa-magic cursore_pointer" onclick="setAppointmentLastSerialNo()" title="Automatic make last serial no" aria-hidden="true"></i>

                            <span class="hide" id="today-appointment-loading"><i class="fa fa-spinner fa-spin today_appointment_loading" style=""></i></span>

                            <input id="serial-no" type="number" min="1" name="serial_no" required value="<?php echo (isset($user->serial_no))? $user->serial_no:'' ?>" class="serail_no">
                        </span>

                    </div>
                </div>

                <input id="user-id" type="hidden" name="user_id" value="">

                <div class="col-sm-4">
                    <div class="form-group">

                        <input id="appointments" type="radio" required name="appointment_date" value="appointments" <?php echo (isset($user->appointment_date))?((date_format($user->appointment_date, 'Y-m-d') > date('Y-m-d'))? "checked":""):"" ?>>
                        <label for="appointments" class="cursore_pointer">Appointments</label><br>

                        <span id="appointment_calender_date" class="hidden">
                        <label class="name">Date</label>
                        <input type="text" name="appointment_calender_date" id="appointment-calender-date" required value="<?php echo isset($user->appointment_date)?date( 'd-m-Y', strtotime($user->appointment_date)):'' ?>" placeholder="Click here" autocomplete="off" class="appointment_calender_date">
                    </span>

                    </div>
                </div>
            </div>

            <div class="modal-footer">
                <div class="flex-container">
                    <a type="button" class="btn btn-default btn-cancel prescription_btn" data-dismiss="modal">Cancel</a>
                    <div class="flex-item">
                        <?= $this->Form->button(__('Submit'), ['class' => 'btn save event-save prescription_btn']) ?>
                    </div>
                </div>
            </div>

            <?= $this->Form->end() ?>
        </div>

    </div>
</div>
