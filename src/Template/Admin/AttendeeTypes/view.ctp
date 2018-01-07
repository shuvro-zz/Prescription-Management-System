<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Attendee Type'), ['action' => 'edit', $attendeeType->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Attendee Type'), ['action' => 'delete', $attendeeType->id], ['confirm' => __('Are you sure you want to delete # {0}?', $attendeeType->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Attendee Types'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Attendee Type'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Attendees'), ['controller' => 'Attendees', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Attendee'), ['controller' => 'Attendees', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="attendeeTypes view large-9 medium-8 columns content">
    <h3><?= h($attendeeType->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th><?= __('Attendee Type') ?></th>
            <td><?= h($attendeeType->attendee_type) ?></td>
        </tr>
        <tr>
            <th><?= __('Id') ?></th>
            <td><?= $this->Number->format($attendeeType->id) ?></td>
        </tr>
        <tr>
            <th><?= __('Created') ?></th>
            <td><?= h($attendeeType->created) ?></td>
        </tr>
        <tr>
            <th><?= __('Updated') ?></th>
            <td><?= h($attendeeType->updated) ?></td>
        </tr>
        <tr>
            <th><?= __('Status') ?></th>
            <td><?= $attendeeType->status ? __('Yes') : __('No'); ?></td>
        </tr>
    </table>
    <div class="related">
        <h4><?= __('Related Attendees') ?></h4>
        <?php if (!empty($attendeeType->attendees)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th><?= __('Id') ?></th>
                <th><?= __('First Name') ?></th>
                <th><?= __('Surname') ?></th>
                <th><?= __('Dob') ?></th>
                <th><?= __('Mobile') ?></th>
                <th><?= __('Telephone') ?></th>
                <th><?= __('Address Line1') ?></th>
                <th><?= __('Address Line2') ?></th>
                <th><?= __('Email') ?></th>
                <th><?= __('Post Code') ?></th>
                <th><?= __('City') ?></th>
                <th><?= __('State') ?></th>
                <th><?= __('Country Id') ?></th>
                <th><?= __('Attendee Type Id') ?></th>
                <th><?= __('Status') ?></th>
                <th><?= __('Created') ?></th>
                <th><?= __('Updated') ?></th>
                <th class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($attendeeType->attendees as $attendees): ?>
            <tr>
                <td><?= h($attendees->id) ?></td>
                <td><?= h($attendees->first_name) ?></td>
                <td><?= h($attendees->surname) ?></td>
                <td><?= h($attendees->dob) ?></td>
                <td><?= h($attendees->mobile) ?></td>
                <td><?= h($attendees->telephone) ?></td>
                <td><?= h($attendees->address_line1) ?></td>
                <td><?= h($attendees->address_line2) ?></td>
                <td><?= h($attendees->email) ?></td>
                <td><?= h($attendees->post_code) ?></td>
                <td><?= h($attendees->city) ?></td>
                <td><?= h($attendees->state) ?></td>
                <td><?= h($attendees->country_id) ?></td>
                <td><?= h($attendees->attendee_type_id) ?></td>
                <td><?= h($attendees->status) ?></td>
                <td><?= h($attendees->created) ?></td>
                <td><?= h($attendees->updated) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'Attendees', 'action' => 'view', $attendees->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['controller' => 'Attendees', 'action' => 'edit', $attendees->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'Attendees', 'action' => 'delete', $attendees->id], ['confirm' => __('Are you sure you want to delete # {0}?', $attendees->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </div>
</div>
