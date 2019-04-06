<?php
namespace App\Controller\Admin;

use App\Controller\AppController;
use Cake\Core\Configure;
use Cake\Event\Event;
use Cake\Filesystem\File;
use Cake\ORM\TableRegistry;
use Cake\Routing\Router;
use Cake\Utility\Text;

/**
 * Tests Controller
 *
 * @property \App\Model\Table\TestsTable $Tests */

class AppointmentsController extends AppController
{
    public $paginate = [
        'limit' => 20
    ];

    public function index()
    {
        $this->loadModel('Users');

        $this->resetDashboardSearch();

        $session = $this->request->session();
        if (isset($this->request->query['search']) and trim($this->request->query['search']) != '') {
            $session->write('users_search_query', $this->request->query['search']);
        }
        if ($session->check('users_search_query')) {
            $search = $session->read('users_search_query');
        } else {
            $search = '';
        }

        $where = $this->__search();

        if ($where) {
            $query = $this->Users->find('All')->where($where);
        } else {
            $query = $this->Users;
        }

        $this->paginate = [
            'limit' => 30,
            'order' => [
                'Users.id' => 'desc'
            ]
        ];
        $users = $this->paginate($query);

        if (count($users) == 0) {
            $this->Flash->adminWarning(__('No patient found!'), ['key' => 'admin_warning'], ['key' => 'admin_warning']);
        }

        $this->set(compact('users', 'search'));
        $this->set('_serialize', ['users']);
    }


    function __search()
    {
        $session = $this->request->session();
        $user_id = $session->read('Auth.User.id');

        if ($session->check('users_search_query')) {
            $search = $session->read('users_search_query');
            $where = [$this->checkById($user_id),
                'OR' => [
                    ['Users.first_name LIKE' => '%' . $search . '%'],
                    ['Users.phone LIKE' => '%' . $search . '%'],
                    ['Users.email LIKE' => '%' . $search . '%']
                ]
            ];
        } else {
            $where = [$this->checkById($user_id),
                    'Users.appointment_date >' => date('Y-m-d h:i:s')
                ];
        }
        return $where;
    }

    function reset()
    {
        $session = $this->request->session();
        $session->delete('users_search_query');
        $this->redirect(['action' => 'index']);
    }


    function resetDashboardSearch()
    {
        $session = $this->request->session();
        $session->delete('users_search_from_dashboard');
    }

    function addTodayAppointment($id = null)
    {
        $this->loadModel('Users');

        $this->autoRender = false;

        $patient = $this->Users->get($id);
        $patient->appointment_date = date('Y/m/d ');
        $patient->is_visited = 0;

        if ($this->Users->save($patient)) {
            $this->Flash->adminSuccess('Patient has been added for today\'s appointment', ['key' => 'admin_success']);
        } else {
            $this->Flash->adminError('Patient could not be added for today\'s appointment ', ['key' => 'admin_error']);
        }

        return $this->redirect(['action' => 'index']);
    }

    function checkById($user_id){
        if($this->request->session()->read('Auth.User.role_id') == 1){ //Admin role_id
            $checkById = ['Users.role_id' => 2]; //Doctor role_id
        }else{
            $checkById = ['Users.doctor_id' => $user_id];
        }
        return $checkById;
    }

}