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
        $diagnosis = $this->paginate($this->Diagnosis);

        $this->set(compact('diagnosis'));
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
            if ($this->Diagnosis->save($diagnosi)) {
                $this->Flash->adminSuccess(__('The diagnosi has been saved.',  ['key' => 'admin_success'] ));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->adminError(__('The diagnosi could not be saved. Please, try again.', ['key' => 'admin_error']));
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
                $this->Flash->adminSuccess(__('The diagnosi has been saved.', ['key' => 'admin_success']));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->adminError(__('The diagnosi could not be saved. Please, try again.', ['key' => 'admin_error']));
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
            $this->Flash->admin_success(__('The diagnosi has been deleted.', ['key' => 'admin_success'] ));
        } else {
            $this->Flash->admin_error(__('The diagnosi could not be deleted. Please, try again.' , ['key' => 'admin_error']));
        }
        return $this->redirect(['action' => 'index']);
    }
}
