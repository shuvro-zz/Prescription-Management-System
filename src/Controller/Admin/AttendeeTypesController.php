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
 * AttendeeTypes Controller
 *
 * @property \App\Model\Table\AttendeeTypesTable $AttendeeTypes */
class AttendeeTypesController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index()
    {
        if(isset($this->request->query['search']) and trim($this->request->query['search'])!='' ) {
            $search = $this->request->query['search'];

            $query = $this->AttendeeTypes->find('All')->where([
                'OR' => [
                    ['AttendeeTypes.attendee_type LIKE' => '%' . $search . '%']
                ]
            ]);

        }else{
            $search = '';
            $query = $this->AttendeeTypes;
        }

        $this->paginate = [
            'limit' => 25,
            'order' => [
                'AttendeeTypes.id' => 'desc'
            ]
        ];
        
        $attendeeTypes = $this->paginate($query);

        if(count($attendeeTypes)==0){
            $this->Flash->adminWarning(__('No attendee type found!')  ,['key' => 'admin_warning'], ['key' => 'admin_warning'] );
        }


        $this->set(compact('attendeeTypes', 'search') );
        $this->set('_serialize', ['attendeeTypes']);
    }

    /**
     * View method
     *
     * @param string|null $id Attendee Type id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $attendeeType = $this->AttendeeTypes->get($id, [
            'contain' => ['Attendees']
        ]);

        $this->set('attendeeType', $attendeeType);
        $this->set('_serialize', ['attendeeType']);
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $attendeeType = $this->AttendeeTypes->newEntity();
        if ($this->request->is('post')) {
            $attendeeType = $this->AttendeeTypes->patchEntity($attendeeType, $this->request->data);
            if ($this->AttendeeTypes->save($attendeeType)) {
                $this->Flash->adminSuccess(__('The attendee type has been saved.') ,  ['key' => 'admin_success'] );
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->adminError(__('The attendee type could not be saved. Please, try again.') , ['key' => 'admin_error'] );
            }
        }
        $this->set(compact('attendeeType'));
        $this->set('_serialize', ['attendeeType']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Attendee Type id.
     * @return \Cake\Network\Response|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $attendeeType = $this->AttendeeTypes->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $attendeeType = $this->AttendeeTypes->patchEntity($attendeeType, $this->request->data);
            if ($this->AttendeeTypes->save($attendeeType)) {
                $this->Flash->adminSuccess(__('The attendee type has been saved.') ,  ['key' => 'admin_success'] );
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->adminError(__('The attendee type could not be saved. Please, try again.') , ['key' => 'admin_error'] );
            }
        }
        $this->set(compact('attendeeType'));
        $this->set('_serialize', ['attendeeType']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Attendee Type id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $attendeeType = $this->AttendeeTypes->get($id);
        if ($this->AttendeeTypes->delete($attendeeType)) {
            $this->Flash->adminSuccess(__('The attendee type has been deleted.'));
        } else {
            $this->Flash->adminError(__('The attendee type could not be deleted. Please, try again.') , ['key' => 'admin_error'] );
        }
        return $this->redirect(['action' => 'index']);
    }

    public function bulkDelete(){
        $this->autoRender = false;
        $ids = array_filter( $this->request->data['ids'] );
        if(count( $ids ) > 0 ){
            $this->AttendeeTypes->deleteAll(['AttendeeTypes.id IN' => $ids ] );
            $this->Flash->adminSuccess(__('The attendee type has been deleted.'),  ['key' => 'admin_success']);
        }else{
            $this->Flash->adminError(__('No attendee type selected to delete!')  ,['key' => 'admin_error']);
        }
        return $this->redirect(['action' => 'index']);

    }
}
