<?php
namespace App\Test\TestCase\Controller;

use App\Controller\PrescriptionsController;
use Cake\TestSuite\IntegrationTestCase;

/**
 * App\Controller\PrescriptionsController Test Case
 */
class PrescriptionsControllerTest extends IntegrationTestCase
{

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
     * Test index method
     *
     * @return void
     */
    public function testIndex()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test view method
     *
     * @return void
     */
    public function testView()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test add method
     *
     * @return void
     */
    public function testAdd()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test edit method
     *
     * @return void
     */
    public function testEdit()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test delete method
     *
     * @return void
     */
    public function testDelete()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
