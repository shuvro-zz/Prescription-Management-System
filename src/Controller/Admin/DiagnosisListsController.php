<?php
namespace App\Controller\Admin;

use App\Controller\AppController;
use App\Model\Entity\Medicine;
use Cake\Filesystem\File;

/**
 * Diagnosis Controller
 *
 * @property \App\Model\Table\TestsTable $Tests */
class DiagnosisListsController extends AppController
{
    public $components = ['FileHandler'];

    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index()
    {
        //pr($this->request->query['search']);die;
        $session = $this->request->session();

        if(isset($this->request->query['search']) and trim($this->request->query['search'])!='' ) {
            $session->write('diagnosis_list_search_query', $this->request->query['search']);
        }
        if($session->check('diagnosis_list_search_query')) {
            $search = $session->read('diagnosis_list_search_query');
        }else{
            $search = '';
        }

        $where = $this->__search();

        if($where){
            $query = $this->DiagnosisLists->find('All')->where($where);
        }else{
            $query = $this->DiagnosisLists;
        }

        $this->paginate = [
            'limit' => 30,
            'order' => [
                'Diagnosis.id' => 'desc'
            ]
        ];
        $diagnosis = $this->paginate($query);

        if(count($diagnosis)==0){
            $this->Flash->adminWarning(__('No diagnosis found!')  ,['key' => 'admin_warning'], ['key' => 'admin_warning'] );
        }

        $this->set(compact('diagnosis', 'search'));
        $this->set('_serialize', ['diagnosis']);
    }

    /**
     * View method
     *
     * @param string|null $id Test id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $diagnosis = $this->DiagnosisLists->get($id, [
            'contain' => []
        ]);

        $this->set('diagnosis', $diagnosis);
        $this->set('_serialize', ['diagnosis']);
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $diagnosis = $this->DiagnosisLists->newEntity();
        if ($this->request->is('post')) {
            $diagnosis = $this->DiagnosisLists->patchEntity($diagnosis, $this->request->data);
            if ($this->DiagnosisLists->save($diagnosis)) {
                $success_message = __('The diagnosis has been saved.');
                $this->Flash->adminSuccess($success_message, ['key' => 'admin_success']);
            } else {
                $error_message = __('The diagnosis could not be save. Please, try again.');
                $this->Flash->adminError($error_message, ['key' => 'admin_error']);
            }
            return $this->redirect(['action' => 'index']);
        }
        $this->set(compact('diagnosis'));
        $this->set('_serialize', ['diagnosis']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Test id.
     * @return \Cake\Network\Response|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $diagnosis = $this->DiagnosisLists->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {

            $diagnosis_list = $this->DiagnosisLists->find('all')
                ->where([
                    'DiagnosisLists.name' => trim($this->request->data['name']),
                    'DiagnosisLists.id !=' => $id
                ])
                ->first();

            if(empty($diagnosis_list)){
                $diagnosis = $this->DiagnosisLists->patchEntity($diagnosis, $this->request->data);
                if ($this->DiagnosisLists->save($diagnosis)) {
                    $success_message = __('The diagnosis has been edited.');
                    $this->Flash->adminSuccess($success_message, ['key' => 'admin_success']);
                } else {
                    $error_message = __('The diagnosis could not be edit. Please, try again.');
                    $this->Flash->adminError($error_message, ['key' => 'admin_error']);
                }
                return $this->redirect(['action' => 'index']);
            }else{
                $this->Flash->adminWarning(__('The diagnosis already exit'), ['key' => 'admin_warning']);
                return $this->redirect(['action' => 'edit/'.$id]);
            }
        }
        $this->set(compact('diagnosis'));
        $this->set('_serialize', ['diagnosis']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Test id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $diagnosis = $this->DiagnosisLists->get($id);
        if ($this->DiagnosisLists->delete($diagnosis)) {
            $success_message = __('The diagnosis has been deleted.');
            $this->Flash->adminSuccess($success_message, ['key' => 'admin_success']);
        } else {
            $error_message = __('The diagnosis could not be delete. Please, try again.');
            $this->Flash->adminError($error_message, ['key' => 'admin_error']);
        }
        return $this->redirect(['action' => 'index']);
    }

    function __search(){
        $session = $this->request->session();
        if($session->check('diagnosis_list_search_query')){
            $search = $session->read('diagnosis_list_search_query');
            $where = [
                'OR' => [
                    ['DiagnosisLists.name LIKE' => '%' . $search . '%']
                ]
            ];
        }else{
            $where = [];
        }
        return $where;
    }

    function reset(){
        $session = $this->request->session();
        $session->delete('diagnosis_list_search_query');
        $this->redirect(['action' => 'index']);
    }

    function isDiagnosisAvailable(){
        $this->autoRender = false;
        $diagnosis = $this->DiagnosisLists->findByName($this->request->data['name'])->toArray();
        if(empty($diagnosis)){
            echo 'true';die;
        }else{
            echo 'false';die;
        }

    }

    function importCsv(){
        if( isset($this->request->data['csv_file']) ){
            // start resume  up
            $import_diagnosis = $this->request->data['csv_file'];
            $getExtension = pathinfo($import_diagnosis['name']);

            if($getExtension['extension'] == 'csv'){
                if ($import_diagnosis) {
                    $result = $this->FileHandler->uploadfile($import_diagnosis);
                    if ($result) {
                        $import_diagnosis= $this->FileHandler->_uploadimgname;

                        // Set path to CSV file
                        $csv = $this->readCSV('uploads/diagnosislists/'.$import_diagnosis);

                        foreach($csv as $values){
                            if(!empty($values)){
                                foreach($values as $value){
                                    $isExit = $this->DiagnosisLists->findByName($value)->toArray();
                                    if(empty($isExit)){
                                        $diagnosis = $this->DiagnosisLists->newEntity();
                                        $diagnosis = $this->DiagnosisLists->patchEntity($diagnosis, $this->makeSaveRecordPattern(preg_replace('/\s+/', ' ', $value)));
                                        $this->DiagnosisLists->save($diagnosis);
                                    }
                                }
                            }
                        }
                        /*$file = new File(WWW_ROOT.DS. 'uploads'.DS. 'diagnosislists' .DS. $import_diagnosis);
                        $file->delete();*/

                        $success_message = __('Diagnosis import successfully.');
                        $this->Flash->adminSuccess($success_message, ['key' => 'admin_success']);
                    }else {
                        $error_message = __('There was a problem. Please, try again.');
                        $this->Flash->adminError($error_message, ['key' => 'admin_error']);
                    }
                }
            }else{
                $error_message = __('Please upload a csv File');
                $this->Flash->adminError($error_message, ['key' => 'admin_error']);
            }
            return $this->redirect(['action' => 'import_csv']);
        }
    }

    function readCSV($csvFile){
        $file_handle = fopen($csvFile, 'r');
        while (!feof($file_handle) ) {
            $line_of_text[] = fgetcsv($file_handle, 1024);
        }
        fclose($file_handle);
        return $line_of_text;
    }

    function makeSaveRecordPattern($value){
        $medicine = [];
        $medicine['name'] = $value;
        return $medicine;
    }

}
