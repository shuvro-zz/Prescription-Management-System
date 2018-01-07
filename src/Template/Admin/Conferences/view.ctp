<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Conference'), ['action' => 'edit', $conference->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Conference'), ['action' => 'delete', $conference->id], ['confirm' => __('Are you sure you want to delete # {0}?', $conference->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Conferences'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Conference'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Venues'), ['controller' => 'Venues', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Venue'), ['controller' => 'Venues', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Events'), ['controller' => 'Events', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Event'), ['controller' => 'Events', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="conferences view large-9 medium-8 columns content">
    <h3><?= h($conference->name) ?></h3>
    <table class="vertical-table">
        <tr>
            <th><?= __('Conference Code') ?></th>
            <td><?= h($conference->conference_code) ?></td>
        </tr>
        <tr>
            <th><?= __('Name') ?></th>
            <td><?= h($conference->name) ?></td>
        </tr>
        <tr>
            <th><?= __('Start Time') ?></th>
            <td><?= h($conference->start_time) ?></td>
        </tr>
        <tr>
            <th><?= __('End Time') ?></th>
            <td><?= h($conference->end_time) ?></td>
        </tr>
        <tr>
            <th><?= __('Venue') ?></th>
            <td><?= $conference->has('venue') ? $this->Html->link($conference->venue->name, ['controller' => 'Venues', 'action' => 'view', $conference->venue->id]) : '' ?></td>
        </tr>
        <tr>
            <th><?= __('Event') ?></th>
            <td><?= $conference->has('event') ? $this->Html->link($conference->event->name, ['controller' => 'Events', 'action' => 'view', $conference->event->id]) : '' ?></td>
        </tr>
        <tr>
            <th><?= __('Id') ?></th>
            <td><?= $this->Number->format($conference->id) ?></td>
        </tr>
        <tr>
            <th><?= __('Conference Date') ?></th>
            <td><?= h($conference->conference_date) ?></td>
        </tr>
        <tr>
            <th><?= __('Created') ?></th>
            <td><?= h($conference->created) ?></td>
        </tr>
        <tr>
            <th><?= __('Updated') ?></th>
            <td><?= h($conference->updated) ?></td>
        </tr>
        <tr>
            <th><?= __('Status') ?></th>
            <td><?= $conference->status ? __('Yes') : __('No'); ?></td>
        </tr>
    </table>
</div>
