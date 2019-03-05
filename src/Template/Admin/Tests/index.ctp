<?php use \Cake\Core\Configure; ?>
<div class="workspace-dashboard page page-ui-tables">
    <div class="page-heading">
        <div class="flex-container">
            <div class="flex-item"><h4><?= __('Examinations') ?></h4></div>
            <div class="flex-item">
                <div class="flex-container">
                    <?php
                    if ($this->request->session()->read('Auth.User.role_id') == 1) {
                        if (Configure::read('import_allow')) {
                            echo $this->Html->link(
                                '<span class="icon import_icon"><i class="fa fa-upload"></i></span> Import Examinations',
                                ['action' => 'import_csv'],
                                ['class' => 'add-event-btn import_btn_padding', 'escapeTitle' => false, 'title' => 'Import Examinations']
                            );
                        }
                    }
                    echo $this->Html->link(
                        '<span class="icon">+</span> Add Examination',
                        ['action' => 'add'],
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
                    <?php echo $this->Form->create('Tests', ['type' => 'get'], array('id' => 'site-search', 'url' => array('action' => 'index'), 'method' => 'get')); ?>
                    <?php echo $this->Form->input('search', array('class' => 'form-control', 'value' => $search, 'label' => false, 'placeholder' => 'Type here for search...')); ?>
                    <button type="submit"><i class="fa fa-search"></i></button>
                    <div class="flex-container">
                        <?php
                        echo $this->Html->link(
                            'Reset',
                            ['action' => 'reset'],
                            ['class' => 'btn btn-default waves-effect btn-cancel', 'escapeTitle' => false]
                        );
                        ?>
                    </div>
                    <?php echo $this->Form->end(); ?>
                </div>
            </div>
        </div>

        <div class="table-responsive table-part">
            <table class="table table-hover  table-striped">
                <thead>
                <tr>
                    <th><?= $this->Paginator->sort('name') ?></th>
                    <th><?= $this->Paginator->sort('created') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($tests as $test): ?>
                    <tr>
                        <td><?= ucfirst(h($test->name)) ?></td>
                        <td><?= h($test->created->format('d/m/Y')) ?></td>
                            <td class="actions" style="width: 204px;">

                                <?php  if ($this->request->session()->read('Auth.User.role_id') == 1) { ?>

                                    <div class="dropdown action-button">
                                        <span class="dropdown-toggle event-action" type="button" data-toggle="dropdown">
                                            <?php echo $this->Html->image('/css/admin_styles/images/dashboard-settings-sm.png', ['alt' => 'Settings']) ?>
                                        </span>
                                        <ul class="dropdown-menu action-dropdown">
                                            <li>
                                                <?php
                                                echo $this->Html->link(
                                                    '<span class="fa fa-pencil-square"></span> Edit',
                                                    ['action' => 'edit', $test->id],
                                                    ['escapeTitle' => false, 'title' => 'Edit Test']
                                                );
                                                ?>
                                            </li>
                                            <li>
                                                <?php
                                                echo $this->Form->postLink(
                                                    '<span class="fa fa-trash"></span> Delete',
                                                    ['action' => 'delete', $test->id],
                                                    ['escapeTitle' => false, 'title' => 'Delete Coupon', 'confirm' => __('Are you sure you want to delete # {0}?', $test->id)]
                                                );
                                                ?>
                                            </li>
                                        </ul>
                                    </div>

                                <?php }else { echo "N/A"; } ?>
                            </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <div class="bottom-pagination">
            <div class="pagination-area flex-container">
                <div class="pagination-status-text">
                    Showing <?php echo $this->Paginator->counter() ?> pages
                </div>
                <ul class="pagination">
                    <?php
                    if ($this->Paginator->numbers()) {
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
