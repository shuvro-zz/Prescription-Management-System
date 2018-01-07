<?php
namespace App\Model\Table;

use App\Model\Entity\Conference;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Conferences Model
 *
 * @property \Cake\ORM\Association\BelongsTo $Venues * @property \Cake\ORM\Association\BelongsTo $Events */
class ConferencesTable extends Table
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

        $this->table('conferences');
        $this->displayField('name');
        $this->primaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Venues', [
            'foreignKey' => 'venue_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('Events', [
            'foreignKey' => 'event_id',
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
            ->requirePresence('slug', 'create')            ->notEmpty('slug');
        $validator
            ->requirePresence('name', 'create')            ->notEmpty('name');
        $validator
            ->requirePresence('conference_date', 'create')            ->notEmpty('conference_date');
        $validator
            ->requirePresence('start_time', 'create')            ->notEmpty('start_time');
        $validator
            ->requirePresence('end_time', 'create')            ->notEmpty('end_time');
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
        $rules->add($rules->existsIn(['venue_id'], 'Venues'));
        $rules->add($rules->existsIn(['event_id'], 'Events'));
        return $rules;
    }
}
