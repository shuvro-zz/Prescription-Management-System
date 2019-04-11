<?php
namespace App\Controller\Admin;

use App\Controller\AppController;
use Cake\Event\Event;
use Cake\ORM\TableRegistry;
use Cake\Datasource\ConnectionManager;

class DashboardController extends AppController
{

    public $components = ['Common'];

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
                'Users.serial_no' => 'asc'
            ]
        ];
        $users = $this->paginate($users);

        $this->set(compact('users'));
        $this->set('_serialize', ['users']);
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
