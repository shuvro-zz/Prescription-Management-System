<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\DiagnosisTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\DiagnosisTable Test Case
 */
class DiagnosisTableTest extends TestCase
{

    /**
     * Test subject     *
     * @var \App\Model\Table\DiagnosisTable     */
    public $Diagnosis;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.diagnosis',
        'app.medicines',
        'app.diagnosis_medicines',
        'app.tests',
        'app.diagnosis_tests'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('Diagnosis') ? [] : ['className' => 'App\Model\Table\DiagnosisTable'];        $this->Diagnosis = TableRegistry::get('Diagnosis', $config);    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Diagnosis);

        parent::tearDown();
    }

    /**
     * Test initialize method
     *
     * @return void
     */
    public function testInitialize()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test validationDefault method
     *
     * @return void
     */
    public function testValidationDefault()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
