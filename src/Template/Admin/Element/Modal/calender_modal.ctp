<div id="calender-date-modal" class="modal fade" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Add to appointments</h4>
            </div>
            <?php echo $this->Form->create('', array('id' => 'user-calender-date','url'=>array('action'=>'addAppointments'),'method'=>'post'));?>

            <div class="modal-body">
                <span>
                    <label>Date </label>
                    <input type="text" name="appointment_calender_date" required value="" placeholder="Click here" autocomplete="off" class="appointment_calender_date">

                    <input id="user-id-for-date" type="hidden" name="user_id" value="">
                </span>
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