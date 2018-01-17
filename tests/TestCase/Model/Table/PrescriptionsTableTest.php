<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\PrescriptionsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\PrescriptionsTable Test Case
 */
class PrescriptionsTableTest extends TestCase
{

    /**
     * Test subject     *
     * @var \App\Model\Table\PrescriptionsTable     */
    public $Prescriptions;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.prescriptions',
        'app.users',
        'app.bookmarks',
        'app.medicines',
        'app.prescriptions_medicines',
        'app.tests',
        'app.prescriptions_tests'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('Prescriptions') ? [] : ['className' => 'App\Model\Table\PrescriptionsTable'];        $this->Prescriptions = TableRegistry::get('Prescriptions', $config);    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Prescriptions);

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

    /**
     * Test buildRules method
     *
     * @return void
     */
    public function testBuildRules()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
