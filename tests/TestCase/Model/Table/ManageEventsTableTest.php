<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\ManageEventsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\ManageEventsTable Test Case
 */
class ManageEventsTableTest extends TestCase
{

    /**
     * Test subject     *
     * @var \App\Model\Table\ManageEventsTable     */
    public $ManageEvents;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.manage_events'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('ManageEvents') ? [] : ['className' => 'App\Model\Table\ManageEventsTable'];        $this->ManageEvents = TableRegistry::get('ManageEvents', $config);    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->ManageEvents);

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
