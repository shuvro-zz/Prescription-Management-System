<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Diagnosi'), ['action' => 'edit', $diagnosi->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Diagnosi'), ['action' => 'delete', $diagnosi->id], ['confirm' => __('Are you sure you want to delete # {0}?', $diagnosi->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Diagnosis'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Diagnosi'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Medicines'), ['controller' => 'Medicines', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Medicine'), ['controller' => 'Medicines', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Tests'), ['controller' => 'Tests', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Test'), ['controller' => 'Tests', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="diagnosis view large-9 medium-8 columns content">
    <h3><?= h($diagnosi->name) ?></h3>
    <table class="vertical-table">
        <tr>
            <th><?= __('Name') ?></th>
            <td><?= h($diagnosi->name) ?></td>
        </tr>
        <tr>
            <th><?= __('Id') ?></th>
            <td><?= $this->Number->format($diagnosi->id) ?></td>
        </tr>
        <tr>
            <th><?= __('Created') ?></th>
            <td><?= h($diagnosi->created) ?></td>
        </tr>
        <tr>
            <th><?= __('Updated') ?></th>
            <td><?= h($diagnosi->updated) ?></td>
        </tr>
        <tr>
            <th><?= __('Status') ?></th>
            <td><?= $diagnosi->status ? __('Yes') : __('No'); ?></td>
        </tr>
    </table>
    <div class="row">
        <h4><?= __('Instructions') ?></h4>
        <?= $this->Text->autoParagraph(h($diagnosi->instructions)); ?>
    </div>
    <div class="related">
        <h4><?= __('Related Medicines') ?></h4>
        <?php if (!empty($diagnosi->medicines)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th><?= __('Id') ?></th>
                <th><?= __('Name') ?></th>
                <th><?= __('Status') ?></th>
                <th><?= __('Created') ?></th>
                <th><?= __('Updated') ?></th>
                <th class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($diagnosi->medicines as $medicines): ?>
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
        <?php endif; ?>
    </div>
    <div class="related">
        <h4><?= __('Related Tests') ?></h4>
        <?php if (!empty($diagnosi->tests)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th><?= __('Id') ?></th>
                <th><?= __('Name') ?></th>
                <th><?= __('Status') ?></th>
                <th><?= __('Created') ?></th>
                <th class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($diagnosi->tests as $tests): ?>
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
        <?php endif; ?>
    </div>
</div>
