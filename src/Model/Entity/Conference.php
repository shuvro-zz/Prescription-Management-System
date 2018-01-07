<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Conference Entity.
 *
 * @property int $id * @property string $conference_code * @property string $name * @property \Cake\I18n\Time $conference_date * @property string $start_time * @property string $end_time * @property int $venue_id * @property \App\Model\Entity\Venue $venue * @property int $event_id * @property \App\Model\Entity\Event $event * @property bool $status * @property \Cake\I18n\Time $created * @property \Cake\I18n\Time $updated */
class Conference extends Entity
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
