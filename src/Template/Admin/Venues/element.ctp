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
                <?php echo $this->Form->input('slug', ['class' => 'form-control', 'label' => false, 'required' => true, 'readonly' =>true ]) ?>
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
            <label class="name">State<span class="required" aria-required="true"></span></label>
            <div class="inputs">
                <?php echo $this->Form->input('state', ['class' => 'form-control', 'label' => false, 'required' => true, 'type' =>'text']) ?>
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
            <label class="name">Country<span class="required" aria-required="true"></span></label>
            <div class="inputs">
                <?php echo $this->Form->input('country_id', ['options' => $countries, 'class' => 'form-control', 'required' => true, 'label' => false, 'empty' => 'Select']) ?>
            </div>
        </div>
    </div>
</div>