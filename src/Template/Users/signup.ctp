<!-- Frontend Signup Form -->
<div class="container signup-container form-boxed-container">
    <div class="row">
        <div class="col-sm-12">
            <?php echo $this->Flash->render('admin_success'); ?>
            <?php echo $this->Flash->render('admin_error'); ?>
        </div>
    </div>

    <?php echo $this->Form->create($user,array('id'=>'UserSignupForm','novalidate'=>'true')); ?>
    <header>
        <h2>Sign Up</h2>
    </header>
    <div class="form-inner-content">
        <div class="row">
            <div class="col-sm-6">
                <div class="form-group">
                    <label for="exampleInputEmail1">First Name<em>*</em></label>
                    <?php echo $this->Form->input('first_name',array('div'=>'false','class'=>'form-control','label'=>false,'required'=>true));?>
                </div>

                <div class="form-group">
                    <label for="exampleInputEmail1">Last Name<em>*</em></label>
                    <?php echo $this->Form->input('last_name',array('div'=>'false','class'=>'form-control','label'=>false,'required'=>true));?>
                </div>

                <div class="form-group">
                    <label for="exampleInputEmail1">Email address<em>*</em></label>
                    <?php echo $this->Form->input('email',array('label'=>false,'type'=>'email','required'=>true, 'div'=>false, 'class'=>'form-control', 'id'=>'field-email', 'label'=>false));?>
                </div>

                <div class="form-group">
                    <label style="display: block" for="exampleInputPassword1">Password<em>*</em><small class="pull-right">Minimum Length 8</small></label>
                    <?php echo $this->Form->input('password',array('div'=>'false','class'=>'form-control','label'=>false,'required'=>true,'minlength'=>8));?>
                </div>

                <div class="form-group">
                    <label for="exampleInputPassword1">Confirm Password<em>*</em></label>
                    <?php echo $this->Form->input('confirm_password',array('type'=>'password','div'=>'false','class'=>'form-control','label'=>false,'required'=>true,'minlength'=>8, 'equalTo'=>"#password"));?>
                </div>

                <div class="form-group">
                    <label for="exampleInputPassword1">Phone<em>*</em></label>
                    <?php echo $this->Form->input('phone',array('div'=>'false','class'=>'form-control','label'=>false,'required'=>true));?>
                </div>

            </div>

            <div class="col-sm-6">
                <div class="form-group">
                    <label for="exampleInputPassword1">Address Line1<em>*</em></label>
                    <?php echo $this->Form->input('address_line1',array('div'=>'false','class'=>'form-control','label'=>false,'required'=>true));?>
                </div>

                <div class="form-group">
                    <label for="exampleInputPassword1">Address Line2</label>
                    <?php echo $this->Form->input('address_line2',array('div'=>'false','class'=>'form-control','label'=>false));?>
                </div>

                <div class="form-group">
                    <label for="exampleInputPassword1">City<em>*</em></label>
                    <?php echo $this->Form->input('city',array('div'=>'false','class'=>'form-control','label'=>false,'required'=>true));?>
                </div>

                <div class="form-group">
                    <label for="exampleInputPassword1">State<em>*</em></label>
                    <?php echo $this->Form->input('state',array('div'=>'false','class'=>'form-control','label'=>false,'required'=>true));?>
                </div>

                <div class="form-group">
                    <label for="exampleInputPassword1">Country<em>*</em></label>
                    <?php echo $this->Form->input('country',array('default'=>'13','label'=>false,'div'=>'false','class'=>'form-control','type'=>'select','options'=>$country)); ?>
                </div>

                <div class="form-group">
                    <label for="exampleInputPassword1">Postcode<em>*</em></label>
                    <?php echo $this->Form->input('postcode',array('div'=>'false','class'=>'form-control','label'=>false,'required'=>true));?>
                </div>

            </div>
        </div>
    </div>

    <footer>
        <button type="submit" class="button">Submit</button>
    </footer>
    <?php echo $this->Form->end(); ?>
</div>

<?php echo $this->Html->css('jquery-ui/jquery-ui.css'); ?>
<script type="text/javascript">
    $(document).ready(function(){

        countryAutocomplete();

        $("#UserSignupForm").validate({
            rules:{
                'email':{
                    remote:{
                        url:SITE_URL + 'users/isUserAvailable',
                        type:'post',
                        data:{
                            email:function(){
                                return jQuery('#field-email').val()
                            }
                        }
                    },
                    required: true,
                    email: true
                }
            },
            messages:{
                "first_name": "Please enter your First Name",
                "last_name": "Please enter your Last Name",
                "password": "Please enter at least 8 characters.",
                "address_line1": "Please enter your Address",
                "city": "Please enter your City",
                "state": "Please enter your State",
                "country": "Please enter your Country",
                "postcode": "Please enter your Postcode",
                "phone": "Please enter Phone Number",
                "email":{
                    remote:'Email already used',
                    required:'Please enter your valid Email Address'
                },
                "confirm_password":{
                    equalTo:"Confirm Password didn't match with Password",
                    required:'This field is required'
                }
            }

        });

    });
</script>

