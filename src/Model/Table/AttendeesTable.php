<?php
namespace App\Model\Table;

use App\Model\Entity\Attendee;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Attendees Model
 *
 * @property \Cake\ORM\Association\BelongsTo $Countries * @property \Cake\ORM\Association\BelongsTo $AttendeeTypes */
class AttendeesTable extends Table
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

        $this->table('attendees');
        $this->displayField('id');
        $this->primaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Countries', [
            'foreignKey' => 'country_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('AttendeeTypes', [
            'foreignKey' => 'attendee_type_id',
            'joinType' => 'INNER'
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
            ->requirePresence('dob', 'create')            ->notEmpty('dob');
        $validator
            ->requirePresence('first_name', 'create')            ->notEmpty('first_name');
        $validator
            ->allowEmpty('surname');
        $validator
            ->requirePresence('mobile', 'create')            ->notEmpty('mobile');
        $validator
            ->allowEmpty('telephone');
        $validator
            ->requirePresence('address_line1', 'create')            ->notEmpty('address_line1');
        $validator
            ->allowEmpty('address_line2');
        $validator
            ->email('email')            ->requirePresence('email', 'create')            ->notEmpty('email');
        $validator
            ->requirePresence('post_code', 'create')            ->notEmpty('post_code');
        $validator
            ->requirePresence('city', 'create')            ->notEmpty('city');
        $validator
            ->requirePresence('state', 'create')            ->notEmpty('state');
        return $validator;
    }

    /**
     * Returns a rules checker object that will be used for validating
     * application integrity.
     *
     * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
     * @return \Cake\ORM\RulesChecker
     */
    public function buildRules(RulesChecker $rules)
    {
        $rules->add($rules->isUnique(['email']));
        $rules->add($rules->existsIn(['country_id'], 'Countries'));
        $rules->add($rules->existsIn(['attendee_type_id'], 'AttendeeTypes'));
        return $rules;
    }
}
