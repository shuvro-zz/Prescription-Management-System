<?php
namespace App\Controller\Admin;

use App\Controller\AppController;

/**
 * Diagnosis Controller
 *
 * @property \App\Model\Table\DiagnosisTable $Diagnosis */
class DiagnosisController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index()
    {
        $session = $this->request->session();

        if(isset($this->request->query['search']) and trim($this->request->query['search'])!='' ) {
            $session->write('diagnosis_search_query', $this->request->query['search']);
        }
        if($session->check('diagnosis_search_query')) {
            $search = $session->read('diagnosis_search_query');
        }else{
            $search = '';
        }

        $where = $this->__search();

        if($where){
            $query = $this->Diagnosis->find('All')->where($where);
        }else{
            $query = $this->Diagnosis;
        }

        $this->paginate = [
            'limit' => 30,
            'order' => [
                'Diagnosis.id' => 'desc'
            ]
        ];
        $diagnosis = $this->paginate($query);

        if(count($diagnosis)==0){
            $this->Flash->adminWarning(__('No Diagnosis found!')  ,['key' => 'admin_warning'], ['key' => 'admin_warning'] );
        }

        //$diagnosis = $this->paginate($this->Diagnosis);

        $this->set(compact('diagnosis', 'search'));
        $this->set('_serialize', ['diagnosis']);
    }

    /**
     * View method
     *
     * @param string|null $id Diagnosi id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $diagnosi = $this->Diagnosis->get($id, [
            'contain' => ['Medicines', 'Tests']
        ]);

        $this->set('diagnosi', $diagnosi);
        $this->set('_serialize', ['diagnosi']);
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $diagnosi = $this->Diagnosis->newEntity();
        if ($this->request->is('post')) {
            $diagnosi = $this->Diagnosis->patchEntity($diagnosi, $this->request->data);

            $diagnosi->doctor_id = $this->request->session()->read('Auth.User.id');
            if ($this->Diagnosis->save($diagnosi)) {
                $this->Flash->adminSuccess(__('The diagnosis has been saved.'),  ['key' => 'admin_success'] );
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->adminError(__('The diagnosis could not be saved. Please, try again.'), ['key' => 'admin_error']);
            }
        }
        $medicines = $this->Diagnosis->Medicines->find('list', ['limit' => 200]);
        $tests = $this->Diagnosis->Tests->find('list', ['limit' => 200]);
        $this->set(compact('diagnosi', 'medicines', 'tests'));
        $this->set('_serialize', ['diagnosi']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Diagnosi id.
     * @return \Cake\Network\Response|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $diagnosi = $this->Diagnosis->get($id, [
            'contain' => ['Medicines', 'Tests']
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $diagnosi = $this->Diagnosis->patchEntity($diagnosi, $this->request->data);
            if ($this->Diagnosis->save($diagnosi)) {
                $this->Flash->adminSuccess(__('The diagnosis has been saved.'), ['key' => 'admin_success']);
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->adminError(__('The diagnosis could not be saved. Please, try again.'), ['key' => 'admin_error']);
            }
        }
        $medicines = $this->Diagnosis->Medicines->find('list', ['limit' => 200]);
        $tests = $this->Diagnosis->Tests->find('list', ['limit' => 200]);
        $this->set(compact('diagnosi', 'medicines', 'tests'));
        $this->set('_serialize', ['diagnosi']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Diagnosi id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $diagnosi = $this->Diagnosis->get($id);
        if ($this->Diagnosis->delete($diagnosi)) {
            $success_message = __('The test has been deleted.');
            $this->Flash->adminSuccess($success_message, ['key' => 'admin_success']);
        } else {
            $this->Flash->adminError(__('The diagnosis could not be deleted. Please, try again.') , ['key' => 'admin_error']);
        }
        return $this->redirect(['action' => 'index']);
    }

    function __search(){
        $session = $this->request->session();

        $doctor_id = $session->read('Auth.User.id');

        if($session->check('diagnosis_search_query')){
            $search = $session->read('diagnosis_search_query');
            $where = ['Diagnosis.doctor_id' => $doctor_id,
                'OR' => [
                    ['Diagnosis.name LIKE' => '%' . $search . '%']
                ]
            ];
        }else{
            $where = ['Diagnosis.doctor_id' => $doctor_id];
        }
        return $where;
    }

    function reset(){
        $session = $this->request->session();
        $session->delete('diagnosis_search_query');
        $this->redirect(['action' => 'index']);
    }


    function getDiagnosis($ids,$prescription_id = null){
        $this->viewBuilder()->layout('ajax');
        $this->autoRender = false;



        $ids = explode("_",$ids);
        if($ids){
            $contain = ['contain' =>['Medicines', 'Tests']];
            $diagnosis = $this->Diagnosis->find('all',$contain)->where([
                    'Diagnosis.id IN ' => $ids
                ]);

            $medicines = $this->prepareMedicines($diagnosis,$prescription_id);

            $tests = $this->prepareTests($diagnosis);


            $instructions = array();
            foreach($diagnosis as $item){
                $instructions[] = $item->instructions;
            }

            $all_instructions = implode(",\n",$instructions);
        }

        echo json_encode(array('medicines' => $medicines, 'tests' => $tests, 'all_instructions' => $all_instructions));die;
    }

    function prepareMedicines($diagnosis,$prescription_id){

        $medicines = [];
        foreach($diagnosis as $item){
            if($item->medicines){
                foreach($item->medicines as $medicine){
                    $rule = $this->getMedicineRule($prescription_id, $medicine->id);
                    $medicines[] = array('id' => $medicine->id, 'name' => $medicine->name, 'rule' =>$rule  );
                }
            }
        }

        return $medicines;
    }

    function prepareTests($diagnosis){
        $tests = [];
        foreach($diagnosis as $item){
            if($item->tests){
                foreach($item->tests as $test){
                    $tests[$test->id] = $test->name;
                }
            }
        }
        return $tests;
    }

    function getMedicineRule($prescription_id, $medicine_id){
        if(is_numeric($prescription_id)){
            $this->loadModel('PrescriptionsMedicines');
            $prescriptions_medicines = $this->PrescriptionsMedicines->find('all')
                ->where(['PrescriptionsMedicines.prescription_id' => $prescription_id,
                    'PrescriptionsMedicines.medicine_id' => $medicine_id])->first();

            if(!empty($prescriptions_medicines->rule)) {
                return $prescriptions_medicines->rule;
            }
        }
    }



    function isDiagnosisAvailable(){
        $this->autoRender = false;
        $diagnosis = $this->Diagnosis->findByName($this->request->data['name'])
            ->where([
                'Diagnosis.doctor_id' => $this->request->session()->read('Auth.User.id')
            ]);

        $diagnosis = $diagnosis->toArray();
        if(empty($diagnosis)){
            echo 'true';die;
        }else{
            echo 'false';die;
        }

    }
}
