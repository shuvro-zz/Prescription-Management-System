<?php
namespace App\Controller;

use Cake\Controller\Controller;
use Cake\Event\Event;
use Cake\ORM\TableRegistry;

class AppController extends Controller
{

    public function initialize()
    {
        parent::initialize();

        $this->set('loadDashboardScript', false);

        $this->loadComponent('Flash');
        $this->loadComponent('Cookie');
        $this->loadComponent('Auth', [
            'authenticate' => [
                'Form' => [
                    'fields' => [
                        'username' => 'email',
                        'password' => 'password'
                    ]
                ]
            ],
            'loginAction' => [
                'controller' => 'Users',
                'action' => 'login'
            ]
        ]);
        
        //$this->Auth->allow(['display']);
    }

    public function isAuthorized($auth)       // Checking is admin or not
    {

        if(!empty($this->request->params['prefix']) && !empty($auth) ) {
            if ($this->request->params['prefix'] == 'admin' and ($this->Auth->user('role_id') == 2 or $this->Auth->user('role_id') == 1)) {
                return true;
            } else {
                $this->redirect('/');
            }
        }
        return true;

    }


    public function beforeFilter(Event $event)
    {
        parent::beforeFilter($event);
    }

    public function beforeRender(Event $event)
    {
        parent::beforeRender($event);
        $this->loadComponent('Auth');
        $auth = $this->Auth->user();
        $this->isAuthorized($auth);

        $this->set('loadjQueryUIScript',false);
        $this->set('loadEditorScript',false);
        $this->set('authUser', $auth);
        

        if (!array_key_exists('_serialize', $this->viewVars) && in_array($this->response->type(), ['application/json', 'application/xml'])) {
            $this->set('_serialize', true);
        }
        if(isset($this->request->params['prefix']) && $this->request->params['prefix']=='admin' && $this->request->params['action']!='login'){
            $this->viewBuilder()->layout('admin');
        }

        if($this->request->is('ajax')){
            $this->viewBuilder()->layout('ajax');
        }
        
        $this->set('version', '3.0');
        
    }
    
}
