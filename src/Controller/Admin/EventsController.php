<?php
namespace App\Controller\Admin;

use App\Controller\AppController;
use Cake\Event\Event;
use Cake\Utility\Security;
use Cake\Utility\Inflector;
use Cake\Routing\Router;
use Cake\Mailer\Email;

// New Define
use Cake\Auth\DefaultPasswordHasher;
use Cake\Auth\Auth;
use Cake\ORM\TableRegistry;
use Cake\Utility\Text;

/**
 * Events Controller
 *
 * @property \App\Model\Table\EventsTable $Events */
class EventsController extends AppController
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

            $date_query = '';
            if(trim($date)!=''){
                $date_query = " OR Events.start_date LIKE '%$date%' OR Events.end_date LIKE '%$date%'";
            }

            $query = $this->Events->find('All')->where(" Events.name LIKE '%$search%' OR Events.slug LIKE '%$search%' $date_query ");


        }else{
            $search = '';
            $query = $this->Events;
        }

        $this->paginate = [
            'limit' => 25,
            'order' => [
                'Events.id' => 'desc'
            ]
        ];

        $events = $this->paginate($query);

        if(count($events)==0){
            $this->Flash->adminWarning(__('No event found!')  ,['key' => 'admin_warning'], ['key' => 'admin_warning'] );
        }
        
        $this->set(compact('events', 'search'));
        $this->set('_serialize', ['events']);
    }

    /**
     * View method
     *
     * @param string|null $id Event id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $event = $this->Events->get($id, [
            'contain' => []
        ]);

        $this->set('event', $event);
        $this->set('_serialize', ['event']);
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $event = $this->Events->newEntity();
        if ($this->request->is('post')) {

            $this->Common->dateConvert();

            $event = $this->Events->patchEntity($event, $this->request->data);

            if ($this->Events->save($event)) {
                $this->Flash->adminSuccess(__('The event has been saved.') ,  ['key' => 'admin_success'] );
                return $this->redirect(['action' => 'index']);
                
            } else {
                $this->Flash->adminError(__('The event could not be saved. Please, try again.')  ,['key' => 'admin_error'] );
            }
        }
        $this->set(compact('event'));
        $this->set('_serialize', ['event']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Event id.
     * @return \Cake\Network\Response|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $event = $this->Events->get($id, [
            'contain' => []
        ]);

        if ($this->request->is(['patch', 'post', 'put'])) {

            $this->Common->dateConvert();

            $event = $this->Events->patchEntity($event, $this->request->data);
            if ($this->Events->save($event)) {
                $this->Flash->adminSuccess(__('The event has been updated.'),  ['key' => 'admin_success'] );
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->adminError(__('The event could not be updated. Please, try again.')  ,['key' => 'admin_error']);
            }
        }
        $this->set(compact('event'));
        $this->set('_serialize', ['event']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Event id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $event = $this->Events->get($id);
        if ($this->Events->delete($event)) {
            $this->Flash->adminSuccess(__('The event has been deleted.'),  ['key' => 'admin_success']);
        } else {
            $this->Flash->adminError(__('The event could not be deleted. Please, try again.')  ,['key' => 'admin_error']);
        }
        return $this->redirect(['action' => 'index']);
    }
    
    public function bulkDelete(){
        $this->autoRender = false;
        
        $ids = array_filter( $this->request->data['ids'] );
        if(count( $ids ) > 0 ){
            $this->Events->deleteAll(['Events.id IN' => $ids ] );
            $this->Flash->adminSuccess(__('The event has been deleted.'),  ['key' => 'admin_success']);
        }else{
            $this->Flash->adminError(__('No event selected to delete!')  ,['key' => 'admin_error']);
        }
        return $this->redirect(['action' => 'index']);

    }
}
