<div class="workspace-dashboard page page-ui-tables">
    <div class="workspace-body">
        <div class="page-heading">
            <ol class="breadcrumb breadcrumb-small">
                <li><a href="<?=$this->Url->build(array('action' => 'index' )) ?>" title="<?= __('Prescription') ?>"> <?= __('Prescription') ?></a></li>
                <li class="active"><a href="#">Add <?= __('Prescription') ?></a></li>
            </ol>
        </div>

        <nav class="large-3 medium-4 columns" id="actions-sidebar">
            <ul class="side-nav">
                <li class="heading"><?= __('Actions') ?></li>
                <li><?= $this->Html->link(__('Edit Prescription'), ['action' => 'edit', $prescription->id]) ?> </li>
                <li><?= $this->Form->postLink(__('Delete Prescription'), ['action' => 'delete', $prescription->id], ['confirm' => __('Are you sure you want to delete # {0}?', $prescription->id)]) ?> </li>
                <li><?= $this->Html->link(__('List Prescriptions'), ['action' => 'index']) ?> </li>
                <li><?= $this->Html->link(__('New Prescription'), ['action' => 'add']) ?> </li>
                <li><?= $this->Html->link(__('List Users'), ['controller' => 'Users', 'action' => 'index']) ?> </li>
                <li><?= $this->Html->link(__('New User'), ['controller' => 'Users', 'action' => 'add']) ?> </li>
                <li><?= $this->Html->link(__('List Medicines'), ['controller' => 'Medicines', 'action' => 'index']) ?> </li>
                <li><?= $this->Html->link(__('New Medicine'), ['controller' => 'Medicines', 'action' => 'add']) ?> </li>
                <li><?= $this->Html->link(__('List Tests'), ['controller' => 'Tests', 'action' => 'index']) ?> </li>
                <li><?= $this->Html->link(__('New Test'), ['controller' => 'Tests', 'action' => 'add']) ?> </li>
            </ul>
        </nav>

        <div class="event-listing">
            <div class="prescriptions view large-9 medium-8 columns content">
                <h3><?= h($prescription->id) ?></h3>
                <div class="table-responsive table-part">
                    <table class="vertical-table table table-hover  table-striped">
                        <tr>
                            <th><?= __('User') ?></th>
                            <td><?= $prescription->has('user') ? $this->Html->link($prescription->user->id, ['controller' => 'Users', 'action' => 'view', $prescription->user->id]) : '' ?></td>
                        </tr>
                        <tr>
                            <th><?= __('Diagnosis') ?></th>
                            <td><?= h($prescription->diagnosis) ?></td>
                        </tr>
                        <tr>
                            <th><?= __('Id') ?></th>
                            <td><?= $this->Number->format($prescription->id) ?></td>
                        </tr>
                        <tr>
                            <th><?= __('Created') ?></th>
                            <td><?= h($prescription->created) ?></td>
                        </tr>
                        <tr>
                            <th><?= __('Updated') ?></th>
                            <td><?= h($prescription->updated) ?></td>
                        </tr>
                        <tr>
                            <th><?= __('Status') ?></th>
                            <td><?= $prescription->status ? __('Yes') : __('No'); ?></td>
                        </tr>
                    </table>
                </div>

                <div class="related">
                    <h4><?= __('Related Medicines') ?></h4>
                    <?php if (!empty($prescription->medicines)): ?>
                        <div class="table-responsive table-part">
                            <table class="vertical-table table table-hover  table-striped" cellpadding="0" cellspacing="0">
                                <tr>
                                    <th><?= __('Id') ?></th>
                                    <th><?= __('Name') ?></th>
                                    <th><?= __('Status') ?></th>
                                    <th><?= __('Created') ?></th>
                                    <th><?= __('Updated') ?></th>
                                    <th class="actions"><?= __('Actions') ?></th>
                                </tr>
                                <?php foreach ($prescription->medicines as $medicines): ?>
                                <tr>
                                    <td><?= h($medicines->id) ?></td>
                                    <td><?= h($medicines->name) ?></td>
                                    <td><?= h($medicines->status) ?></td>
                                    <td><?= h($medicines->created) ?></td>
                                    <td><?= h($medicines->updated) ?></td>
                                    <td class="actions">
                                        <?= $this->Html->link(__('View'), ['controller' => 'Medicines', 'action' => 'view', $medicines->id]) ?>
                                        <?= $this->Html->link(__('Edit'), ['controller' => 'Medicines', 'action' => 'edit', $medicines->id]) ?>
                                        <?= $this->Form->postLink(__('Delete'), ['controller' => 'Medicines', 'action' => 'delete', $medicines->id], ['confirm' => __('Are you sure you want to delete # {0}?', $medicines->id)]) ?>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </table>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="related">
                    <h4><?= __('Related Tests') ?></h4>
                    <?php if (!empty($prescription->tests)): ?>
                    <div class="table-responsive table-part">
                        <table class="vertical-table table table-hover " cellpadding="0" cellspacing="0">
                            <tr>
                                <th><?= __('Id') ?></th>
                                <th><?= __('Name') ?></th>
                                <th><?= __('Status') ?></th>
                                <th><?= __('Created') ?></th>
                                <th class="actions"><?= __('Actions') ?></th>
                            </tr>
                            <?php foreach ($prescription->tests as $tests): ?>
                            <tr>
                                <td><?= h($tests->id) ?></td>
                                <td><?= h($tests->name) ?></td>
                                <td><?= h($tests->status) ?></td>
                                <td><?= h($tests->created) ?></td>
                                <td class="actions">
                                    <?= $this->Html->link(__('View'), ['controller' => 'Tests', 'action' => 'view', $tests->id]) ?>
                                    <?= $this->Html->link(__('Edit'), ['controller' => 'Tests', 'action' => 'edit', $tests->id]) ?>
                                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'Tests', 'action' => 'delete', $tests->id], ['confirm' => __('Are you sure you want to delete # {0}?', $tests->id)]) ?>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </table>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>

    </div>
</div>
