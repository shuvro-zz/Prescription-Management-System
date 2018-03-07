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


class SettingsController extends AppController
{
    public function beforeFilter(Event $event)
    {
        parent::beforeFilter($event);
        $this->set('loadDashboardScript', false);
        $this->set('loadEditorScript', true);
    }

    public function index()
    {
        return $this->redirect(['action' => 'add']);
    }

    public function view($id = null)
    {
        return $this->redirect(['action' => 'add']);
    }

    public function add()
    {

        if ($this->request->is(['patch', 'post', 'put'])) {
            $post_data = $this->request->data;
            //debug($post_data);exit;

            foreach($post_data as $key=>$val){

                $query = $this->Settings->query();
                $query->update()
                    ->set(['value' => $val])
                    ->where(['key_name' => $key])
                    ->execute();
            }

            $this->Flash->adminSuccess('The setting has been saved.', [ 'key' => 'admin_success' ]);
            return $this->redirect(['action' => 'add']);
        }

        $setting = $this->Settings->find('all');
        $this->set(compact('setting'));
        $this->set('_serialize', ['setting']);
    }

    public function edit($id = null)
    {
        return $this->redirect(['action' => 'add']);
    }
}
