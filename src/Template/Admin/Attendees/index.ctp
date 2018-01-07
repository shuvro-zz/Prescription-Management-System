<div class="workspace-dashboard page page-ui-tables">
    <div class="page-heading">
        <div class="flex-container">
            <div class="flex-item"><h4><?= __('Attendees') ?></h4></div>
            <div class="flex-item">
                <div class="flex-container">
                    <a href="#" class="btn btn-danger" title="Delete" onclick="if (confirm('Are you sure you want to delete?')) { document.form_bulk_delete.submit(); } event.returnValue = false; return false;"><span class="fa fa-trash"></span> Delete</a>
                    <?php
                    echo '&nbsp;&nbsp;';
                    echo $this->Html->link(
                        '<span class="icon">+</span> Add Attendee',
                        ['action' => 'add'],
                        ['class' => 'add-event-btn', 'escapeTitle' => false, 'title' => 'Add Attendee']
                    );
                    echo '&nbsp;&nbsp;';
                    echo $this->Html->link(
                        'Attendee Types',
                        ['controller' => 'AttendeeTypes'],
                        ['class' => 'add-event-btn', 'escapeTitle' => false, 'title' => 'Attendee Types']
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
                    <?php echo $this->Form->create('Attendees',['type' => 'get'],array('id' => 'site-search','url'=>array('action'=>'index'),'method'=>'get'));?>
                    <?php echo $this->Form->input('search',array('class' => 'form-control', 'label' => false, 'placeholder' => 'Type here for search...', 'value' => $search )); ?>
                    <button type="submit"> <i class="fa fa-search"></i></button>
                    <?php echo $this->Form->end();?>
                </div>
            </div>
        </div>
        <div class="table-responsive table-part">
            <table class="table table-hover  table-striped">
                <thead>
                    <tr>
                        <th><?= $this->Paginator->sort('first_name') ?></th>
                        <th><?= $this->Paginator->sort('surname') ?></th>
                        <th><?= $this->Paginator->sort('email') ?></th>
                        <th><?= $this->Paginator->sort('dob','Date of Birth') ?></th>
                        <th><?= $this->Paginator->sort('mobile') ?></th>
                        <th><?= $this->Paginator->sort('telephone') ?></th>
                        <th><?= $this->Paginator->sort('address_line1') ?></th>
                        <th class="actions"><?= __('Actions') ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php $bulk_delete_fields = '' ?>
                    <?php foreach ($attendees as $attendee){ ?>
                    <?php $bulk_delete_fields .= '<input type="hidden" name="ids[]" id="bulk-delete-id-'.$attendee->id.'" />' ?>
                    <tr>
                        <td><label><input type="checkbox" value="<?= $attendee->id ?>"  class="bulk-delete"> &nbsp; <?= h($attendee->first_name) ?></label></td>
                        <td><?= h($attendee->surname) ?></td>
                        <td><?= h($attendee->email) ?></td>
                        <td><?= h($attendee->dob) ?></td>
                        <td><?= h($attendee->mobile) ?></td>
                        <td><?= h($attendee->telephone) ?></td>
                        <td><?= h($attendee->address_line1) ?></td>
                        <td class="actions" style="width: 204px;">
                            <div class="dropdown action-button">
                                <span class="dropdown-toggle event-action" type="button" data-toggle="dropdown" >
                                    <?php echo $this->Html->image('/css/admin_styles/images/dashboard-settings-sm.png', ['alt' => 'Settings']) ?>
                                </span>
                                <ul class="dropdown-menu action-dropdown">
                                    <li>
                                        <?php
                                        echo $this->Html->link(
                                        '<span class="fa fa-eye"></span> View',
                                        ['action' => 'view', $attendee->id],
                                        ['escapeTitle' => false, 'title' => 'View Attendee']
                                        );
                                        ?>
                                    </li>
                                    <li>
                                        <?php
                                        echo $this->Html->link(
                                        '<span class="fa fa-pencil-square"></span> Edit',
                                        ['action' => 'edit', $attendee->id],
                                        ['escapeTitle' => false, 'title' => 'Edit Attendee']
                                        );
                                        ?>
                                    </li>
                                    <li>
                                        <?php
                                        echo $this->Form->postLink(
                                        '<span class="fa fa-trash"></span> Delete',
                                        ['action' => 'delete', $attendee->id],
                                        ['escapeTitle' => false, 'title' => 'Delete Attendee','confirm' => __('Are you sure you want to delete # {0}?', $attendee->id)]
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
            echo $this->Form->create('Attendees', ['url' => ['action' => 'bulk-delete' ], 'name' => 'form_bulk_delete' ] );
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
