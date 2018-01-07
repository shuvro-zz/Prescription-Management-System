<?php
namespace App\Controller\Admin;

use App\Controller\AppController;

/**
 * Venues Controller
 *
 * @property \App\Model\Table\VenuesTable $Venues */
class VenuesController extends AppController
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
            $query = $this->Venues->find('All')->where([
                'OR' => [
                    ['Venues.name LIKE' => '%' . $search . '%'],
                    ['Venues.slug LIKE' => '%' . $search . '%'],
                    ['Venues.post_code LIKE' => '%' . $search . '%'],
                    ['Venues.state LIKE' => '%' . $search . '%'],
                    ['Venues.city LIKE' => '%' . $search . '%'],
                    ['Countries.name LIKE' => '%' . $search . '%']
                ]
            ]);

        }else{
            $search = '';
            $query = $this->Venues;
        }

        $this->paginate = [
            'contain' => ['Countries'],
            'limit' => 25,
            'order' => [
                'Venues.id' => 'desc'
            ]
        ];
        $venues = $this->paginate($query);


        if(count($venues)==0){
            $this->Flash->adminWarning(__('No venue found!')  ,['key' => 'admin_warning'], ['key' => 'admin_warning'] );
        }

        $this->set(compact('venues', 'search' ));
        $this->set('_serialize', ['venues']);
    }

    /**
     * View method
     *
     * @param string|null $id Venue id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $venue = $this->Venues->get($id, [
            'contain' => ['Countries']
        ]);

        $this->set('venue', $venue);
        $this->set('_serialize', ['venue']);
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $venue = $this->Venues->newEntity();
        if ($this->request->is('post')) {
            $venue = $this->Venues->patchEntity($venue, $this->request->data);
            if ($this->Venues->save($venue)) {
                $this->Flash->adminSuccess(__('The venue has been saved.') ,  ['key' => 'admin_success'] );
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->adminError(__('The venue could not be saved. Please, try again.') , ['key' => 'admin_error']   );
            }
        }
        $countries = $this->Venues->Countries->find('list');
        $this->set(compact('venue', 'countries'));
        $this->set('_serialize', ['venue']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Venue id.
     * @return \Cake\Network\Response|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $venue = $this->Venues->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $venue = $this->Venues->patchEntity($venue, $this->request->data);
            if ($this->Venues->save($venue)) {
                $this->Flash->adminSuccess(__('The venue has been updated.') ,  ['key' => 'admin_success'] );
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->adminError(__('The venue could not be saved. Please, try again.') , ['key' => 'admin_error']  );
            }
        }
        $countries = $this->Venues->Countries->find('list');
        $this->set(compact('venue', 'countries'));
        $this->set('_serialize', ['venue']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Venue id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $venue = $this->Venues->get($id);
        if ($this->Venues->delete($venue)) {
            $this->Flash->adminSuccess(__('The venue has been deleted.'));
        } else {
            $this->Flash->adminError(__('The venue could not be deleted. Please, try again.') , ['key' => 'admin_error']  );
        }
        return $this->redirect(['action' => 'index']);
    }

    public function bulkDelete(){
        $this->autoRender = false;
        $ids = array_filter( $this->request->data['ids'] );
        if(count( $ids ) > 0 ){
            $this->Venues->deleteAll(['Venues.id IN' => $ids ] );
            $this->Flash->adminSuccess(__('The venue has been deleted.'),  ['key' => 'admin_success']);
        }else{
            $this->Flash->adminError(__('No venue selected to delete!')  ,['key' => 'admin_error']);
        }
        return $this->redirect(['action' => 'index']);
    }

}
