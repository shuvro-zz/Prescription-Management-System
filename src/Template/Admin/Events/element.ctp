<?php
        $start_date = (isset($event) and trim($event['start_date'])!='') ? $this->Common->getDate( $event['start_date'] ): '';
        $end_date = (isset($event) and trim($event['end_date'])!='') ? $this->Common->getDate( $event['end_date'] ): '';
?>

<div class="panel-body">
    <div class="col-sm-6">
        <div class="form-row">
            <label class="name">Name<span class="required" aria-required="true"></span></label>
            <div class="inputs">
                <?php echo $this->Form->input('name', ['class' => 'form-control', 'label' => false, 'required' => true, 'type' =>'text', 'autocomplete' =>'off' ]) ?>
            </div>
        </div>
    </div>
    <div class="col-sm-6">
        <div class="form-row">
            <label class="name">Slug<span class="required" aria-required="true"></span></label>
            <div class="inputs">
                <?php echo $this->Form->input('slug', ['class' => 'form-control', 'label' => false, 'required' => true, 'readonly' => true ] ) ?>
            </div>
        </div>
    </div>
    <div class="col-sm-6">
        <div class="form-row">
            <label class="name">Start Date<span class="required" aria-required="true"></span></label>
            <div class="inputs">
                <div class="input-group">
                    <input type="text" class="form-control date" name="start_date" placeholder="DD/MM/YY" required="required" value="<?php echo $start_date ?>">
                    <span class="input-group-addon">
                        <?php echo $this->Html->image('/css/admin_styles/images/icon-calender.png') ?>
                    </span>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-6">
        <div class="form-row">
            <label class="name">End Date<span class="required" aria-required="true"></span></label>
            <div class="inputs">
                <div class="input-group">
                    <input type="text" class="form-control date" name="end_date" placeholder="DD/MM/YY" required="required" value="<?php echo $end_date ?>">
                    <span class="input-group-addon">
                        <?php echo $this->Html->image('/css/admin_styles/images/icon-calender.png') ?>
                    </span>
                </div>
            </div>
        </div>
    </div>
</div>