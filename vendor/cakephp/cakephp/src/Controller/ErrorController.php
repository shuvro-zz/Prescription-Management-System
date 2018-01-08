<?php
/**
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @since         2.0.0
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */
namespace Cake\Controller;

use Cake\Event\Event;
use Cake\Routing\Router;
use App\Controller\AppController;

use Cake\ORM\TableRegistry;

/**
 * Error Handling Controller
 *
 * Controller used by ErrorHandler to render error views.
 */
class ErrorController extends AppController
{

    /**
     * Constructor
     *
     * @param \Cake\Network\Request|null $request Request instance.
     * @param \Cake\Network\Response|null $response Response instance.
     */
    public function __construct($request = null, $response = null)
    {
        parent::__construct($request, $response);
        if (count(Router::extensions()) &&
            !isset($this->RequestHandler)
        ) {
            $this->loadComponent('RequestHandler');
        }
        $eventManager = $this->eventManager();
        if (isset($this->Auth)) {
            $eventManager->off($this->Auth);
        }
        if (isset($this->Security)) {
            $eventManager->off($this->Security);
        }
    }

    /**
     * beforeRender callback.
     *
     * @param \Cake\Event\Event $event Event.
     * @return void
     */
    //public function beforeRender(Event $event)
    //{
    //    $this->viewBuilder()->templatePath('Error');
    //}

    public function getMenu()
    {
        $categoryTypesTable = TableRegistry::get('CategoryTypes');
        $category_types = $categoryTypesTable->find('all')->contain(['Categories'])->toArray();
        return $category_types;

    }

    public function beforeRender(Event $event)
    {
        $this->viewBuilder()->templatePath('Error');

        $this->isAuthorized();

        $category_types = $this->getMenu();

        $this->set('loadjQueryUIScript',false);
        $this->set('loadEditorScript',false);
        $this->set('authUser', $this->Auth->user());
        $this->set('category_type',$category_types);

        if(!empty($this->Auth->user())){
            $this->set('loggedin', 'yes');
        } else {
            $this->set('loggedin', 'no');
        }

        $session = $this->request->session();
        $order_session = $session->read('Order');
        if(!empty($order_session['EcommerOrder']['cart_qty'])){
            $cart_qty = $order_session['EcommerOrder']['cart_qty'];
            $this->set('cart_qty', $cart_qty);
            $this->set('cart', $order_session);
        } else {
            $this->set('cart_qty', 0);
            $this->set('cart', 0);
        }

        if (!array_key_exists('_serialize', $this->viewVars) && in_array($this->response->type(), ['application/json', 'application/xml'])) {
            $this->set('_serialize', true);
        }
        if(isset($this->request->params['prefix']) && $this->request->params['prefix']=='admin' && $this->request->params['action']!='login'){
            $this->viewBuilder()->layout('admin');
        }

        if($this->request->is('ajax')){
            $this->viewBuilder()->layout('ajax');
        }
    }
}
