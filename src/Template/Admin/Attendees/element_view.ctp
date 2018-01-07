<div class="panel-body">
    <table class="vertical-table">
        <tr>
            <th><?= __('First Name') ?></th>
            <td><?= h($attendee->first_name) ?></td>
        </tr>
        <tr>
            <th><?= __('Surname') ?></th>
            <td><?= h($attendee->surname) ?></td>
        </tr>
        <tr>
            <th><?= __('Date of Birth') ?></th>
            <td><?= h($attendee->dob) ?></td>
        </tr>
        <tr>
            <th><?= __('Mobile') ?></th>
            <td><?= h($attendee->mobile) ?></td>
        </tr>
        <tr>
            <th><?= __('Telephone') ?></th>
            <td><?= h($attendee->telephone) ?></td>
        </tr>
        <tr>
            <th><?= __('Address Line1') ?></th>
            <td><?= h($attendee->address_line1) ?></td>
        </tr>
        <tr>
            <th><?= __('Address Line2') ?></th>
            <td><?= h($attendee->address_line2) ?></td>
        </tr>
        <tr>
            <th><?= __('Email') ?></th>
            <td><?= h($attendee->email) ?></td>
        </tr>
        <tr>
            <th><?= __('Post Code') ?></th>
            <td><?= h($attendee->post_code) ?></td>
        </tr>
        <tr>
            <th><?= __('City') ?></th>
            <td><?= h($attendee->city) ?></td>
        </tr>
        <tr>
            <th><?= __('State') ?></th>
            <td><?= h($attendee->state) ?></td>
        </tr>
        <tr>
            <th><?= __('Country') ?></th>
            <td><?= __($attendee->country->name) ?></td>
        </tr>
        <tr>
            <th><?= __('Attendee Type') ?></th>
            <td><?= __($attendee->attendee_type->attendee_type) ?></td>
        </tr>
        <tr>
            <th><?= __('Created') ?></th>
            <td><?= h($attendee->created) ?></td>
        </tr>
        <tr>
            <th><?= __('Updated') ?></th>
            <td><?= h($attendee->updated) ?></td>
        </tr>
        <!--<tr>
                                            <th><?/*= __('Status') */?></th>
                                            <td><?/*= $attendee->status ? __('Yes') : __('No'); */?></td>
                                        </tr>-->
    </table>
</div>