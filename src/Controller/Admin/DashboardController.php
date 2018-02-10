<?php
namespace App\Controller\Admin;

use App\Controller\AppController;
use Cake\Event\Event;
use Cake\ORM\TableRegistry;
use Cake\Datasource\ConnectionManager;

class DashboardController extends AppController
{

    public $components = ['Common'];

    public function beforeFilter(Event $event)
    {
        parent::beforeFilter($event);
        // Allow users to register and logout.
        // You should not add the "login" action to allow list. Doing so would
        // cause problems with normal functioning of AuthComponent.
        $this->Auth->allow(['add', 'logout', 'login']);

        $this->set('loadDashboardScript', false);
    }

    function searchPatient(){

    }
    public function index() {}

    public function listView(){}

    public function add(){}
}
