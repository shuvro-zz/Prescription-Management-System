<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Attendee Entity.
 *
 * @property int $id * @property string $dob * @property string $first_name * @property string $surname * @property string $mobile * @property string $telephone * @property string $address_line1 * @property string $address_line2 * @property string $email * @property string $post_code * @property string $city * @property string $state * @property int $country_id * @property \App\Model\Entity\Country $country * @property int $attendee_type_id * @property \App\Model\Entity\AttendeeType $attendee_type * @property bool $status * @property \Cake\I18n\Time $created * @property \Cake\I18n\Time $updated */
class Attendee extends Entity
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
