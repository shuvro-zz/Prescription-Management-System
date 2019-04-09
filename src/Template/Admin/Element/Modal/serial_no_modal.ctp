<div id="serial-no-modal" class="modal fade" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Add to to day's appointment</h4>
            </div>
            <?php echo $this->Form->create('', array('id' => 'user-serial-no','url'=>array('action'=>'addTodayAppointment'),'method'=>'post'));?>

            <div class="modal-body">
                <span>
                    <label>Serial No</label>
                    <span class="hide" id="today-appointment-loading"><i class="fa fa-spinner fa-spin today_appointment_loading" style=""></i></span>

                    <input id="serial-no" type="text" name="serial_no" required value="" class="serial_no_modal serail_no">
                    <input id="user-id" type="hidden" name="user_id" value="">
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