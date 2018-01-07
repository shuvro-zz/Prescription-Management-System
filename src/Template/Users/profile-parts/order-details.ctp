<div class="container">
<div class="row">
    <div class="col-md-12">

        <div class="invoice-wrap">

            <div class="clearfix invoice-head">
                <h3 class="brand-logo text-uppercase text-bold left mt15">
                    Order Details
                </h3>
                <div class="group clearfix right">
                    <a href="<?php echo $this->Url->Build('/profile'); ?>" class="button">Back to Profile</a>
                </div>
            </div>

            <div class="row">

                <div class="col-sm-6">
                    <div class="panel mb20 panel-default panel-hovered panel-stacked">
                        <div class="panel-heading">Customer Information</div>
                        <div class="panel-body">
                            <p><b>Name:</b> <?php echo $customer_info['first_name'].' '.$customer_info['last_name'];?></p>
                            <p><b>Email:</b> <?php echo $customer_info['email'];?></p>
                            <p><b>Phone:</b> <?php echo $customer_info['phone'];?></p>
                            <?php if(!empty($billing_country)){ ?>
                                <p><b>Country:</b> <?php echo $billing_country;?></p>
                            <?php } ?>
                            <p><b>City:</b> <?php echo $customer_info['billing_city'];?></p>
                            <p><b>State:</b> <?php echo $customer_info['billing_state'];?></p>
                            <p><b>Postcode:</b> <?php echo $customer_info['billing_postcode'];?></p>
                        </div>
                    </div>
                </div>

                <div class="col-sm-6">
                    <div class="panel mb20 panel-default panel-hovered panel-stacked">
                        <div class="panel-heading">Order Information</div>
                        <div class="panel-body">
                            <div class="address-title">
                                <p><b>Order Code: </b><?php echo $order['order_code']?></p>
                                <p><b>Date:  </b><?php echo date('d/m/Y',strtotime($order['date_purchased']));?></p>
                                <p><b>Status:  </b><?php echo $order['order_status'];?></p>
                                <p><b>Shipping Type:  </b><?php
                                    if($customer_info['billing_country_id'] == 13 ){
                                        echo 'Local';
                                    } else {
                                        echo 'International';
                                    }
                                    ?>
                                </p>
                                <?php if(!empty($order['coupon_code'])){ ?>
                                    <p class="text-bold mb5">Coupon Code:  <?php echo $order['coupon_code'];?></p>
                                <?php } ?>
                                <p><b>Shipping Cost: </b>$<?php echo $order['shipping_cost']?></p>
                                <p><b>Grand Total: </b>$<?php echo $order['order_total']?></p>

                            </div>
                        </div>
                    </div>
                </div>

            </div>

            <div class="row">

                <div class="col-sm-6">
                    <div class="panel mb20 panel-default panel-hovered panel-stacked">
                        <div class="panel-heading">Billing Information</div>
                        <div class="panel-body">
                            <p><b>Name:</b> <?php echo $customer_info['billing_first_name'].' '.$customer_info['billing_last_name'];?></p>
                            <p><b>Company:</b> <?php echo $customer_info['billing_company'];?></p>
                            <p><b>Address Line1:</b> <?php echo $customer_info['billing_address_line1'];?></p>
                            <?php if(!empty($customer_info['billing_address_line2'])){ ?>
                            <p><b>Address Line2:</b> <?php echo $customer_info['billing_address_line2'];?></p>
                            <?php } ?>
                            <p><b>Country:</b> <?php echo $billing_country;?></p>
                            <p><b>City:</b> <?php echo $customer_info['billing_city'];?></p>
                            <p><b>State:</b> <?php echo $customer_info['billing_state'];?></p>
                            <p><b>Postcode:</b> <?php echo $customer_info['billing_postcode'];?></p>
                        </div>
                    </div>
                </div>

                <div class="col-sm-6">
                    <div class="panel mb20 panel-default panel-hovered panel-stacked">
                        <div class="panel-heading">Shipping Information</div>
                        <div class="panel-body">
                            <p><b>Name:</b> <?php echo $customer_info['shipping_first_name'].' '.$customer_info['shipping_last_name'];?></p>
                            <p><b>Company:</b> <?php echo $customer_info['shipping_company'];?></p>
                            <p><b>Address Line1:</b> <?php echo $customer_info['shipping_address_line1'];?></p>
                            <?php if(!empty($customer_info['shipping_address_line2'])){ ?>
                            <p><b>Address Line2:</b> <?php echo $customer_info['shipping_address_line2'];?></p>
                            <?php } ?>
                            <p><b>Country:</b> <?php echo $shipping_country;?></p>
                            <p><b>City:</b> <?php echo $customer_info['shipping_city'];?></p>
                            <p><b>State:</b> <?php echo $customer_info['shipping_state'];?></p>
                            <p><b>Postcode:</b> <?php echo $customer_info['shipping_postcode'];?></p>
                        </div>
                    </div>
                </div>

            </div>


            <table class="table table-bordered invoice-table mb30">
                <thead>
                <tr>
                    <th>#</th>
                    <th>Image</th>
                    <th>Product Name</th>
                    <th>Attributes</th>
                    <th>Quantity</th>
                    <th>Unit Price</th>
                    <th>Total</th>
                </tr>
                </thead>

                <tbody>
                <?php if(!empty($order['products'])){ $i=1;
                    foreach($order['products'] as $product){ ?>
                        <tr>
                            <td><?php echo $i; ?></td>
                            <td>
                                <img width="200" height="200" src="<?php echo $this->Url->Build('/img/uploads/'.$product['large_image'],true);?>">
                            </td>
                            <td>
                                <?php echo $product['title']?>
                            </td>
                            <td>

                                <p><b>Metal:</b> <?php echo $product['metal'];?></p>

                                <?php if(!empty($product['finish'])){ ?>
                                    <p><b>Finish:</b> <?php echo $product['finish'];?></p>
                                <?php } ?>

                                <?php if(!empty($product['stone'])){ ?>
                                    <p><b>Stone:</b> <?php echo $product['stone'];?></p>
                                <?php } ?>

                                <?php if(!empty($product['stone_cut'])){ ?>
                                    <p><b>Stone Cut:</b> <?php echo $product['stone_cut'];?></p>
                                <?php } ?>

                                <p><b>Size:</b> <?php echo $product['size']; ?></p>
                                <p><b>Year:</b> <?php echo $product['year']; ?></p>

                                <?php if(!empty($product['degree_information'])){ ?>
                                    <p><b>Degree Information:</b> <?php echo $product['degree_information'];?></p>
                                <?php } ?>

                                <?php if(!empty($product['inside_engraving'])){ ?>
                                    <p><b>Inside Engraving:</b> <?php echo $product['inside_engraving'];?></p>
                                <?php } ?>

                            </td>
                            <td><?php echo $product['quantity']?></td>
                            <td><?php echo '$'.$product['price']?></td>
                            <td><?php echo '$'.$product['total']?></td>
                        </tr>
                    <?php $i++; } }?>
                </tbody>
            </table>

            <div class="row">
                <div class="col-sm-12">
                    <div class="panel mb20 panel-default panel-hovered panel-stacked">
                        <div class="panel-heading">Order Summary</div>
                        <div class="panel-body">
                            <div class="cart-summary-section">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="shopping-cart-totals pull-right">

                                            <table id="shopping-cart-totals-table">
                                                <tbody>

                                                <tr>
                                                    <td><b>Subtotal:</b></td>
                                                    <td><b>$<?php echo number_format((float)$order['order_sub_total'], 2, '.', '') ?></b></td>
                                                </tr>

                                                <tr>
                                                    <td><b>GST:</b></td>
                                                    <td><b>$<?php echo number_format((float)$order['gst_amount'], 2, '.', '') ?></b></td>
                                                </tr>

                                                <?php if(!empty($order['coupon_amount']) && $order['coupon_amount'] != '0.00'){ ?>
                                                    <tr>
                                                        <td><b>Coupon Amount:</b></td>
                                                        <td><b>$<?php echo number_format((float)$order['coupon_amount'], 2, '.', '') ?></b></td>
                                                    </tr>
                                                <?php } ?>

                                                <tr>
                                                    <td><b>Shipping Cost:</b></td>
                                                    <td><b>$<?php echo number_format((float)$order['shipping_cost'], 2, '.', '') ?></b></td>
                                                </tr>

                                                <tr class="g-total">
                                                    <td><b>Grand Total Incl. GST:</b></td>
                                                    <td><b>$<?php echo number_format((float)$order['order_total'], 2, '.', '') ?></b></td>
                                                </tr>

                                                </tbody>
                                            </table>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>

    </div>
</div>
</div>