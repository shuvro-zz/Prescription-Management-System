<div class="workspace-dashboard page page-ui-tables">
    <div class="page-heading">
        <div class="flex-container">
            <div class="flex-item"><h4>Users</h4></div>
            <div class="flex-item">

                <?php echo $this->Html->link(
                    '<span class="icon">+</span> Add New',
                    ['action' => 'add'],
                    ['class' => 'add-event-btn', 'escapeTitle' => false, 'title' => 'Add Organisation']
                ) ?>
            </div>
        </div>
    </div>

    <div class="col-md-12">
        <?php echo $this->Flash->render('admin_success'); ?>
        <?php echo $this->Flash->render('admin_error'); ?>
    </div>



        <div class="event-listing">
        <div class="event-listing-top flex-container status-function">
            <div class="status-area flex-container">

                <div class="event-src-box">
                    <?php echo $this->Form->create('Universities',['type' => 'get'],array('id' => 'site-search','url'=>array('action'=>'index'),'method'=>'get'));?>

                    <div class="input text" style="margin-right:10px">
                        <select name="field" class="form-control" style="height:29px" placeholder="All Column" autocomplete="off">
                            <option value="" selected="selected">Search Column</option><option value="invoice_no">Remittance No</option><option value="invoice_date">Remittance Date</option><option value="paid_date">Paid Date</option><option value="paid_status">Status</option>
                        </select>
                    </div>

                    <?php echo $this->Form->input('search',array('class' => 'form-control', 'label' => false, 'placeholder' => 'Type here for search...')); ?>
                    <button type="submit"> <i class="fa fa-search"></i></button>

                    <?php echo $this->Form->end();?>
                </div>

            </div>
        </div>
        <div class="table-responsive table-part">
            <table class="table table-hover  table-striped">
                <thead>
                <tr>
                    <th>id</th>
                    <th>name</th>
                    <th>status</th>

                    <th class="actions"><?php echo __('Actions') ?></th>
                </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>1&nbsp;</td>
                        <td>Mizan&nbsp;</td>
                        <td class="event-status-section">
                            <?php if(1==1){ ?>
                                <i class="fa fa-check event-status1" style="color: #00ff00"></i>
                            <?php } else { ?>
                                <i class="fa fa-remove event-status1" style="color: #ff3300"></i>
                            <?php } ?>
                        </td>

                        <td class="actions" style="width: 204px;">
                            <div class="dropdown action-button">
                                <span class="dropdown-toggle event-action" type="button" data-toggle="dropdown" >
                                    <?php echo $this->Html->image('/css/admin_styles/images/dashboard-settings-sm.png', ['alt' => 'Settings']) ?>
                                </span>
                                <ul class="dropdown-menu action-dropdown">
                                    <li>
                                        <div class="action-list">
                                            <span data-toggle="modal" data-target="#billingModal" data-billing-id="1">
                                                <a><i class="fa fa-eye" aria-hidden="true"></i></a> View
                                            </span>
                                        </div>
                                    </li>
                                    <li>
                                        <?php
                                            echo $this->Html->link(
                                                '<span class="fa fa-pencil-square"></span> Edit',
                                                ['action' => 'edit', 1],
                                                ['escapeTitle' => false, 'title' => 'Edit Venue']
                                            );
                                        ?>
                                    </li>
                                    <li>
                                        <?php
                                            echo $this->Form->postLink(
                                                '<span class="fa fa-trash"></span> Delete',
                                                ['action' => 'delete', 1],
                                                ['escapeTitle' => false, 'title' => 'Delete Coupon','confirm' => __('Are you sure you want to delete # {0}?', 1)]
                                            );
                                        ?>
                                    </li>
                                </ul>
                            </div>

                        </td>
                    </tr>
                </tbody>
            </table>

        </div>
        <div class="bottom-pagination">
            <div class="pagination-area flex-container">
                <div class="pagination-status-text">
                    Showing <?php echo $this->Paginator->counter() ?> entries
                </div>
                <ul class="pagination">
                    <?php
                    if($this->Paginator->numbers()) {
                        echo $this->Paginator->prev('< ' . __(''));
                        echo $this->Paginator->numbers();
                        echo $this->Paginator->next(__('') . ' >');
                    }
                    ?>
                </ul>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal modal-for-add-bill fade" id="billingModal" tabindex="-1" role="dialog" aria-labelledby="billing-modal">
    <div class="modal-dialog" role="document">
        <div class="modal-content modal-body">
            <?php echo $this->Form->create('Billings',array('id' => 'billing-form','method'=>'post', 'onsubmit'=>'return validatePopup()'));?>
            <div class="add-bill-header">
                <button class="close pull-right" type="button" style="display: inline-block;z-index:99;position: relative;width: auto;height: auto; min-width: auto;" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
                <h5>Create Bill</h5>
            </div>
            <div class="row"  id="invoice_no_row" >
                <div class="form-row col-sm-6">
                    <label for="name">Invoice NO</label>
                    <div class="inputs">
                        <input class="form-control"  type="text" value=""   id="invoice_no" readonly="readonly" disabled="disabled">
                    </div>
                </div>
                <div class="form-row col-sm-6">
                    <label for="name">Invoice Date</label>
                    <div class="inputs">
                        <input class="form-control"  type="text" value="" id="invoice_date" readonly="readonly" disabled="disabled">
                    </div>
                </div>
            </div>

            <div class="row" id="action-row">
                <div class="form-row col-sm-6" id="charged">
                    <button type="submit" >Charged</button>
                </div>
                <div class="form-row col-sm-6">
                    <button type="button" data-dismiss="modal">Cancel</button>
                </div>
            </div>
            <?php echo $this->Form->end();?>
        </div>
    </div>
</div>