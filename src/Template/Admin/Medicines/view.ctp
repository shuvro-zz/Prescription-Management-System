<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Medicine'), ['action' => 'edit', $medicine->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Medicine'), ['action' => 'delete', $medicine->id], ['confirm' => __('Are you sure you want to delete # {0}?', $medicine->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Medicines'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Medicine'), ['action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="medicines view large-9 medium-8 columns content">
    <h3><?= h($medicine->name) ?></h3>
    <table class="vertical-table">
        <tr>
            <th><?= __('Name') ?></th>
            <td><?= h($medicine->name) ?></td>
        </tr>
        <tr>
            <th><?= __('Id') ?></th>
            <td><?= $this->Number->format($medicine->id) ?></td>
        </tr>
    </table>
</div>
