<?php
namespace App\Model\Table;

use App\Model\Entity\Diagnosi;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Diagnosis Model
 *
 * @property \Cake\ORM\Association\BelongsToMany $Medicines * @property \Cake\ORM\Association\BelongsToMany $Tests */
class DiagnosisTable extends Table
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

        $this->table('diagnosis');
        $this->displayField('name');
        $this->primaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsToMany('Medicines', [
            'foreignKey' => 'diagnosis_id',
            'targetForeignKey' => 'medicine_id',
            'joinTable' => 'diagnosis_medicines'
        ]);
        $this->belongsToMany('Tests', [
            'foreignKey' => 'diagnosis_id',
            'targetForeignKey' => 'test_id',
            'joinTable' => 'diagnosis_tests'
        ]);

        $this->belongsTo('DiagnosisLists', [
            'foreignKey' => 'diagnosis_list_id'
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
            ->requirePresence('diagnosis_list_id', 'create')->notEmpty('diagnosis_list_id');
        $validator
            ->allowEmpty('instructions');
        $validator
            ->boolean('status')->allowEmpty('status');
        return $validator;
    }
}
