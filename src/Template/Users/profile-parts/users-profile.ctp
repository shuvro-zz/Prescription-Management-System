<?php echo $this->Form->create($user,array('id'=>'edit-profile-form','novalidate'=>'true')); ?>
    <header>
        <h2>Edit Profile</h2>
    </header>
    <div class="form-inner-content">
        <div class="row">
            <div class="col-sm-12"><h3>Profile Information</h3></div>
            <div class="col-sm-12">
                <div class="form-group">
                    <label for="exampleInputEmail1">First Name*</label>
                    <?php echo $this->Form->input('first_name',array('div'=>'false','class'=>'form-control','label'=>false,'required'=>true));?>
                </div>

                <div class="form-group">
                    <label for="exampleInputEmail1">Last Name*</label>
                    <?php echo $this->Form->input('last_name',array('div'=>'false','class'=>'form-control','label'=>false,'required'=>true));?>
                </div>

                <div class="form-group">
                    <label for="exampleInputPassword1">Email*</label>
                    <?php echo $this->Form->input('email',array('div'=>'false','class'=>'form-control','label'=>false, 'readonly'=>'readonly'));?>
                </div>

                <div class="form-group">
                    <label for="exampleInputPassword1">Phone*</label>
                    <?php echo $this->Form->input('phone',array('div'=>'false','class'=>'form-control','label'=>false, 'required'=>true));?>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-6">
                <h3>Billing Information</h3>
                <?php echo $this->Form->input('billing_id',array('type'=>'hidden'));?>

                <div class="form-group">
                    <label for="exampleInputPassword1">Address Line1*</label>
                    <?php echo $this->Form->input('billing_address_line1',array('div'=>'false','class'=>'form-control','label'=>false,'required'=>true));?>
                </div>

                <div class="form-group">
                    <label for="exampleInputPassword1">Address Line2*</label>
                    <?php echo $this->Form->input('billing_address_line2',array('div'=>'false','class'=>'form-control','label'=>false,'required'=>true));?>
                </div>

                <div class="form-group">
                    <label for="exampleInputPassword1">City*</label>
                    <?php echo $this->Form->input('billing_city',array('div'=>'false','class'=>'form-control','label'=>false,'required'=>true));?>
                </div>

                <div class="form-group">
                    <label for="exampleInputPassword1">State*</label>
                    <?php echo $this->Form->input('billing_state',array('div'=>'false','class'=>'form-control','label'=>false,'required'=>true));?>
                </div>

                <div class="form-group">
                    <label for="exampleInputPassword1">Country*</label>
                    <?php echo $this->Form->input('billing_country',array('label'=>false,'div'=>'false','class'=>'form-control','type'=>'select','options'=>$country)); ?>
                </div>

                <div class="form-group">
                    <label for="exampleInputPassword1">Postcode*</label>
                    <?php echo $this->Form->input('billing_postcode',array('div'=>'false','class'=>'form-control','label'=>false,'required'=>true));?>
                </div>

            </div>

            <div class="col-sm-6">
                <h3>Shipping Information</h3>
                <?php echo $this->Form->input('shipping_id',array('type'=>'hidden'));?>

                <div class="form-group">
                    <label for="exampleInputPassword1">Address Line1*</label>
                    <?php echo $this->Form->input('shipping_address_line1',array('div'=>'false','class'=>'form-control','label'=>false,'required'=>true));?>
                </div>

                <div class="form-group">
                    <label for="exampleInputPassword1">Address Line2*</label>
                    <?php echo $this->Form->input('shipping_address_line2',array('div'=>'false','class'=>'form-control','label'=>false,'required'=>true));?>
                </div>

                <div class="form-group">
                    <label for="exampleInputPassword1">City*</label>
                    <?php echo $this->Form->input('shipping_city',array('div'=>'false','class'=>'form-control','label'=>false,'required'=>true));?>
                </div>

                <div class="form-group">
                    <label for="exampleInputPassword1">State*</label>
                    <?php echo $this->Form->input('shipping_state',array('div'=>'false','class'=>'form-control','label'=>false,'required'=>true));?>
                </div>

                <div class="form-group">
                    <label for="exampleInputPassword1">Country*</label>
                    <?php echo $this->Form->input('shipping_country',array('label'=>false,'div'=>'false','class'=>'form-control','type'=>'select','options'=>$country)); ?>
                </div>

                <div class="form-group">
                    <label for="exampleInputPassword1">Postcode*</label>
                    <?php echo $this->Form->input('shipping_postcode',array('div'=>'false','class'=>'form-control','label'=>false,'required'=>true));?>
                </div>
            </div>
        </div>
    </div>
    <footer>
        <button type="submit" class="button">Submit</button>
    </footer>
<?php echo $this->Form->end(); ?>