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
    public $components = ['Common'];

    public $paginate = [
        'limit' => 20
    ];

    public function index()
    {
        $this->loadModel('Users');

        $this->resetDashboardSearch();

        $session = $this->request->session();
        if (isset($this->request->query['search']) and trim($this->request->query['search']) != '') {
            $session->write('appointments_search_query', $this->request->query['search']);
        }

        if ($session->check('appointments_search_query')) {
            $search = $session->read('appointments_search_query');
        } else {
            $search = '';
        }

        if (isset($this->request->query['appointment_date']) and trim($this->request->query['appointment_date']) != '') {
            $session->write('appointment_date_query', $this->request->query['appointment_date']);
        }

        if ($session->check('appointment_date_query')) {
            $appointment_date = $session->read('appointment_date_query');
        } else {
            $appointment_date = '';
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
                'Users.appointment_date' => 'asc',
                'Users.serial_no' => 'asc'
            ]
        ];
        $users = $this->paginate($query);

        if (count($users) == 0) {
            $this->Flash->adminWarning(__('No patient found!'), ['key' => 'admin_warning'], ['key' => 'admin_warning']);
        }

        $this->set(compact('users', 'search', 'appointment_date'));
        $this->set('_serialize', ['users']);
    }


    function __search()
    {
        $session = $this->request->session();

        if ($session->check('appointments_search_query') OR $session->check('appointment_date_query')) {
            $search = $session->read('appointments_search_query');
            $appointment_date = $session->read('appointment_date_query');

            $appointment_date_filter = isset($appointment_date)?['Users.appointment_date' => date('Y-m-d', strtotime($appointment_date))]:'';

            $where = ['Users.role_id' => 3, //patient
                'Users.doctor_id' => $session->read('Auth.User.id'),
                'Users.appointment_date >' => date('Y-m-d'),
                $appointment_date_filter,
                'OR' => [
                    ['Users.first_name LIKE' => '%' . $search . '%'],
                    ['Users.weight LIKE' => '%' . $search . '%'],
                    ['Users.phone LIKE' => '%' . $search . '%'],
                    ['Users.email LIKE' => '%' . $search . '%'],
                    ['Users.age LIKE' => '%' . $search . '%'],
                    ['Users.created LIKE' => '%' . $search . '%']
                ]
            ];
        } else {
            $where = ['Users.role_id' => 3, //patient
                    'Users.doctor_id' => $session->read('Auth.User.id'),
                    'Users.appointment_date >' => date('Y-m-d')
                ];
        }
        return $where;
    }

    function reset()
    {
        $session = $this->request->session();
        $session->delete('appointments_search_query');
        $session->delete('appointment_date_query');
        $this->redirect(['action' => 'index']);
    }


    function resetDashboardSearch()
    {
        $session = $this->request->session();
        $session->delete('users_search_from_dashboard');
    }

    function addAppointment(){
        $save = $this->Common->addAppointments();

        if ($save){
            $this->Flash->adminSuccess('Patient has been added for appointments', ['key' => 'admin_success']);
        }else{
            $this->Flash->adminError('Patient could not be added for appointments ', ['key' => 'admin_error']);
        }

        return $this->redirect(['action' => 'index']);
    }
}