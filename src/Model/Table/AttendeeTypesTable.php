<?php
namespace App\Model\Table;

use App\Model\Entity\AttendeeType;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * AttendeeTypes Model
 *
 * @property \Cake\ORM\Association\HasMany $Attendees */
class AttendeeTypesTable extends Table
{

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        parent::initialize($config);

        $this->table('attendee_types');
        $this->displayField('attendee_type');
        $this->primaryKey('id');

        $this->addBehavior('Timestamp');

        $this->hasMany('Attendees', [
            'foreignKey' => 'attendee_type_id'
        ]);
    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator)
    {
        $validator
            ->integer('id')            ->allowEmpty('id', 'create');
        $validator
            ->requirePresence('attendee_type', 'create')            ->notEmpty('attendee_type');
        return $validator;
    }
}
