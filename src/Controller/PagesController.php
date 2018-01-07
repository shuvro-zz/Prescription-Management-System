<?php
namespace App\Controller;

use Cake\Core\Configure;
use Cake\Network\Exception\NotFoundException;
use Cake\View\Exception\MissingTemplateException;
use Cake\Auth\Auth;
use Cake\Event\Event;


class PagesController extends AppController
{

    public $components = ['Common'];

    public function beforeFilter(Event $event)
    {
        $this->Auth->allow([
            'home',
            'faq',
            'preliminary',
            'accommodation',
            'invited',
            'conferencePresentations',
            'presentationDownload',
            'presentationCode',
            'display'
        ]);
    }

    public function display(){
        $this->redirect('/admin');
    }

    


}
