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
 * Attendees Controller
 *
 * @property \App\Model\Table\AttendeesTable $Attendees */
class AttendeesController extends AppController
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

            $query = $this->Attendees->find('All')->where([
                'OR' => [
                    ['Attendees.first_name LIKE' => '%' . $search . '%'],
                    ['Attendees.surname LIKE' => '%' . $search . '%'],
                    ['Attendees.dob LIKE' => '%' . $search . '%'],
                    ['Attendees.mobile LIKE' => '%' . $search . '%'],
                    ['Attendees.telephone LIKE' => '%' . $search . '%'],
                    ['Attendees.address_line1 LIKE' => '%' . $search . '%'],
                    ['Attendees.address_line2 LIKE' => '%' . $search . '%'],
                    ['Attendees.email LIKE' => '%' . $search . '%'],
                    ['Attendees.post_code LIKE' => '%' . $search . '%'],
                    ['Attendees.city LIKE' => '%' . $search . '%'],
                    ['Attendees.state LIKE' => '%' . $search . '%'],
                    ['Countries.name LIKE' => '%' . $search . '%'],
                    ['AttendeeTypes.attendee_type LIKE' => '%' . $search . '%']
                ]
            ]);

        }else{
            $search = '';
            $query = $this->Attendees;
        }

        $this->paginate = [
            'contain' => ['Countries', 'AttendeeTypes'],
            'limit' => 25,
            'order' => [
                'Attendees.id' => 'desc'
            ]
        ];

        $attendees = $this->paginate($query);
        if(count($attendees)==0){
            $this->Flash->adminWarning(__('No attendee found!')  ,['key' => 'admin_warning'], ['key' => 'admin_warning'] );
        }

        $this->set(compact('attendees', 'search' ) );
        $this->set('_serialize', ['attendees']);
    }

    /**
     * View method
     *
     * @param string|null $id Attendee id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $attendee = $this->Attendees->get($id, [
            'contain' => ['Countries', 'AttendeeTypes']
        ]);

        $this->set('attendee', $attendee);
        $this->set('_serialize', ['attendee']);
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $attendee = $this->Attendees->newEntity();
        if ($this->request->is('post')) {
            $attendee = $this->Attendees->patchEntity($attendee, $this->request->data);
            if ($this->Attendees->save($attendee)) {
                $this->Flash->adminSuccess(__('The attendee has been saved.') ,  ['key' => 'admin_success'] );
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->adminError(__('The attendee could not be saved. Please, try again.') , ['key' => 'admin_error'] );
            }
        }
        
        $countries = $this->Attendees->Countries->find('list');
        $attendeeTypes = $this->Attendees->AttendeeTypes->find('list');
        $this->set(compact('attendee', 'countries', 'attendeeTypes'));
        $this->set('_serialize', ['attendee']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Attendee id.
     * @return \Cake\Network\Response|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $attendee = $this->Attendees->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $attendee = $this->Attendees->patchEntity($attendee, $this->request->data);
            if ($this->Attendees->save($attendee)) {
                $this->Flash->adminSuccess(__('The attendee has been saved.') ,  ['key' => 'admin_success'] );
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->adminError(__('The attendee could not be saved. Please, try again.') , ['key' => 'admin_error'] );
            }
        }
        $countries = $this->Attendees->Countries->find('list');
        $attendeeTypes = $this->Attendees->AttendeeTypes->find('list');
        $this->set(compact('attendee', 'countries', 'attendeeTypes'));
        $this->set('_serialize', ['attendee']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Attendee id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $attendee = $this->Attendees->get($id);
        if ($this->Attendees->delete($attendee)) {
            $this->Flash->adminSuccess(__('The attendee has been deleted.'));
        } else {
            $this->Flash->adminError(__('The attendee could not be deleted. Please, try again.') , ['key' => 'admin_error'] );
        }
        return $this->redirect(['action' => 'index']);
    }

    public function bulkDelete(){
    $this->autoRender = false;
    $ids = array_filter( $this->request->data['ids'] );
    if(count( $ids ) > 0 ){
        $this->Attendees->deleteAll(['Attendees.id IN' => $ids ] );
        $this->Flash->adminSuccess(__('The attendee has been deleted.'),  ['key' => 'admin_success']);
    }else{
        $this->Flash->adminError(__('No attendee selected to delete!')  ,['key' => 'admin_error']);
    }
    return $this->redirect(['action' => 'index']);

}
}
