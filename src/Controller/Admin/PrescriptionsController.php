<?php
namespace App\Controller\Admin;
use App\Controller\AppController;
use Cake\ORM\TableRegistry;
use Cake\Filesystem\Folder;
use Cake\Filesystem\File;
use Cake\Routing\Router;

/**
 * Prescriptions Controller
 *
 * @property \App\Model\Table\PrescriptionsTable $Prescriptions */
class PrescriptionsController extends AppController
{
    public $components = ['EmailHandler','Common', 'PdfHandler'];

    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */

    public function index()
    {
        $session = $this->request->session();
        if(isset($this->request->query['search']) and trim($this->request->query['search'])!='' ) {
            $session->write('prescriptions_search_query', $this->request->query['search']);

        }
        if($session->check('prescriptions_search_query')) {
            $search = $session->read('prescriptions_search_query');
        }else{
            $search = '';
        }

        $where = $this->__search();

        if($where){
            $query = $this->Prescriptions->find('All')->where($where);
        }else{
            $query = $this->Prescriptions;
        }

        $this->paginate = [
            'contain' => ['Users','Diagnosis.DiagnosisLists'],
            'limit' => 30,
            'order' => [
                'Prescriptions.id' => 'desc'
            ]
        ];


        $prescriptions = $this->paginate($query);

        if(count($prescriptions)==0){
            $this->Flash->adminWarning(__('No prescription found!')  ,['key' => 'admin_warning'], ['key' => 'admin_warning'] );
        }

        $this->set(compact('prescriptions', 'search' ));
        $this->set('_serialize', ['prescriptions']);

    }

    /**
     * View method
     *
     * @param string|null $id Prescription id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $prescription = $this->Prescriptions->get($id, [
            'contain' => ['Diagnosis.DiagnosisLists', 'Medicines', 'Tests', 'Users']
        ]);

        $patient_id = $prescription->user->id;
        $all_prescriptions = $this->Common->getAllPrescriptions($patient_id);

        $latest_prescription = $this->Common->getLatestPrescription($patient_id);

        $pdf_link = Router::url( '/uploads/pdf/'.$prescription->pdf_file, true );

        $is_print = isset($this->request->params['pass'][1])? $this->request->params['pass'][1]:'';

        $this->set(compact('prescription', 'all_prescriptions', 'latest_prescription', 'pdf_link', 'is_print'));
        $this->set('_serialize', ['prescription']);

        //$order_pdf_file = $this->PdfHandler->writeOrderPdfFile($prescription);
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|void Redirects on successful add, renders view otherwise.
     */
    public function add($patient_id = null)
    {
        $prescription = $this->Prescriptions->newEntity();

        if ($this->request->is('post')) {
            $this->removeBlankArray();
            $patient_id = $this->savePatient($this->request->data['patients']);

            $diagnosis = $this->request->data['diagnosis'];
            $medicines = $this->request->data['medicines'];

            unset($this->request->data['medicines']);
            unset($this->request->data['diagnosis']);

            if(empty($this->request->data['user_id'])){
                $this->request->data['user_id'] = $patient_id;
            }

            $prescription->doctor_id = $this->request->session()->read('Auth.User.id');
            $prescription = $this->Prescriptions->patchEntity($prescription, $this->request->data);

            if ($this->Prescriptions->save($prescription)) {

                $this->savePrescriptionsDiagnosis($diagnosis, $prescription->id);
                $this->savePrescriptionsMedicines($medicines, $prescription->id);

                if(($this->request->data('is_print')) == 1){
                    return $this->redirect(['action' => 'view/'.$prescription->id.'/print']);
                }else{
                    $this->Flash->adminSuccess('The prescription has been saved.', ['key' => 'admin_success']);
                    return $this->redirect(['action' => 'index']);
                }
            } else {
                $error_message = __('The prescription could not be save. Please, try again.');
                $this->Flash->adminError($error_message, ['key' => 'admin_error']);
            }
            return $this->redirect(['action' => 'index']);
        }

        $doctor_id = $this->request->session()->read('Auth.User.id');
        $get_users = $this->Prescriptions->Users->find('All')->where(['Users.role_id' => 3, 'Users.doctor_id' => $doctor_id]);//role_id =>3 that's mean patient

        $users = '';
        if($get_users){
            foreach($get_users as $get_user){
                $users[$get_user->id] = $get_user->first_name." - " . "$get_user->phone";
            }
        }

        $prescription_medicines = array('medicine_id'=>'');
        $prescription_tests = array('test_id'=>'');
        $medicines = $this->Prescriptions->Medicines->find('list', ['limit' => 1]);
        $tests = $this->Prescriptions->Tests->find('list', ['limit' => 1]);
        $diagnosis = $this->getDiagnosisInfo();

        if($patient_id){
            $patient = $this->Prescriptions->Users->get($patient_id);
            $prescription->user = $patient->toArray();
        }

        $prescriptions_link = $last_visit_date = '';

        $this->set(compact('prescription', 'users', 'prescription_tests', 'prescription_medicines', 'medicines', 'tests', 'diagnosis', 'prescriptions_link', 'last_visit_date'));
        $this->set('_serialize', ['prescription']);
    }

    public function removeBlankArray(){
        if($this->request->data['medicines']['medicine_id']){
            $medicine_ids = [];
            foreach($this->request->data['medicines']['medicine_id'] as $key => $value){
                if(!empty($value) and $value!='' and is_array($value)){
                    $medicine_ids[] = $value[0];
                }
            }
            $this->request->data['medicines']['medicine_id'] = $medicine_ids;
        }
    }

    /**
     * Edit method
     *
     * @param string|null $id Prescription id.
     * @return \Cake\Network\Response|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $prescription = $this->Prescriptions->get($id, [
            'contain' => ['PrescriptionsDiagnosis', 'Medicines', 'Tests', 'Users']
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $this->removeBlankArray();
            $patient_id = $this->savePatient($this->request->data['patients']);
            $medicines = isset($this->request->data['medicines'])?$this->request->data['medicines']:'';
            $diagnosis = $this->request->data['diagnosis'];

            unset($this->request->data['medicines']);
            unset($this->request->data['diagnosis']);

            if(empty($this->request->data['user_id'])){
                $this->request->data['user_id'] = $patient_id;
            }

            $prescription = $this->Prescriptions->patchEntity($prescription, $this->request->data);

            if ($this->Prescriptions->save($prescription)) {

                $this->savePrescriptionsDiagnosis($diagnosis, $prescription->id);
                $this->savePrescriptionsMedicines($medicines, $prescription->id);

                $success_message = __('The prescription has been edited.');
                $this->Flash->adminSuccess($success_message, ['key' => 'admin_success']);

                if(($this->request->data('is_print')) == 1){
                    return $this->redirect(['action' => 'view/'.$prescription->id.'/print']);
                }else{
                    return $this->redirect(['action' => 'index']);
                }
            } else {
                $error_message = __('The prescription could not be edit. Please, try again.');
                $this->Flash->adminError($error_message, ['key' => 'admin_error']);
                return $this->redirect(['action' => 'index']);
            }

        }

        $get_users = $this->Prescriptions->Users->find('All')->where(['Users.role_id' => 3, 'Users.doctor_id' =>  $this->request->session()->read('Auth.User.id')]);//role_id =>3 that's mean patient;
        foreach($get_users as $get_user){
            $users[$get_user->id] = $get_user->first_name. " - " . "$get_user->phone";
        }

        $prescription_diagnosis = $this->Prescriptions->PrescriptionsDiagnosis->find('all')->where(['PrescriptionsDiagnosis.prescription_id' => $id ]);
        $prescription_medicines = $this->Prescriptions->PrescriptionsMedicines->find('all')->where(['PrescriptionsMedicines.prescription_id' => $id ]);
        $prescription_tests = $this->Prescriptions->PrescriptionsTests->find('all')->where(['PrescriptionsTests.prescription_id' => $id ]);
        $diagnosis = $this->getDiagnosisInfo();

        $patient = $prescription->toArray();
        $all_prescriptions = $this->Common->getAllPrescriptions($patient['user_id']);

        $prescriptions_link = '';
        if($all_prescriptions){
            foreach($all_prescriptions as $all_prescription){
                $prescriptions_link .=  '<li><a href="'. Router::url('/admin/prescriptions/view/'.$all_prescription->id, true ).'" target="_blank">'.$all_prescription->created->format('d F Y').'</a></li>';
            }
        }

        $latest_prescription = $this->Common->getLatestPrescription($patient['user_id']);
        $last_visit_date = $latest_prescription->created->format('d F Y');

        $medicines = [];
        if(count($prescription_medicines->toArray())==0){
            $prescription_medicines = array('medicine_id'=>'');
        }else{
            $default_medicines = [];
            foreach($prescription_medicines as $prescription_medicine){
                $default_medicines[] = $prescription_medicine->medicine_id;
            }

            $medicines = $this->Prescriptions->Medicines->find('list', ['limit' => 200])->where(
                ['Medicines.id IN' => $default_medicines]
            );
        }

        $default_tests = [];
        if($prescription_tests){
            foreach($prescription_tests as $prescription_test){
                $default_tests[] = $prescription_test['test_id'];
            }
        }

        if($default_tests){
            $tests = $this->Prescriptions->Tests->find('list', ['limit' => 200])->where(
                ['Tests.id IN' => $default_tests]
            );
        }

        $this->set(compact('prescription', 'users', 'medicines','prescription_medicines', 'prescription_tests', 'tests' ,'diagnosis','prescription_diagnosis', 'prescriptions_link', 'last_visit_date', 'default_tests'));
        $this->set('_serialize', ['prescription']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Prescription id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $prescription = $this->Prescriptions->get($id);
        if ($this->Prescriptions->delete($prescription)) {
            $success_message = __('The prescription has been deleted.');
            $this->Flash->adminSuccess($success_message, ['key' => 'admin_success']);
        } else {
            $error_message = __('The prescription could not be delete. Please, try again.');
            $this->Flash->adminError($error_message, ['key' => 'admin_error']);
        }
        return $this->redirect(['action' => 'index']);
    }

    public function setPatient(){

        $session = $this->request->session();
        $session->write('set_patient_id', $this->request->query['user_id']);

        if($session->check('prescriptions_search_query')){
            $session->delete('prescriptions_search_query');
        }

        return $this->redirect(['action' => 'index']);
    }

    function __search(){

        $session = $this->request->session();

        $doctor_id = $session->read('Auth.User.id');

        $patients_prescription = '';
        if($session->check('set_patient_id')){
            $patient_id = $session->read('set_patient_id');
            $patients_prescription = ['Prescriptions.user_id' => $patient_id];
        }

        if($session->check('prescriptions_search_query')){
            $search = $session->read('prescriptions_search_query');
            $where = ['Prescriptions.doctor_id' => $doctor_id,
                $patients_prescription,
                'OR' => ["(
                    CONCAT( Users.first_name, ' ', Users.last_name ) LIKE '%$search%' OR
                    Users.phone LIKE '%$search%'
                    )"]
            ];

        }else{
            $where =  [
                'Prescriptions.doctor_id' => $doctor_id,
                $patients_prescription
            ];
        }
        return $where;
    }

    function reset(){
        $session = $this->request->session();
        $session->delete('prescriptions_search_query');
        $session->delete('set_patient_id');
        $this->redirect(['action' => 'index']);
    }
    function patientIdReset(){
        $session = $this->request->session();
        $session->delete('set_patient_id');
        $this->redirect(['action' => 'index']);
    }

    function sendPrescriptionEmail($id = null){
        // data $prescription_id

        $doctor_info = $this->request->session()->read('Auth.User');

        $prescription_info = $this->Prescriptions->get($id);
        $patient_id = $prescription_info['user_id'];
        $patient_info = $this->Prescriptions->Users->get($patient_id);

        $file_path = 'uploads/pdf/'.$prescription_info->pdf_file;
        $file_name =  substr($file_path, strrpos($file_path, '/') + 1);

        $info = array(
            'to'                => $patient_info['email'],
            'subject'           => 'Prescription pdf',
            'template'          => 'prescription_pdf',
            'data'              => array('User' => $patient_info, 'Doctor' => $doctor_info),
            'attach'            => array('file_name' => $file_name, 'file_path' => $file_path )
        );
        //pr($info);die;
        $this->EmailHandler->sendEmail($info);

        $success_message = __('A pdf file has been sent to your patient email address.');
        $this->Flash->adminSuccess($success_message, ['key' => 'admin_success']);

        $this->redirect(['action' => 'view/'.$id]);
    }

    function generatePrescriptionPdf($id = null){
        $this->autoRender = false;

        $prescription = $this->Prescriptions->get($id, [
            'contain' => ['Diagnosis.DiagnosisLists', 'Medicines', 'Tests', 'Users']
        ]);

        $patient_id = $prescription->user->id;

        $latest_prescription = $this->Common->getLatestPrescription($patient_id);

        $order_pdf_file = $this->PdfHandler->writeOrderPdfFile($prescription,$latest_prescription);

        if($order_pdf_file){
            $new_pdf_file_name = basename($order_pdf_file);
            $exit_pdf_file_name = $prescription->pdf_file;

            if(!empty($exit_pdf_file_name)){

                $this->deletePdf($exit_pdf_file_name);

                $prescription->pdf_file = $new_pdf_file_name;
                $this->Prescriptions->save($prescription);

            }else{
                $prescription->pdf_file = $new_pdf_file_name;
                $this->Prescriptions->save($prescription);
            }

            $success_message = __('PDF file has been generated.');
            $this->Flash->adminSuccess($success_message, ['key' => 'admin_success']);
            $this->redirect(['action' => 'view/'.$id]);
        }
    }

    function deletePdf($exit_pdf_file_name){

        $file = new File(WWW_ROOT.DS. 'uploads'.DS. 'pdf' .DS. $exit_pdf_file_name);
        $file->delete();
    }

    function searchPatient(){
       $this->autoRender = false;

        if(isset($this->request->query['search']) and trim($this->request->query['search'])!='' ) {
            $search_phone_no = $this->request->query['search'];

            $this->loadModel('Users');
            $patient_info = $this->Users->find('all')
                ->where([
                    'Users.phone' => $search_phone_no,
                    'Users.doctor_id' => $this->request->session()->read('Auth.User.id')
                ])->first();

            if($patient_info){
                $patient_id = $patient_info->id;

                $latest_prescription = $this->Common->getLatestPrescription($patient_id);

                if($latest_prescription){
                    return $this->redirect(['action' => 'edit/'.$latest_prescription->id]);
                }else{
                    $this->Flash->admin_success('Patient found, You can create prescription for this patient', ['key' => 'admin_success']);
                    return $this->redirect(['action' => 'add/'.$patient_id]);
                }
            }else{
                $this->Flash->admin_warning('Patient not found, Please select a Patient', ['key' => 'admin_warning']);
                return $this->redirect(['action' => 'add']);
            }
        }
        $this->set(compact('patient_info'));
   }

    function savePatient($patients){
        $this->loadModel('Users');

        if(empty($this->request->data['user_id'])){
            $user = $this->Users->newEntity();
        }else{
            unset($patients['first_name']);
            /*unset($patients['address_line1']);*/
            $user = $this->Users->get($this->request->data['user_id']);
        }

        $user->role_id = 3;
        $user->doctor_id = $this->request->session()->read('Auth.User.id');
        $user = $this->Users->patchEntity($user, $patients);
        $user = $this->Users->save($user);
        if($user) {
            return $user->id;
        }else{
            $this->log('could not save user');
        }
    }

    function savePrescriptionsMedicines($medicines, $prescription_id){
        // Start: Prescriptions medicines
        $this->loadModel('PrescriptionsMedicines');
        $this->PrescriptionsMedicines->deleteAll(['PrescriptionsMedicines.prescription_id' => $prescription_id]);

        $prescriptions_medicines = $this->prepareMedicine($medicines, $prescription_id);
        if($prescriptions_medicines){
            foreach($prescriptions_medicines as $prescriptions_medicine){
                $prescription_medicine = $this->PrescriptionsMedicines->newEntity();
                $prescription_medicine = $this->PrescriptionsMedicines->patchEntity($prescription_medicine, $prescriptions_medicine );
                if(!$this->PrescriptionsMedicines->save($prescription_medicine)){
                    $this->log('PrescriptionsMedicines could not save');
                }
            }
        }
        // End: Prescriptions medicines
    }

    function prepareMedicine($medicines,$prescription_id){
        //pr($medicines);
        if($medicines){
            $new_medicines = [];
            foreach($medicines['medicine_id'] as $key => $val) {
                $new_medicines[$key]['prescription_id'] = $prescription_id;
                $new_medicines[$key]['medicine_id'] = $val;
                $new_medicines[$key]['rule'] = $medicines['rule'][$key];
            }
            //pr($new_medicines);die;
            return $new_medicines;
        }
    }

    function getDiagnosisInfo(){
        $this->loadModel('Diagnosis');

        $diagnosis_info = $this->Diagnosis->find('all', ['contain' => ['DiagnosisLists']])
            ->where([
                'Diagnosis.doctor_id' => $this->request->session()->read('Auth.User.id')
            ]);

        $diagnosis_list = [];
        if($diagnosis_info){
            foreach($diagnosis_info as $diagnosis){
                $diagnosis_list[$diagnosis->id] = $diagnosis->diagnosis_list['name'];
            }
        }

        return $diagnosis_list;
    }

    function savePrescriptionsDiagnosis($diagnosis, $prescription_id){
        // Start: Prescriptions diagnosis
        $this->loadModel('PrescriptionsDiagnosis');
        $this->PrescriptionsDiagnosis->deleteAll(['PrescriptionsDiagnosis.prescription_id' => $prescription_id]);

        $prescriptions_diagnosis = $this->prepareDiagnosis($diagnosis, $prescription_id);
        if($prescriptions_diagnosis){
            foreach($prescriptions_diagnosis as $item){
                $prescription_diagnosis = $this->PrescriptionsDiagnosis->newEntity();
                $prescription_diagnosis = $this->PrescriptionsDiagnosis->patchEntity($prescription_diagnosis, $item );
                if(!$this->PrescriptionsDiagnosis->save($prescription_diagnosis)){
                    $this->log('Prescription Diagnosis could not save');
                }
            }
        }
        // End: Prescriptions diagnosis
    }

    function prepareDiagnosis($diagnosis,$prescription_id){
        if($diagnosis){
            $new_diagnosis = [];
            foreach($diagnosis as $key => $val) {
                $new_diagnosis[$key]['prescription_id'] = $prescription_id;
                $new_diagnosis[$key]['diagnosis_id'] = $val;
            }
            return $new_diagnosis;
        }
    }
}

