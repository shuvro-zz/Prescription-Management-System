<?php
namespace App\Controller\Admin;
use App\Controller\AppController;

/**
 * Medicines Controller
 *
 * @property \App\Model\Table\MedicinesTable $Medicines */
class MedicinesController extends AppController
{
    public $components = ['FileHandler'];

    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index()
    {
        $session = $this->request->session();

        if(isset($this->request->query['search']) and trim($this->request->query['search'])!='' ) {
            $session->write('medicines_search_query', $this->request->query['search']);
        }
        if($session->check('medicines_search_query')) {
            $search = $session->read('medicines_search_query');
        }else{
            $search = '';
        }

        $where = $this->__search();

        if($where){
            $query = $this->Medicines->find('All')->where($where);
        }else{
            $query = $this->Medicines;
        }

        $this->paginate = [
            'limit' => 30,
            'order' => [
                'Medicines.id' => 'desc'
            ]
        ];
        $medicines = $this->paginate($query);

        if(count($medicines)==0){
            $this->Flash->adminWarning(__('No medicine found!')  ,['key' => 'admin_warning'], ['key' => 'admin_warning'] );
        }

        $this->set(compact('medicines', 'search' ));
        $this->set('_serialize', ['medicines']);
    }

    /**
     * View method
     *
     * @param string|null $id Medicine id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $medicine = $this->Medicines->get($id, ['contain' => [] ]);

        $this->set('medicine', $medicine);
        $this->set('_serialize', ['medicine']);
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $medicine = $this->Medicines->newEntity();
        if ($this->request->is('post')) {
            $medicine = $this->Medicines->patchEntity($medicine, $this->request->data);
            if ($this->Medicines->save($medicine)) {
                $success_message = __('The medicine has been saved.');
                $this->Flash->adminSuccess($success_message, ['key' => 'admin_success']);
            } else {
                $error_message = __('The medicine could not be saved. Please, try again.');
                $this->Flash->adminError($error_message, ['key' => 'admin_error']);
            }
            return $this->redirect(['action' => 'index']);
        }
        $this->set(compact('medicine'));
        $this->set('_serialize', ['medicine']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Medicine id.
     * @return \Cake\Network\Response|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $medicine = $this->Medicines->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $medicine = $this->Medicines->patchEntity($medicine, $this->request->data);
            if ($this->Medicines->save($medicine)) {
                $success_message = __('The medicine has been edited.');
                $this->Flash->adminSuccess($success_message, ['key' => 'admin_success']);
            } else {
                $error_message = __('The medicine could not be edited. Please, try again.');
                $this->Flash->adminError($error_message, ['key' => 'admin_error']);
            }
            return $this->redirect(['action' => 'index']);
        }
        $this->set(compact('medicine'));
        $this->set('_serialize', ['medicine']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Medicine id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $medicine = $this->Medicines->get($id);
        if ($this->Medicines->delete($medicine)) {
            $success_message = __('The medicine has been deleted.');
            $this->Flash->adminSuccess($success_message, ['key' => 'admin_success']);
        } else {
            $error_message = __('The medicine could not be delete. Please, try again.');
            $this->Flash->adminError($error_message, ['key' => 'admin_error']);
        }
        return $this->redirect(['action' => 'index']);
    }

    public function bulkDelete(){
        $this->autoRender = false;

        $ids = array_filter( $this->request->data['ids'] );
        if(count( $ids ) > 0 ){
            $this->Medicines->deleteAll(['Medicines.id IN' => $ids ] );
            $this->Flash->adminSuccess(__('The Medicines has been deleted.'),  ['key' => 'admin_success']);
        }else{
            $this->Flash->adminError(__('No Medicines selected to delete!')  ,['key' => 'admin_error']);
        }
        return $this->redirect(['action' => 'index']);

    }


    function __search(){
        $session = $this->request->session();
        if($session->check('medicines_search_query')){
            $search = $session->read('medicines_search_query');
            $where = [
                'OR' => [
                    ['Medicines.name LIKE' => '%' . $search . '%']
                ]
            ];

        }else{
            $where = [];
        }
        return $where;
    }

    function reset(){
        $session = $this->request->session();
        $session->delete('medicines_search_query');
        $this->redirect(['action' => 'index']);
    }

    function isMedicineAvailable(){
        $this->autoRender = false;
        $medicine = $this->Medicines->findByName($this->request->data['name'])->toArray();
        if(empty($medicine)){
            echo 'true';die;
        }else{
            echo 'false';die;
        }

    }

    function importMedicine(){
        if( isset($this->request->data['medicine_file']) ){
            // start resume  up
            $import_medicine = $this->request->data['medicine_file'];

            if ($import_medicine) {
                $result = $this->FileHandler->uploadfile($import_medicine);
                //pr($import_medicine); die;
                if ($result) {
                    $import_medicine= $this->FileHandler->_uploadimgname;
                }else {
                    $import_medicine = '';
                }
            }else{
                $import_medicine = $this->request->data['medicine_file'];
            }

            $this->request->data['medicine_file'] = $import_medicine;
            // end resume up
        }
    }
}
