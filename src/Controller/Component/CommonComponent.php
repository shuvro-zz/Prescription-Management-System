<?php
namespace App\Controller\Component;

use Cake\Controller\Component;
use Cake\Utility\Inflector;
use Cake\ORM\TableRegistry;
use Cake\Datasource\ConnectionManager;

class CommonComponent extends Component
{
    var $controller;

    public function initialize(array $config = [])
    {
        parent::initialize($config);
        $this->controller = $this->_registry->getController();
    }
    
    
    public function getSettingByKey($key){

        $settingTable = TableRegistry::get('Settings');

        $settings = $settingTable->find()->where(['Settings.key_name'=>$key])->first();

        if(!empty($settings['value'])){
            return $settings['value'];
        } else {
            return false;
        }
    }

    public function strToTime($date) {
        $date = str_replace('/', '-', $date);
        return strtotime($date);
    }

    function __addSlug(){
        $this->controller->request->data['slug'] = Inflector::slug($this->controller->request->data['name'] );
    }

    function getAllPrescriptions($patient_id){

        $doctor_id = $this->request->session()->read('Auth.User.id');
        $this->controller->loadModel('Prescriptions');
        //start all prescription
        $all_prescriptions = $this->controller->Prescriptions->find('all')
            ->where([
                'Prescriptions.doctor_id' => $doctor_id,
                'Prescriptions.user_id' => $patient_id
            ]);

        return $all_prescriptions;
        //End all prescription
    }

    function getLatestPrescription($patient_id){
        $doctor_id = $this->request->session()->read('Auth.User.id');
        $this->controller->loadModel('Prescriptions');

        $latest_prescription = $this->controller->Prescriptions->find('all')
            ->where([
                'Prescriptions.doctor_id' => $doctor_id,
                'Prescriptions.user_id' => $patient_id
            ])
            ->order(['Prescriptions.id' => 'desc'])->first();

        return $latest_prescription;
    }

    function getOnlineDoctorId($local_doctor_email){
        $this->controller->loadModel('Users');

        $online_doctor_id = $this->controller->Users->find()->where(['Users.email' => $local_doctor_email])
                            ->select('id')->first();

        return $online_doctor_id['id'];
    }

   /* function addTodayAppointment(){
        $this->controller->loadModel('Users');

        $patient = $this->controller->Users->get($this->request->data['user_id']);
        $patient->appointment_date = date('Y-m-d ');
        $patient->serial_no = $this->request->data['serial_no'];
        $patient->is_visited = 0;

        return $this->controller->Users->save($patient);
    }*/

    function addAppointments(){
        $this->controller->loadModel('Users');

        $appointment_date = $this->request->data['appointment_date'];
        $storable_date = ($appointment_date == 'today_appointment')?date('Y-m-d '):date('Y-m-d', strtotime($this->request->data['appointment_calender_date']));

        $patient = $this->controller->Users->get($this->request->data['user_id']);
        $patient->appointment_date = $storable_date;
        $patient->serial_no = $this->request->data['serial_no'];
        $patient->is_visited = 0;

        return $this->controller->Users->save($patient);
    }
}