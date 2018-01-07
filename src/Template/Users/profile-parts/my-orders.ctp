
    <header>
        <h2>My Orders</h2>
    </header>
    <div class="form-inner-content">
        <table class="table table-hover">

            <?php if(!empty($user_orders)){ foreach($user_orders as $order){ ?>

                <thead>
                    <tr>
                        <th>Order Code</th>
                        <th>Date</th>
                        <th>Order Total</th>
                        <th>Shipping Cost</th>
                        <th>GST Amount</th>
                        <th>Details</th>
                    </tr>
                </thead>

                <tbody>


                        <tr>
                            <td><?php echo $order['order_code'] ?></td>
                            <td><?php echo date('d-m-Y',strtotime($order['date_purchased']));?></td>
                            <td>
                                <?php
                                    if(!empty($order['order_total'])){
                                        echo '$'.number_format((float)$order['order_total'], 2, '.', '');
                                    }
                                ?>
                            </td>
                            <td>
                                <?php
                                    if(!empty($order['shipping_cost'] )){
                                        echo '$'.number_format((float)$order['shipping_cost'], 2, '.', '');
                                    }
                                ?>
                            </td>
                            <td>
                                <?php
                                    if(!empty($order['gst_amount'])){
                                        echo '$'.number_format((float)$order['gst_amount'], 2, '.', '');
                                    }
                                ?>
                            </td>
                            <td><a href="<?php echo $this->Url->Build('/order-details/'.$order['id']); ?>"><i class="fa fa-eye"></i></a></td>
                        </tr>


                </tbody>

            <?php } } else { ?>

                <tr>
                    Order Unavailable.
                </tr>

            <?php }  ?>

        </table>
    </div>
    <footer></footer>

