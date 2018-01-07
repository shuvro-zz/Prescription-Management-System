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

            /*$smtp_username = 'car.webalive@gmail.com';
            $smtp_password = 'mascot123';*/

            $smtp_username = 'leanhealthatstanford@gmail.com';
            $smtp_password = 'stanford@123';

        }

        Email::configTransport('gmail', [
            'host' => 'ssl://smtp.gmail.com',
            'port' => 465,
            'username' => $smtp_username,
            'password' => $smtp_password,
            'className' => 'Smtp'
        ]);
    }
}