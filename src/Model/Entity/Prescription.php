<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Prescription Entity.
 *
 * @property int $id * @property int $user_id * @property \App\Model\Entity\User $user * @property string $diagnosis * @property bool $status * @property \Cake\I18n\Time $created * @property \Cake\I18n\Time $updated * @property \App\Model\Entity\Medicine[] $medicines * @property \App\Model\Entity\Test[] $tests */
class Prescription extends Entity
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
