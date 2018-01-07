<?php
namespace App\Controller\Admin;

use App\Controller\AppController;
use Cake\Event\Event;
use Cake\Utility\Security;
use Cake\Routing\Router;
use Cake\Mailer\Email;

// New Define
use Cake\Auth\DefaultPasswordHasher;
use Cake\Auth\Auth;
use Cake\ORM\TableRegistry;
use Cake\Utility\Text;

/**
 * Conferences Controller
 *
 * @property \App\Model\Table\ConferencesTable $Conferences */
class ConferencesController extends AppController
{
    public $components = ['EmailHandler','Common'];


    public function beforeFilter(Event $event)
    {
        parent::beforeFilter($event);
        $this->Auth->allow([]);
    }

    public function initialize()
    {
        parent::initialize();

    }

    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index()
    {
        if(isset($this->request->query['search']) and trim($this->request->query['search'])!='' ) {
            $search = $this->request->query['search'];
            $date = $this->Common->strToTime($search);

            $query = $this->Conferences->find('All')->where([
                'OR' => [
                    ['Conferences.name LIKE' => '%' . $search . '%'],
                    ['Conferences.slug LIKE' => '%' . $search . '%'],
                    ['Conferences.conference_date LIKE' => '%' . $date . '%'],
                    ['Conferences.start_time LIKE' => '%' . $search . '%'],
                    ['Conferences.end_time LIKE' => '%' . $search . '%'],
                    ['Venues.name LIKE' => '%' . $search . '%'],
                    ['Events.name LIKE' => '%' . $search . '%']
                ]
            ]);

        }else{
            $search = '';
            $query = $this->Conferences;
        }

        $this->paginate = [
            'contain' => ['Venues', 'Events'],
            'limit' => 25,
            'order' => [
                'Conferences.id' => 'desc'
            ]
        ];
        $conferences = $this->paginate($query);

        if(count($conferences)==0){
            $this->Flash->adminWarning(__('No conference found!')  ,['key' => 'admin_warning'], ['key' => 'admin_warning'] );
        }

        $this->set(compact('conferences', 'search'));
        $this->set('_serialize', ['conferences']);
    }

    /**
     * View method
     *
     * @param string|null $id Conference id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $conference = $this->Conferences->get($id, [
            'contain' => ['Venues', 'Events']
        ]);

        $this->set('conference', $conference);
        $this->set('_serialize', ['conference']);
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $conference = $this->Conferences->newEntity();
        if ($this->request->is('post')) {

            $this->Common->dateConvert();

            $conference = $this->Conferences->patchEntity($conference, $this->request->data);
            if ($this->Conferences->save($conference)) {
                $this->Flash->adminSuccess(__('The conference has been saved.') ,  ['key' => 'admin_success'] );
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->adminError(__('The conference could not be saved. Please, try again.') , ['key' => 'admin_error'] );
            }
        }
        $venues = $this->Conferences->Venues->find('list');
        $events = $this->Conferences->Events->find('list');
        $this->set(compact('conference', 'venues', 'events'));
        $this->set('_serialize', ['conference']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Conference id.
     * @return \Cake\Network\Response|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $conference = $this->Conferences->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {

            $this->Common->dateConvert();

            $conference = $this->Conferences->patchEntity($conference, $this->request->data);
            if ($this->Conferences->save($conference)) {
                $this->Flash->adminSuccess(__('The conference has been saved.') ,  ['key' => 'admin_success'] );
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->adminError(__('The conference could not be saved. Please, try again.') , ['key' => 'admin_error'] );
            }
        }
        $venues = $this->Conferences->Venues->find('list');
        $events = $this->Conferences->Events->find('list');
        $this->set(compact('conference', 'venues', 'events'));
        $this->set('_serialize', ['conference']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Conference id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $conference = $this->Conferences->get($id);
        if ($this->Conferences->delete($conference)) {
            $this->Flash->adminSuccess(__('The conference has been deleted.'));
        } else {
            $this->Flash->adminError(__('The conference could not be deleted. Please, try again.') , ['key' => 'admin_error'] );
        }
        return $this->redirect(['action' => 'index']);
    }

    public function bulkDelete(){
        $this->autoRender = false;
        $ids = array_filter( $this->request->data['ids'] );
        if(count( $ids ) > 0 ){
            $this->Conferences->deleteAll(['Conferences.id IN' => $ids ] );
            $this->Flash->adminSuccess(__('The conference has been deleted.'),  ['key' => 'admin_success']);
        }else{
            $this->Flash->adminError(__('No conference selected to delete!')  ,['key' => 'admin_error']);
        }
        return $this->redirect(['action' => 'index']);

    }
}
