<?php

use Cake\Core\Configure;

?>

<div class="workspace-dashboard page page-ui-tables">
    <div class="page-heading">
        <div class="flex-container">
            <div class="flex-item"><h4><?= __('Future Appointments') ?></h4></div>

            <div class="flex-item">
                <div class="flex-container">
                    <?php
                        echo $this->Html->link(
                            '<span class="icon">+</span> Add Appointments',
                            ['controller' => 'users', 'action' => 'add'],
                            ['class' => 'add-event-btn', 'escapeTitle' => false]
                        );
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
                    <?php echo $this->Form->create('Users',['type' => 'get'],array('id' => 'site-search','url'=>array('action'=>'index'),'method'=>'get'));?>

                    <span class="pull-left"><label>Filter :</label></span>

                    <span class="appointment_date_search">
                        <?php echo $this->Form->input('appointment_date',array('class' => 'form-control appointment_calender_date appointment_calender_date_search', 'value'  => $appointment_date, 'autocomplete' => 'off', 'label' => false, 'placeholder' => 'Appointment date')); ?>
                    </span>

                    <?php echo $this->Form->input('search',array('class' => 'form-control', 'value'  => $search, 'label' => false, 'placeholder' => 'Type here for search...')); ?>
                    <button type="submit"> <i class="fa fa-search"></i></button>
                    <div class="flex-container">
                        <?php
                            echo $this->Html->link(
                                'Reset',
                                ['action' => 'reset'],
                                ['class' => 'btn btn-default waves-effect btn-cancel', 'escapeTitle' => false]
                            );
                        ?>
                    </div>
                    <?php echo $this->Form->end();?>
                </div>
            </div>
        </div>

        <div class="table-responsive table-part">
            <table class="table table-hover  table-striped">
                <thead>
                <tr>
                    <th><?= $this->Paginator->sort('serial no') ?></th>
                    <th><?= $this->Paginator->sort('name') ?></th>
                    <th><?= $this->Paginator->sort('weight') ?></th>
                    <th><?= $this->Paginator->sort('phone') ?></th>
                    <th><?= $this->Paginator->sort('email') ?></th>
                    <th><?= $this->Paginator->sort('age', 'Age/Years') ?></th>
                    <?php if( $this->request->session()->read('Auth.User.role_id') == 1){ ?>
                        <th><?= $this->Paginator->sort('expire date') ?></th>
                    <?php } ?>
                    <th><?= $this->Paginator->sort('appointment') ?></th>
                    <th><?= $this->Paginator->sort('created') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($users as $user): ?>
                    <tr>
                        <td><?= h($user->serial_no) ?></td>
                        <td><?= ucfirst(h($user->first_name )) ?></td>
                        <td><?= h($user->weight) ?></td>
                        <td><?= h($user->phone) ?></td>
                        <td><?= h($user->email) ?></td>
                        <td><?= h($user->age) ?></td>
                        <?php if( $this->request->session()->read('Auth.User.role_id') == 1){ ?>
                            <td><?= h($user->expire_date) ?></td>
                        <?php } ?>
                        <td><?= h($user->appointment_date->format('d/m/Y')) ?></td>
                        <td><?= h($user->created->format('d/m/Y')) ?></td>
                        <td class="actions" style="width: 204px;">
                            <div class="dropdown action-button">
                            <span class="dropdown-toggle event-action" type="button" data-toggle="dropdown" >
                                <?php echo $this->Html->image('/css/admin_styles/images/dashboard-settings-sm.png', ['alt' => 'Settings']) ?>
                            </span>
                                <ul class="dropdown-menu action-dropdown">
                                    <?php
                                        if($this->request->session()->read('Auth.User.role_id') != 1){
                                            echo "<li>";
                                            echo $this->Html->link(
                                                '<i class="fa fa-calendar" aria-hidden="true"></i> Appointments',
                                                ['action' => '#0'],
                                                ['escapeTitle' => false, 'onclick' => "setAppointmentUserId(this)", 'user_id' => $user->id, 'title' => 'Add to today\'s Appointment', 'data-toggle' => 'modal',
                                                    'data-target' => '#serial-no-modal', 'type' => 'button'
                                                ]
                                            );
                                            echo "</li>";

                                            echo "<li>";
                                                echo $this->Html->link(
                                                    '<span class="fa fa-plus"></span> Create Prescription',
                                                    ['controller' => 'prescriptions', 'action' => 'add/'.$user->id],
                                                    ['escapeTitle' => false, 'title' => 'Create Prescription']
                                                );
                                            echo "</li>";

                                            echo "<li>";
                                                echo $this->Html->link(
                                                    '<span class="fa fa-eye"></span> View Prescription',
                                                    ['controller' => 'prescriptions', 'action' => 'setPatient','user_id' => $user->id],
                                                    ['escapeTitle' => false, 'title' => 'View Prescription']
                                                );
                                            echo "</li>";
                                        }
                                    ?>
                                </ul>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>

            <!-- Appointment modal -->
            <?php echo $this->element('Modal/appointment_modal') ?>

        </div>

        <div class="bottom-pagination">
            <div class="pagination-area flex-container">
                <div class="pagination-status-text">
                    Showing <?php echo $this->Paginator->counter() ?> pages
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
