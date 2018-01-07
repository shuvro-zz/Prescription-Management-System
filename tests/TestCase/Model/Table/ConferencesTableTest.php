<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\ConferencesTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\ConferencesTable Test Case
 */
class ConferencesTableTest extends TestCase
{

    /**
     * Test subject     *
     * @var \App\Model\Table\ConferencesTable     */
    public $Conferences;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.conferences',
        'app.venues',
        'app.countries',
        'app.events'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('Conferences') ? [] : ['className' => 'App\Model\Table\ConferencesTable'];        $this->Conferences = TableRegistry::get('Conferences', $config);    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Conferences);

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
