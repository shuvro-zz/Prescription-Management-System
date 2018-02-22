<?php
namespace App\Controller\Admin;

use App\Controller\AppController;

/**
 * Tests Controller
 *
 * @property \App\Model\Table\TestsTable $Tests */
class TestsController extends AppController
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
            $session->write('tests_search_query', $this->request->query['search']);
        }
        if($session->check('tests_search_query')) {
            $search = $session->read('tests_search_query');
        }else{
            $search = '';
        }

        $where = $this->__search();

        if($where){
            $query = $this->Tests->find('All')->where($where);
        }else{
            $query = $this->Tests;
        }

        $this->paginate = [
            'limit' => 30,
            'order' => [
                'Tests.id' => 'desc'
            ]
        ];
        $tests = $this->paginate($query);

        if(count($tests)==0){
            $this->Flash->adminWarning(__('No tests found!')  ,['key' => 'admin_warning'], ['key' => 'admin_warning'] );
        }

        $this->set(compact('tests', 'search'));
        $this->set('_serialize', ['tests']);
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
        $test = $this->Tests->get($id, [
            'contain' => []
        ]);

        $this->set('test', $test);
        $this->set('_serialize', ['test']);
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $test = $this->Tests->newEntity();
        if ($this->request->is('post')) {
            $test = $this->Tests->patchEntity($test, $this->request->data);
            if ($this->Tests->save($test)) {
                $success_message = __('The test has been saved.');
                $this->Flash->adminSuccess($success_message, ['key' => 'admin_success']);
            } else {
                $error_message = __('The test could not be save. Please, try again.');
                $this->Flash->adminError($error_message, ['key' => 'admin_error']);
            }
            return $this->redirect(['action' => 'index']);
        }
        $this->set(compact('test'));
        $this->set('_serialize', ['test']);
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
        $test = $this->Tests->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $test = $this->Tests->patchEntity($test, $this->request->data);
            if ($this->Tests->save($test)) {
                $success_message = __('The test has been edited.');
                $this->Flash->adminSuccess($success_message, ['key' => 'admin_success']);
            } else {
                $error_message = __('The test could not be edit. Please, try again.');
                $this->Flash->adminError($error_message, ['key' => 'admin_error']);
            }
            return $this->redirect(['action' => 'index']);
        }
        $this->set(compact('test'));
        $this->set('_serialize', ['test']);
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
        $test = $this->Tests->get($id);
        if ($this->Tests->delete($test)) {
            $success_message = __('The test has been deleted.');
            $this->Flash->adminSuccess($success_message, ['key' => 'admin_success']);
        } else {
            $error_message = __('The test could not be delete. Please, try again.');
            $this->Flash->adminError($error_message, ['key' => 'admin_error']);
        }
        return $this->redirect(['action' => 'index']);
    }

    function __search(){
        $session = $this->request->session();
        if($session->check('tests_search_query')){
            $search = $session->read('tests_search_query');
            $where = [
                'OR' => [
                    ['Tests.name LIKE' => '%' . $search . '%']
                ]
            ];
        }else{
            $where = [];
        }
        return $where;
    }

    function reset(){
        $session = $this->request->session();
        $session->delete('tests_search_query');
        $this->redirect(['action' => 'index']);
    }

    function isTestAvailable(){
        $this->autoRender = false;
        $test = $this->Tests->findByName($this->request->data['name']);
        if(empty($test->toArray())){
            echo 'true';die;
        }else{
            echo 'false';die;
        }

    }

}
