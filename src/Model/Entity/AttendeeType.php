<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * AttendeeType Entity.
 *
 * @property int $id * @property string $attendee_type * @property bool $status * @property \Cake\I18n\Time $created * @property \Cake\I18n\Time $updated * @property \App\Model\Entity\Attendee[] $attendees */
class AttendeeType extends Entity
{

    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * Note that when '*' is set to true, this allows all unspecified fields to
     * be mass assigned. For security purposes, it is advised to set '*' to false
     * (or remove it), and explicitly make individual fields accessible as needed.
     *
     * @var array
     */
    protected $_accessible = [
        '*' => true,
        'id' => false,
    ];
}
