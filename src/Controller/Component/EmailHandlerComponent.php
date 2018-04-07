<?php
namespace App\Controller\Component;

use  Cake\Controller\Component;
use Cake\Mailer\Email;

class EmailHandlerComponent extends Component
{
    public $components = ['Common'];

    public function smtpEmailSetting()
    {
        $smtp_username = 'fictionsoft50@gmail.com';
        $smtp_password = 'Fsakabaka002';

        Email::configTransport('gmail', [
            'host' => 'ssl://smtp.gmail.com',
            'port' => 465,
            'username' => $smtp_username,
            'password' => $smtp_password,
            'className' => 'Smtp'
        ]);
    }

    public function sendEmail($info){

        $this->smtpEmailSetting();

        $site_email = $this->Common->getSettingByKey('site_email');
        $site_name = $this->Common->getSettingByKey('site_name');
        $email = new Email('default');
        $email->from([$site_email => $site_name]);
        $email->to($info['to']);
        $email->subject($info['subject']);
        $email->template($info['template']);
        $email->emailFormat('html');
        $email->transport('gmail');//gmail for smtp,,,,,NULL for main mail server
        //$email->send($info['body']);
        $email->viewVars(['data' => $info['data'] ]);

        if(isset($info['attach'])) $email->attachments(array($info['attach']['file_name'] => $info['attach']['file_path']));

        $email->send();

    }
}