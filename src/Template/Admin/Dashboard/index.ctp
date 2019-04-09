<div class="workspace-dashboard">
    <div class="page-heading">
        <div class="flex-container">
            <div class="flex-item"><h4>Dashboard</h4></div>

        </div>
    </div>

    <div class="col-md-12">
        <?php echo $this->element('flash_message'); ?>
    </div>

    <?php if( $this->request->session()->read('Auth.User.role_id') != 1) { ?> <!--Not Admin-->
        <div class="dashboard-home-faetures flex-container text-center fs_dashboard">
            <div class="dash-box fs_dashboard_area">
                    <h1>Search Patient</h1>

                <div class="row">
                    <!-- The form -->
                    <?php echo $this->Form->create('Prescriptions',[
                        'url' => ['controller' => 'Prescriptions', 'action' => 'searchPatient'],
                        'type' => 'get',
                    ]);?>

                    <div class="col-sm-offset-4 col-sm-4">
                        <?php echo $this->Form->input('search',array('class' => 'form-control dashboard_search', 'label' => false, 'placeholder' => 'Phone number', 'required' => 'required')); ?>
                    </div>
                    <div class="col-sm-2">
                        <button type="submit" class="add-event-btn">SEARCH</button>
                    </div>


                    <?php echo $this->Form->end();?>

                </div>
            </div>
        </div>


        <div class="page page-ui-tables">
            <div class="event-listing">
                <div class="event-listing-top flex-container status-function dashboard_table_head">
                    <div class="status-area flex-container">
                        <h4>Today's appointment</h4>
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
                                                    '<span class="fa fa-plus"></span> Create Prescription',
                                                    ['controller' => 'prescriptions', 'action' => 'add/'.$user->id],
                                                    ['escapeTitle' => false, 'title' => 'Create Prescription']
                                                );
                                                echo "</li>";
                                            }
                                            ?>

                                            <?php
                                            if($this->request->session()->read('Auth.User.role_id') != 1){
                                                echo "<li>";
                                                echo $this->Html->link(
                                                    '<span class="fa fa-eye"></span> View Prescription',
                                                    ['controller' => 'prescriptions', 'action' => 'setPatient','user_id' => $user->id],
                                                    ['escapeTitle' => false, 'title' => 'View Prescription']
                                                );
                                                echo "</li>";
                                            }
                                            ?>

                                            <?php
                                            echo "<li>";
                                            echo $this->Html->link(
                                                '<span class="fa fa-pencil-square"></span> Edit',
                                                ['controller' => 'users', 'action' => 'edit', $user->id],
                                                ['escapeTitle' => false, 'title' => 'Edit User']
                                            );
                                            echo "</li>";

                                            echo "<li>";
                                            echo $this->Html->link(
                                                '<span class="fa fa-calendar"></span> Appointments',
                                                ['action' => '#0'],
                                                ['escapeTitle' => false, 'onclick' => "setUserIdForDate(this)", 'user_id' => $user->id, 'title' => 'Add to appointments', 'data-toggle' => 'modal',
                                                    'data-target' => '#calender-date-modal', 'type' => 'button']
                                            );
                                            echo "</li>";
                                            ?>

                                        </ul>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                        </tbody>
                    </table>

                    <!-- Calender date modal -->
                    <?php echo $this->element('Modal/calender_modal') ?>

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

    <?php } ?>

</div>

