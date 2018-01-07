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


class UsersController extends AppController
{
    public $components = ['EmailHandler','Common'];

    public $paginate = [
        'limit' => 20
    ];

    public function beforeFilter(Event $event)
    {
        parent::beforeFilter($event);
        $this->Auth->allow([
            'logout',
            'login',
            'forgotPassword',
            'changePassword'
        ]);
    }

    public function initialize()
    {
        parent::initialize();
        //$this->loadComponent('Common');
    }

    public function index()
    {
        $query = $this->_getData();
        $this->set('users', $this->paginate($query));
        $this->set('_serialize', ['users']);
    }

    public function _getData()
    {
        if (!empty($this->request->data['search'])) {
            $search = $this->request->data['search'];
            $query = $this->Users->find('All')->where([
                'OR' => [
                    ['first_name LIKE' => '%' . $search . '%'],
                    ['last_name LIKE' => '%' . $search . '%'],
                    ['email LIKE' => '%' . $search . '%'],
                    ['phone LIKE' => '%' . $search . '%'],
                    ['company LIKE' => '%' . $search . '%']
                ],
            ]);
        } else{
            $query = $this->Users->find('All');
        }

        return $query;
    }

    public function view($id = null)
    {
        $user = $this->Users->get($id, [
            'contain' => ['Articles']
        ]);
        $this->set('user', $user);
        $this->set('_serialize', ['user']);
    }

    public function add()
    {

        $user = $this->Users->newEntity();
        if ($this->request->is('post')) {
            $user = $this->Users->patchEntity($user, $this->request->data);
            $user->role_id = '2';
            if ($this->Users->save($user)) {
                $success_message = __('The user Registration is successful.');
                $this->Flash->adminSuccess($success_message, ['key' => 'admin_success']);
                return $this->redirect(['action' => 'login']);
            } else {
                $error_message = __('The user could not be saved. Please, try again.');
                $this->Flash->adminError($error_message, ['key' => 'admin_error']);
            }
        }
        $this->set(compact('user'));
        $this->set('_serialize', ['user']);
    }

    public function edit($id = null)
    {
        $user = $this->Users->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $user = $this->Users->patchEntity($user, $this->request->data);
            if ($this->Users->save($user)) {
                $success_message = __('The user has been saved.');
                $this->Flash->adminSuccess($success_message, ['key' => 'admin_success']);
                return $this->redirect(['action' => 'index']);
            } else {
                $error_message = __('The user could not be saved. Please, try again.');
                $this->Flash->adminError($error_message, ['key' => 'admin_error']);
            }
        }
        $this->set(compact('user'));
        $this->set('_serialize', ['user']);
    }

    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $user = $this->Users->get($id);
        if ($this->Users->delete($user)) {
            $success_message = __('The user has been deleted.');
            $this->Flash->adminSuccess($success_message, ['key' => 'admin_success']);

        } else {
            $error_message = __('The user could not be deleted. Please, try again.');
            $this->Flash->adminError($error_message, ['key' => 'admin_error']);
        }
        return $this->redirect(['action' => 'index']);
    }

    public function login()      // Backend login
    {
        //echo json_encode(array(1));die;
        //$hasher = new DefaultPasswordHasher();
        //echo $hasher->hash(123456);die;
        
        $this->viewBuilder()->layout('loginLayout');
        if (!$this->Auth->user()) {

            if ($this->request->is('post')) {


                $role_check = $this->userRoleCheck($this->request->data);   // Checking user is admin or not
                if($role_check == true){
                    $user = $this->Auth->identify();

                    if ($user) {
                        $this->Auth->setUser($user);
                        $success_message = __('Successfully logged in');
                        $this->Flash->adminSuccess($success_message, ['key' => 'admin_success']);
                        return $this->redirect('/admin/dashboard');
                    }
                } else {
                    $error_message = __('You don\'t have permission to login');
                    $this->Flash->adminError($error_message, ['key' => 'admin_error']);
                    return $this->redirect(['controller' => 'dashboard', 'action' => 'index']);
                }

                $error_message = __('Invalid username or password, try again');
                $this->Flash->adminError($error_message, ['key' => 'admin_error']);
                $this->Flash->error($error_message);

            }

        } else {

            return $this->redirect(['controller' => 'dashboard', 'action' => 'index']);
        }
    }

    function userRoleCheck($user_data) {     // Checking user is admin or not
        if(!empty($user_data['email'])){
            $user_email = $user_data['email'];
            $userTable = TableRegistry::get('Users');
            $query = $userTable->find('all')->where(['email' => $user_email]);
            if(!empty($query->first()->role_id) && $query->first()->role_id == 1){
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    public function logout()  // Backend logout
    {
        return $this->redirect($this->Auth->logout());
    }

    function resetPassword($user_id=null) {  // Admin reset password

        if ($this->request->is('post')) {

            if($this->request->data['password'] == $this->request->data['confirm_password']){

                $user_id = $this->request->data['user_id'];
                $userTable = TableRegistry::get('Users');
                $user_data = $userTable->get($user_id);
                $user_data->id = $user_id;
                $user_data->password = $this->request->data['password'];

                if ($userTable->save($user_data)) {
                    $this->Flash->adminSuccess('Password changed successfully', ['key' => 'admin_success']);
                    $this->redirect(array('controller' => 'users', 'action' => 'index'));
                }

            } else {
                $this->Flash->adminError('Password and Confirm Password does not match', ['key' => 'admin_error']);
                $this->redirect(array('controller' => 'users', 'action' => 'resetPassword'));
            }
        }

        $this->set('user_id',$user_id);
    }

    function forgotPassword() {

        $this->viewBuilder()->layout('loginLayout');

        if ($this->request->is('post')) {

            $post_data = $this->request->data();

            if(!empty($post_data['email'])){

                $email = $post_data['email'];
                $user_info = $this->Users->find()->where(['Users.email'=>$email])->first();

                if(!empty($user_info)){

                    $user_info['token'] = $this->generateToken();
                    $user_info['token_generated'] = date("Y-m-d H:i:s");

                    if ($this->Users->save($user_info)) {

                        $this->adminPasswordChangeLinkEmailSend($user_info);

                        $this->Flash->adminSuccess('A reset password link has sent to your email address', ['key' => 'admin_success']);
                        //$this->redirect(array('controller' => 'users', 'action' => 'forgotPassword'));
                    }

                } else {
                    //echo 'fsef';exit;
                    $this->Flash->adminError('Email does not exist', ['key' => 'admin_error']);
                    //$this->redirect(array('controller' => 'users', 'action' => 'forgotPassword'));
                }


            } else{


                $error_message = __('Invalid username or password, try again');
                $this->Flash->adminError($error_message, ['key' => 'admin_error']);
                //$this->redirect(array('controller' => 'users', 'action' => 'forgotPassword'));

            }


        }

        $this->render('forgot_password');

    }

    public function adminPasswordChangeLinkEmailSend($user){

        $this->EmailHandler->smtpEmailSetting();

        $site_email = $this->Common->getSettingByKey('site_email');
        $site_name = $this->Common->getSettingByKey('site_name');
        $to = $user['email'];
        $subject = 'Password Reset Link';
        $name = $user['first_name'].' '.$user['last_name'];
        $site_link = Router::url( '/', true ).'admin/users/change_password/'.$user['token'];
        $body = 'Hi '.$name.' Please go to this link to change your password '.$site_link;

        $email = new Email('default');
        $email->from([$site_email => $site_name])
            ->to($to)
            ->subject($subject)
            ->transport('gmail')
            ->send($body);
    }

    public function changePassword($token = null){

        $this->viewBuilder()->layout('loginLayout');


        //debug($user_info->toArray());exit;

            if( $this->request->is('post') ) {

                $token = $this->request->data['token'];
                $user_info = $this->Users->find()->where(['Users.token'=>$token])->first();

                if(!empty($user_info)){
                    if( strlen( $this->request->data['password'] )>7 ) {
                        if( $this->request->data['password'] == $this->request->data['confirm_password'] ) {

                            $user_info['password'] = $this->request->data['password'];
                            $user_info['confirm_password'] = $this->request->data['confirm_password'];

                            if( $this->Users->save($user_info) ) {
                                $this->Flash->adminSuccess('Password has been reset successfully, You may login now', ['key' => 'admin_success']);
                                //$this->redirect(array('controller' => 'users', 'action' => 'login'));

                            }else{
                                $message = 'Password could not be reset!, Please try again';
                                $this->Flash->adminError($message, ['key' => 'admin_error']);

                            }

                        }else{
                            $message = 'Password didn\'t match with confirm password!';
                            $this->Flash->adminError($message, ['key' => 'admin_error']);

                        }

                    }else{
                        $message = 'Password must have a mimimum of 8 characters!';
                        $this->Flash->adminError($message, ['key' => 'admin_error']);

                    }
                } else {
                    $message = 'User does not exist';
                    $this->Flash->adminError($message, ['key' => 'admin_error']);
                }



            }

        $this->set('token',$token);

        $this->render('change_password');

    }

    public function generateToken(){
        return Text::uuid();
    }

}
