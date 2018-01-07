<?php
$conference_date = (isset($conference) and trim($conference['conference_date'])!='') ? $this->Common->getDate( $conference['conference_date'] ): '';
?>
<div class="panel-body">
    <div class="col-sm-6">
        <div class="form-row">
            <label class="name">Name<span class="required" aria-required="true"></span></label>
            <div class="inputs">
                <?php echo $this->Form->input('name', ['class' => 'form-control', 'label' => false, 'required' => true, 'type' =>'text' , 'autocomplete' =>'off' ] ) ?>
            </div>
        </div>
    </div>
    <div class="col-sm-6">
        <div class="form-row">
            <label class="name">Conference Code<span class="required" aria-required="true"></span></label>
            <div class="inputs">
                <?php echo $this->Form->input('slug', ['class' => 'form-control', 'label' => false, 'required' => true, 'readonly' =>true ]) ?>
            </div>
        </div>
    </div>
    <div class="col-sm-6">
        <div class="form-row">
            <label class="name">Conference Date<span class="required" aria-required="true"></span></label>
            <div class="inputs">
                <div class="input-group">
                    <input type="text" class="form-control date" name="conference_date" placeholder="DD/MM/YY" required="required" value="<?php echo $conference_date ?>">
                    <span class="input-group-addon">
                        <?php echo $this->Html->image('/css/admin_styles/images/icon-calender.png') ?>
                    </span>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-6">
        <div class="form-row">
            <label class="name">Start Time<span class="required" aria-required="true"></span></label>
            <div class="inputs">
                <?php echo $this->Form->input('start_time', ['class' => 'form-control time', 'label' => false, 'required' => true, 'type' =>'text']) ?>
            </div>
        </div>
    </div>
    <div class="col-sm-6">
        <div class="form-row">
            <label class="name">End Time<span class="required" aria-required="true"></span></label>
            <div class="inputs">
                <?php echo $this->Form->input('end_time', ['class' => 'form-control time', 'label' => false, 'required' => true, 'type' =>'text']) ?>
            </div>
        </div>
    </div>
    <div class="col-sm-6">
        <div class="form-row">
            <label class="name">Venue<span class="required" aria-required="true"></span></label>
            <div class="inputs">
                <?php echo $this->Form->input('venue_id', ['options' => $venues, 'class' => 'form-control', 'required' => true, 'label' => false, 'empty' => 'Select']) ?>
            </div>
        </div>
    </div>
    <div class="col-sm-6">
        <div class="form-row">
            <label class="name">Event<span class="required" aria-required="true"></span></label>
            <div class="inputs">
                <?php echo $this->Form->input('event_id', ['options' => $events, 'class' => 'form-control', 'required' => true, 'label' => false, 'empty' => 'Select']) ?>
            </div>
        </div>
    </div>
</div>