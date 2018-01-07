<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Venue Entity.
 *
 * @property int $id * @property string $name * @property string $slug * @property string $post_code * @property string $state * @property string $city * @property int $country_id * @property \App\Model\Entity\Country $country * @property bool $status * @property \Cake\I18n\Time $created * @property \Cake\I18n\Time $updated */
class Venue extends Entity
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
