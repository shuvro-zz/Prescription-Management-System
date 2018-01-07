<!-- Frontend user profile Form -->


<div class="container profile-container form-boxed-container">
    <div class="row">
        <div class="col-md-12">
            <?php echo $this->Flash->render('admin_success'); ?>
            <?php echo $this->Flash->render('admin_error'); ?>
        </div>
    </div>


        <ul class="nav nav-tabs">
            <li class="active"><a data-toggle="tab" href="#profile">Profile</a></li>
            <li><a data-toggle="tab" href="#change_password">Change Password</a></li>
            <li><a data-toggle="tab" href="#my_orders">My Orders</a></li>
        </ul>

        <div class="tab-content">

            <div id="profile" class="tab-pane fade in active">
                <?php include('profile-parts/users-profile.ctp'); ?>
            </div>

            <div id="change_password" class="tab-pane fade">
                <?php include('profile-parts/change-password.ctp'); ?>
            </div>

            <div id="my_orders" class="tab-pane fade">
                <?php include('profile-parts/my-orders.ctp'); ?>
            </div>

        </div>

</div>

<?php echo $this->Html->css('jquery-ui/jquery-ui.css'); ?>
<script type="text/javascript">
    $(document).ready(function(){

        var tab = getParameterByName('tab');
        activaTab(tab);

        function activaTab(tab){
            $('.nav-tabs a[href="#' + tab + '"]').tab('show');
        };

        function getParameterByName(name) {
            name = name.replace(/[\[]/, "\\[").replace(/[\]]/, "\\]");
            var regex = new RegExp("[\\?&]" + name + "=([^&#]*)");
            var results = regex.exec(location.search);
            return results === null ? "" : decodeURIComponent(results[1].replace(/\+/g, " "));
        }

        countryAutocomplete();

        $("#edit-profile-form").validate({
            rules:{
                "first_name": "required",
                "last_name": "required",
                "phone": "required",
                "billing_address_line1": "required",
                "billing_city": "required",
                "billing_state": "required",
                "billing_country": "required",
                "billing_postcode": "required",
                "shipping_address_line1": "required",
                "shipping_city": "required",
                "shipping_state": "required",
                "shipping_country": "required",
                "shipping_postcode": "required",
            },
            messages:{
                "first_name": "Please enter your First Name",
                "last_name": "Please enter your Last Name",
                "phone": "Please enter Phone Number",
                "email":{
                    remote:'Email already used',
                    required:'Please enter your valid Email Address'
                },
                "billing_address_line1": "Please enter your Billing Address",
                "billing_city": "Please enter your Billing City",
                "billing_state": "Please enter your Billing State",
                "billing_country": "Please enter your Billing Country",
                "billing_postcode": "Please enter your Billing Postcode",
                "shipping_address_line1": "Please enter your Shipping Address",
                "shipping_city": "Please enter your Shipping City",
                "shipping_state": "Please enter your Shipping State",
                "shipping_country": "Please enter your Shipping Country",
                "shipping_postcode": "Please enter your Shipping Postcode",

            }

        });

    });
</script>

