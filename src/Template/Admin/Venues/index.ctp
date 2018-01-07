<div class="workspace-dashboard page page-ui-tables">
    <div class="page-heading">
        <div class="flex-container">
            <div class="flex-item"><h4><?= __('Venues') ?></h4></div>
            <div class="flex-item">
                <div class="flex-container">
                    <a href="#" class="btn btn-danger" title="Delete Conference" onclick="if (confirm('Are you sure you want to delete?')) { document.form_bulk_delete.submit(); } event.returnValue = false; return false;"><span class="fa fa-trash"></span> Delete</a>
                    <?php
                    echo '&nbsp;&nbsp;';
                    echo $this->Html->link(
                        '<span class="icon">+</span> Add Venue',
                        ['action' => 'add'],
                        ['class' => 'add-event-btn', 'escapeTitle' => false, 'title' => 'Add Venue']
                    )
                    ?>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-12">
        <?php echo $this->Flash->render('admin_success'); ?>
        <?php echo $this->Flash->render('admin_error'); ?>
        <?php echo $this->Flash->render('admin_warning'); ?>
    </div>
    <div class="event-listing">
        <div class="event-listing-top flex-container status-function">
            <div class="status-area flex-container">
                <div class="event-src-box">
                    <?php echo $this->Form->create('Venues',['type' => 'get'],array('id' => 'site-search','url'=>array('action'=>'index'),'method'=>'get'));?>
                    <?php echo $this->Form->input('search',array('class' => 'form-control', 'label' => false, 'placeholder' => 'Type here for search...', 'value' => $search ) ) ?>
                    <button type="submit"> <i class="fa fa-search"></i></button>
                    <?php echo $this->Form->end();?>
                </div>
            </div>
        </div>
        <div class="table-responsive table-part">
            <table class="table table-hover  table-striped">
                <thead>
                    <tr>
                        <th><?= $this->Paginator->sort('name') ?></th>
                        <th><?= $this->Paginator->sort('slug') ?></th>
                        <th><?= $this->Paginator->sort('post_code') ?></th>
                        <th><?= $this->Paginator->sort('state') ?></th>
                        <th><?= $this->Paginator->sort('city') ?></th>
                        <th><?= $this->Paginator->sort('country_id') ?></th>
                        <th class="actions"><?= __('Actions') ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php $bulk_delete_fields = '' ?>
                    <?php foreach ($venues as $venue){ ?>
                        <?php $bulk_delete_fields .= '<input type="hidden" name="ids[]" id="bulk-delete-id-'.$venue->id.'" />' ?>
                    <tr>
                            <td><label><input type="checkbox" value="<?= $venue->id ?>"  class="bulk-delete"> &nbsp; <?= h($venue->name) ?></label></td>
                            <td><?= h($venue->slug) ?></td>
                            <td><?= h($venue->post_code) ?></td>
                            <td><?= h($venue->state) ?></td>
                            <td><?= h($venue->city) ?></td>
                            <td><?= h($venue->country->name) ?></td>
                            <td class="actions" style="width: 204px;">
                                <div class="dropdown action-button">
                                    <span class="dropdown-toggle event-action" type="button" data-toggle="dropdown" >
                                        <?php echo $this->Html->image('/css/admin_styles/images/dashboard-settings-sm.png', ['alt' => 'Settings']) ?>
                                    </span>
                                    <ul class="dropdown-menu action-dropdown">
                                        <li>
                                            <?php
                                            echo $this->Html->link(
                                            '<span class="fa fa-pencil-square"></span> Edit',
                                            ['action' => 'edit', $venue->id],
                                            ['escapeTitle' => false, 'title' => 'Edit Venue']
                                            );
                                            ?>
                                        </li>
                                        <li>
                                            <?php
                                            echo $this->Form->postLink(
                                            '<span class="fa fa-trash"></span> Delete',
                                            ['action' => 'delete', $venue->id],
                                            ['escapeTitle' => false, 'title' => 'Delete Venue','confirm' => __('Are you sure you want to delete # {0}?', $venue->id)]
                                            );
                                            ?>
                                        </li>
                                    </ul>
                                </div>
                            </td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
            <?php
            echo $this->Form->create('Venues', ['url' => ['action' => 'bulk-delete' ], 'name' => 'form_bulk_delete' ] );
            echo $bulk_delete_fields;
            echo $this->Form->end();
            ?>
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
