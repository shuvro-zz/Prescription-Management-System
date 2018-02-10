<?php
namespace App\Controller\Component;

use  Cake\Controller\Component;
use Cake\Mailer\Email;

class EmailHandlerComponent extends Component
{
    public $components = ['Common'];

    public function smtpEmailSetting()
    {
        $smtp_username = $this->Common->getSettingByKey('smtp_username');
        $smtp_password = $this->Common->getSettingByKey('smtp_password');

        if(empty($smtp_username) || empty($smtp_password)){

            $smtp_username = 'mizan92cse@gmail.com';
            $smtp_password = 'Password0022';


            /*$smtp_username = 'car.webalive@gmail.com';
            $smtp_password = 'mascot123';*/

            /*$smtp_username = 'leanhealthatstanford@gmail.com';
            $smtp_password = 'stanford@123';*/

        }

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