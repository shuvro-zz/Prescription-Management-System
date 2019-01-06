<?php
namespace App\Controller\Admin;
use App\Controller\AppController;
use Cake\Event\Event;
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
    public function beforeFilter(Event $event)
    {
        parent::beforeFilter($event); // TODO: Change the autogenerated stub
        $this->Auth->allow(['getOnlinePrescriptions', 'getLocalPrescriptions']);
    }

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

        $is_print = isset($this->request->params['pass'][1])? $this->request->params['pass'][1]:'';
        $pdf_link = Router::url( '/uploads/pdf/'.$prescription->pdf_file, true );

        $this->set(compact('prescription', 'all_prescriptions', 'latest_prescription', 'pdf_link', 'is_print'));
        $this->set('_serialize', ['prescription']);
        $this->set('_serialize', ['prescription']);

        if ($this->request->session()->read('Auth.User')['prescription_template_id'] == 1){
            $this -> render('default');
        }
        elseif($this->request->session()->read('Auth.User')['prescription_template_id'] == 2){
            $this -> render('standard');
        }elseif($this->request->session()->read('Auth.User')['prescription_template_id'] == 3){
            $this -> render('classic');
        }elseif($this->request->session()->read('Auth.User')['prescription_template_id'] == 4){
            $this -> render('custom');
        }else{
            $this->render('general');
        }





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

            if (isset($this->request->data['medicines']['medicine_id'])){
                $this->removeBlankArray();
            }

            $patient_id = $this->savePatient($this->request->data['patients']);

            $diagnosis = isset($this->request->data['diagnosis'])?$this->request->data['diagnosis']:'';
            $medicines = isset($this->request->data['medicines'])?$this->request->data['medicines']:'';

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

            if (isset($this->request->data['medicines']['medicine_id'])){
                $this->removeBlankArray();
            }

            $patient_id = $this->savePatient($this->request->data['patients']);
            $medicines = isset($this->request->data['medicines'])?$this->request->data['medicines']:'';
            $diagnosis = isset($this->request->data['diagnosis'])?$this->request->data['diagnosis']:'';

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

        $tests = '';
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
        $doctor_info = $this->request->session()->read('Auth.User');

        $prescription_info = $this->Prescriptions->get($id);
        $patient_id = $prescription_info['user_id'];
        $patient_info = $this->Prescriptions->Users->get($patient_id);

        if ($patient_info->email){
            $file_path = 'uploads/pdf/'.$prescription_info->pdf_file;
            $file_name =  substr($file_path, strrpos($file_path, '/') + 1);

            $info = array(
                'to'                => $patient_info['email'],
                'subject'           => 'Prescription pdf',
                'template'          => 'prescription_pdf',
                'data'              => array('User' => $patient_info, 'Doctor' => $doctor_info),
                'attach'            => array('file_name' => $file_name, 'file_path' => $file_path )
            );
            $this->EmailHandler->sendEmail($info);

            $success_message = __('A pdf file has been sent to your patient email address.');
            $this->Flash->adminSuccess($success_message, ['key' => 'admin_success']);
        }else{
            $success_message = __('Patient email not found.');
            $this->Flash->adminWarning($success_message, ['key' => 'admin_error']);
        }

        $this->redirect(['action' => 'view/'.$id]);
    }

    function generatePrescriptionPdf($id = null){
        $this->generatePdf($id);

        $success_message = __('PDF file has been generated.');
        $this->Flash->adminSuccess($success_message, ['key' => 'admin_success']);
        $this->redirect(['action' => 'view/'.$id]);
    }

    function printOrDownload($id = null){
        $this->generatePdf($id);

        $prescription = $this->Prescriptions->get($id, [
            'contain' => ['Diagnosis.DiagnosisLists', 'Medicines', 'Tests', 'Users']
        ]);

        $pdf_link = Router::url( '/uploads/pdf/'.$prescription->pdf_file, true );

        echo "<script type='text/javascript'>                      
                  window.location.replace('$pdf_link');
        </script>";
    }

    function generatePdf($id){
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
                $this->request->session()->write('users_search_query', $patient_info->phone);

                return $this->redirect(['controller' => 'users', 'action' => '']);

                /*$latest_prescription = $this->Common->getLatestPrescription($patient_id);

                if($latest_prescription){
                    return $this->redirect(['action' => 'edit/'.$latest_prescription->id]);
                }else{
                    $this->Flash->admin_success('Patient found, You can create prescription for this patient', ['key' => 'admin_success']);
                    return $this->redirect(['action' => 'add/'.$patient_id]);
                }*/
            }else{
                $this->Flash->admin_warning('Patient not found, Please create a Patient', ['key' => 'admin_warning']);
                return $this->redirect(['controller' => 'users', 'action' => 'add']);
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
            $user = $this->Users->get($this->request->data['user_id']);
        }

        $user->role_id = 3;
        $user->doctor_id = $this->request->session()->read('Auth.User.id');
        $user->appointment_date = null;
        $user->is_visited = 1;
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
        if($medicines){
            $new_medicines = [];
            foreach($medicines['medicine_id'] as $key => $val) {
                $new_medicines[$key]['prescription_id'] = $prescription_id;
                $new_medicines[$key]['medicine_id'] = $val;
                $new_medicines[$key]['rule'] = $medicines['rule'][$key];
            }
            return $new_medicines;
        }
    }

    function getDiagnosisInfo(){
        $this->loadModel('Diagnosis');

        $diagnosis_info = $this->Diagnosis->find('all', ['contain' => ['DiagnosisLists']])
            ->order(['Diagnosis.id' => 'desc'])
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



/************************************************
///////////////////Api///////////////////////////
*************************************************/

    public function getOnlinePrescriptions(){
        $this->autoRender = false;
        header('Content-Type: application/json');

        if ($this->request->is('get')){

            $online_doctor_id = $this->Common->getOnlineDoctorId($this->request->query['doctor_email']);

            $online_prescriptions = $this->Prescriptions->find('all', ['contain' => ['Users', 'Medicines', 'Tests', 'Diagnosis', 'Diagnosis.DiagnosisLists']], ['limit' => 100])
                                            ->order(['Prescriptions.id' => 'asc'])
                                            ->where([
                                                'Prescriptions.doctor_id' => $online_doctor_id,
                                                'Prescriptions.is_sync' => 0
                                            ])->toArray();

            echo json_encode($online_prescriptions);die;

        }elseif ($this->request->is('post')){
            $this->changeIsSyncOnlinePrescriptions($this->request->data);
        }
    }

    function changeIsSyncOnlinePrescriptions($online_prescription_ids){
        foreach ($online_prescription_ids as $online_prescription_id){
            $prescription = $this->Prescriptions->get($online_prescription_id);
            $prescription->is_sync = 1;
            $this->Prescriptions->save($prescription);
        }
    }

    public function getLocalPrescriptions(){
        $this->autoRender = false;
        $this->loadModel('Users');
        $this->loadModel('Medicines');
        $this->loadModel('Tests');
        $this->loadModel('Diagnosis');
        $this->loadModel('DiagnosisLists');
        $this->loadModel('PrescriptionsDiagnosis');
        $this->loadModel('PrescriptionsMedicines');
        header('Content-Type: application/json');

        $online_doctor_id = $this->Common->getOnlineDoctorId($this->request->query['doctor_email']);

        if ($online_doctor_id){
            $prescriptions = $this->request->data;

            $online_success = 0;
            $will_sync_true_prescription_ids = [];

            foreach ($prescriptions as $prescription){
                $patient_first_name = $prescription['user']['first_name'];
                $patient_phone = $prescription['user']['phone'];

                $have_patient = $this->Users->find()->where(['Users.first_name' => $patient_first_name,
                                                            'Users.phone' => $patient_phone,
                                                            'Users.doctor_id' => $online_doctor_id
                                                        ])->first();

                if ($have_patient){
                    $will_sync_true_prescription_ids[] = $prescription['id'];

                    //Save local prescription and test to online
                    $prescription_id = $this->saveLocalPrescriptionAndTestToOnline($prescription, $prescription['tests'], $have_patient, $online_doctor_id);

                    //Save local prescription diagnosis to online
                    if ($prescription['formated_diagnosis']){
                        $this->saveLocalPrescriptionDiagnosisToOnline($prescription['formated_diagnosis'], $prescription_id, $online_doctor_id);
                    }

                    //Save local prescription medicine to online
                    if ($prescription['formated_medicines']){
                        $this->saveLocalPrescriptionMedicineToOnline($prescription['formated_medicines'], $prescription_id);
                    }
                    $online_success++;
                }
            }

            if ($will_sync_true_prescription_ids){
                echo json_encode([
                    'status'=>'success',
                    'will_sync_ids' => $will_sync_true_prescription_ids,
                    'online_success' => $online_success,
                ]);die;
            }
        }
        echo json_encode(['status'=>'fail']);die;
    }

    public function saveLocalPrescriptionAndTestToOnline($prescription, $prescription_tests, $have_patient, $online_doctor_id){
        $prescription_and_test = [];
        $tests = [];

        foreach ($prescription_tests as $prescription_test){
            $test_id = $this->Tests->findByName($prescription_test['name'])->select('Tests.id')->first();

            if ($test_id){
                $tests['_ids'][] = $test_id['id'];
            }
        }

        $prescription_and_test['user_id'] = $have_patient['id'];
        $prescription_and_test['blood_pressure'] = $prescription['blood_pressure'];
        $prescription_and_test['temperature'] = $prescription['temperature'];
        $prescription_and_test['doctores_notes'] = $prescription['doctores_notes'];
        $prescription_and_test['tests'] = $tests;
        $prescription_and_test['other_instructions'] = $prescription['other_instructions'];

        $prescription = $this->Prescriptions->newEntity();
        $prescription->doctor_id = $online_doctor_id;
        $prescription->is_sync = 1;

        $prescription = $this->Prescriptions->patchEntity($prescription, $prescription_and_test);
        $result = $this->Prescriptions->save($prescription);

        return $result->id;
    }

    public function saveLocalPrescriptionDiagnosisToOnline($prescription_diagnosis, $prescription_id, $online_doctor_id){

        foreach ($prescription_diagnosis as $prescription_diagnosi){
            $have_diagnosis_list_id = $this->DiagnosisLists->findByName($prescription_diagnosi['name'])->select('DiagnosisLists.id')->first();

            $have_diagnosis_template_id = $this->Diagnosis->find()->where(['Diagnosis.diagnosis_list_id' => $have_diagnosis_list_id['id'],
                                                                        'Diagnosis.doctor_id' => $online_doctor_id,
                                                                    ])->select('Diagnosis.id')->first();

            if ($have_diagnosis_list_id And $have_diagnosis_template_id){
                $item = [];
                $item['prescription_id'] = $prescription_id;
                $item['diagnosis_id'] = $have_diagnosis_template_id['id'];

                $prescription_diagnosis = $this->PrescriptionsDiagnosis->newEntity();
                $prescription_diagnosis = $this->PrescriptionsDiagnosis->patchEntity($prescription_diagnosis, $item);
                $this->PrescriptionsDiagnosis->save($prescription_diagnosis);
            }
        }
    }

    public function saveLocalPrescriptionMedicineToOnline($prescription_medicines, $prescription_id){
        foreach ($prescription_medicines as $prescription_medicine){
            $medicine_id = $this->Medicines->findByName($prescription_medicine['name'])->select('Medicines.id')->first();

            if ($medicine_id){
                $prescriptions_medicine = [];

                $prescriptions_medicine['prescription_id'] = $prescription_id;
                $prescriptions_medicine['medicine_id'] = $medicine_id['id'];
                $prescriptions_medicine['rule'] = $prescription_medicine['rule'];

                $prescription_medicine = $this->PrescriptionsMedicines->newEntity();
                $prescription_medicine = $this->PrescriptionsMedicines->patchEntity($prescription_medicine, $prescriptions_medicine);
                $this->PrescriptionsMedicines->save($prescription_medicine);
            }
        }
    }
}
