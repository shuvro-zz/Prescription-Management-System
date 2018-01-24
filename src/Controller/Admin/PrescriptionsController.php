<?php
namespace App\Controller\Admin;

use App\Controller\AppController;

/**
 * Prescriptions Controller
 *
 * @property \App\Model\Table\PrescriptionsTable $Prescriptions */
class PrescriptionsController extends AppController
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
            'contain' => ['Users'],
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
            'contain' => ['Users', 'Medicines', 'Tests']
        ]);
        $this->set('prescription', $prescription);
        $this->set('_serialize', ['prescription']);
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $prescription = $this->Prescriptions->newEntity();
        if ($this->request->is('post')) {
            $prescription = $this->Prescriptions->patchEntity($prescription, $this->request->data);
            if ($this->Prescriptions->save($prescription)) {
                //$this->Flash->success(__('The prescription has been saved.'));
                $this->Flash->adminSuccess('The prescription has been saved.', ['key' => 'admin_success']);
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The prescription could not be saved. Please, try again.'));
            }
        }
        //$users = $this->Prescriptions->Users->find('list', ['limit' => 200]);
        $get_users = $this->Prescriptions->Users->find('All');
        foreach($get_users as $get_user){
            $users[$get_user->id] = $get_user->first_name." ".$get_user->last_name;
        }


        $medicines = $this->Prescriptions->Medicines->find('list', ['limit' => 200]);
        $tests = $this->Prescriptions->Tests->find('list', ['limit' => 200]);
        $this->set(compact('prescription', 'users', 'medicines', 'tests'));
        $this->set('_serialize', ['prescription']);
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
            'contain' => ['Medicines', 'Tests']
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $prescription = $this->Prescriptions->patchEntity($prescription, $this->request->data);
            if ($this->Prescriptions->save($prescription)) {
                $this->Flash->success(__('The prescription has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The prescription could not be saved. Please, try again.'));
            }
        }

        //$users = $this->Prescriptions->Users->find('list', ['limit' => 200]);

        $get_users = $this->Prescriptions->Users->find('All');
        foreach($get_users as $get_user){
            $users[$get_user->id] = $get_user->first_name." ".$get_user->last_name;
        }

        $medicines = $this->Prescriptions->Medicines->find('list', ['limit' => 200]);
        $tests = $this->Prescriptions->Tests->find('list', ['limit' => 200]);
        $this->set(compact('prescription', 'users', 'medicines', 'tests'));
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
            $this->Flash->success(__('The prescription has been deleted.'));
        } else {
            $this->Flash->error(__('The prescription could not be deleted. Please, try again.'));
        }
        return $this->redirect(['action' => 'index']);
    }


    function __search(){
        $session = $this->request->session();
        if($session->check('prescriptions_search_query')){
            $search = $session->read('prescriptions_search_query');
            $where = [
                'OR' => ["
                    prescriptions.diagnosis LIKE '%$search%' OR
                    CONCAT( users.first_name, ' ', users.last_name ) LIKE '%$search%' OR
                    users.phone LIKE '%$search%'
                    "]
            ];

        }else{
            $where = [];
        }
        return $where;
    }

    function reset(){
        $session = $this->request->session();
        $session->delete('prescriptions_search_query');
        $this->redirect(['action' => 'index']);
    }



}
