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

    public function index() {

        $this->loadModel("Users");
        $session = $this->request->session();
        $doctor_id = $session->read('Auth.User.id');

        $users = $this->Users->find('all')->where(['Users.doctor_id' => $doctor_id,
                                                    'Users.role_id' => 3,  // patient = role_id 3
                                                    'Users.appointment_date' => date('Y-m-d')
                                                  ]);

        $this->paginate = [
            'limit' => 30,
            'order' => [
                'Users.updated' => 'desc'
            ]
        ];
        $users = $this->paginate($users);

        $this->set(compact('users'));
        $this->set('_serialize', ['users']);
    }

    public function listView(){}

    public function add(){}
}
