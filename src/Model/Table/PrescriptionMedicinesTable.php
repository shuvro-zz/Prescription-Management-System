<?php
namespace App\Model\Table;

use App\Model\Entity\PrescriptionMedicine;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

class PrescriptionMedicinesTable extends Table
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

        $this->table('prescription_medicines');
        $this->displayField('prescription_id');
        $this->primaryKey('id');

        $this->addBehavior('Timestamp');
    }
}
