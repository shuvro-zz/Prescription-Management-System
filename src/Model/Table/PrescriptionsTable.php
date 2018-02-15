<?php
namespace App\Model\Table;

use App\Model\Entity\Prescription;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Prescriptions Model
 *
 * @property \Cake\ORM\Association\BelongsTo $Users * @property \Cake\ORM\Association\BelongsToMany $Medicines * @property \Cake\ORM\Association\BelongsToMany $Tests */
class PrescriptionsTable extends Table
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

        $this->table('prescriptions');
        $this->displayField('id');
        $this->primaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Users', [
            'foreignKey' => 'user_id',
            'joinType' => 'INNER'
        ]);

        $this->belongsToMany('Medicines', [
            'foreignKey' => 'prescription_id',
            'targetForeignKey' => 'medicine_id',
            'joinTable' => 'prescriptions_medicines'
        ]);

        /*$this->hasMany('Medicines', [
            'foreignKey' => 'medicine_id'
        ]);*/

        $this->belongsToMany('Tests', [
            'foreignKey' => 'prescription_id',
            'targetForeignKey' => 'test_id',
            'joinTable' => 'prescriptions_tests'
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
            ->integer('id')->allowEmpty('id', 'create');
        $validator
            ->requirePresence('diagnosis', 'create')->notEmpty('diagnosis');
        
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
        $rules->add($rules->existsIn(['user_id'], 'Users'));
        return $rules;
    }
}
