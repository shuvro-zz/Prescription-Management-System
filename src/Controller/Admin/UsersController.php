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
            'login',
            'forgotPassword',
            'resetPassword',
            'registration'
        ]);
    }

    public function initialize()
    {
        parent::initialize();
        //$this->loadComponent('Common');
    }

    public function index()
    {

        $session = $this->request->session();

        if(isset($this->request->query['search']) and trim($this->request->query['search'])!='' ) {
            $session->write('users_search_query', $this->request->query['search']);
        }
        if($session->check('users_search_query')) {
            $search = $session->read('users_search_query');
        }else{
            $search = '';
        }

        $where = $this->__search();

        if($where){
            $query = $this->Users->find('All')->where($where);
        }else{
            $query = $this->Users;
        }

        $this->paginate = [
            'limit' => 30,
            'order' => [
                'Users.id' => 'desc'
            ]
        ];
        $users = $this->paginate($query);

        if(count($users)==0){
            $this->Flash->adminWarning(__('No patient found!')  ,['key' => 'admin_warning'], ['key' => 'admin_warning'] );
        }

        $this->set(compact('users', 'search'));
        $this->set('_serialize', ['users']);
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

            $session = $this->request->session();
            $doctor_id = $session->read('Auth.User.id');

            $user->role_id = 3;
            $user->doctor_id = $doctor_id;

            //pr($user); die;

            if ($this->Users->save($user)) {
                $success_message = __('The patient Registration is successful.');
                $this->Flash->adminSuccess($success_message, ['key' => 'admin_success']);
            } else {
                $error_message = __('The patient could not be Registration. Please, try again.');
                $this->Flash->adminError($error_message, ['key' => 'admin_error']);
            }
            return $this->redirect(['action' => 'index']);
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
                $success_message = __('The patient has been edited.');
                $this->Flash->adminSuccess($success_message, ['key' => 'admin_success']);
            } else {
                $error_message = __('The patient could not be edit. Please, try again.');
                $this->Flash->adminError($error_message, ['key' => 'admin_error']);
            }
            return $this->redirect(['action' => 'index']);
        }

        $this->set(compact('user', 'id'));
        $this->set('_serialize', ['user']);
    }

    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $user = $this->Users->get($id);
        if ($this->Users->delete($user)) {
            $success_message = __('The patient has been deleted.');
            $this->Flash->adminSuccess($success_message, ['key' => 'admin_success']);
        } else {
            $error_message = __('The patient could not be delete. Please, try again.');
            $this->Flash->adminError($error_message, ['key' => 'admin_error']);
        }
        return $this->redirect(['action' => 'index']);
    }

    public function registration(){
        $this->viewBuilder()->layout('loginLayout');

        $user = $this->Users->newEntity();
        if ($this->request->is('post')) {
            $user = $this->Users->patchEntity($user, $this->request->data);
            $user->role_id = 2;
            $user->token = $this->generateToken();

            //pr($user); die;

            if ($this->Users->save($user)) {
                $success_message = __('Registration is successful.');
                $this->Flash->adminSuccess($success_message, ['key' => 'admin_success']);
                $this->login();
                //return $this->redirect(['action' => 'index']);
            } else {
                $error_message = __('The user could not be saved. Please, try again.');
                $this->Flash->adminError($error_message, ['key' => 'admin_error']);
            }
        }
        $this->set(compact('user'));
        $this->set('_serialize', ['user']);

    }


    public function login()      // Backend login
    {
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

                    }else{
                        $error_message = __('Invalid username or password, try again');
                        $this->Flash->adminError($error_message, ['key' => 'admin_error']);
                        $this->Flash->error($error_message);
                    }

                } else {
                    $error_message = __('You don\'t have permission to access');
                    $this->Flash->adminError($error_message, ['key' => 'admin_error']);
                    return $this->redirect(['action' => 'login']);
                }
            }

        } else {
            return $this->redirect(['controller' => 'dashboard', 'action' => 'index']);
        }
    }


    public function myProfile( $id = null){
        $user = $this->Users->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $user = $this->Users->patchEntity($user, $this->request->data);
            if ($this->Users->save($user)) {
                $success_message = __('Profile has been saved.');
                $this->Flash->adminSuccess($success_message, ['key' => 'admin_success']);

                $session = $this->request->session();
                $session->write('Auth.User.first_name', $this->request->data['first_name']);
                $session->write('Auth.User.last_name', $this->request->data['last_name']);
                $session->write('Auth.User.address_line1', $this->request->data['address_line1']);
                $session->write('Auth.User.address_line2', $this->request->data['address_line2']);
                $session->write('Auth.User.phone', $this->request->data['phone']);
                $session->write('Auth.User.educational_qualification', $this->request->data['educational_qualification']);
                $session->write('Auth.User.clinic_name', $this->request->data['clinic_name']);
                $session->write('Auth.User.website', $this->request->data['website']);
                $session->write('Auth.User.logo', $this->request->data['logo']);
                $session->write('Auth.User.signature', $this->request->data['signature']);

                //$this->redirect(array('controller' => 'users', 'action' => 'myProfile'));

            } else {
                $error_message = __('Profile could not be changed. Please, try again.');
                $this->Flash->adminError($error_message, ['key' => 'admin_error']);
            }
            return $this->redirect(['action' => 'myProfile/'.$id]);
        }
        $this->set(compact('user'));
        $this->set('_serialize', ['user']);
    }

    function userRoleCheck($user_data) {     // Checking user is admin or not
        if(!empty($user_data['email'])){
            $user_email = $user_data['email'];
            $userTable = TableRegistry::get('Users');
            $query = $userTable->find('all')->where(['email' => $user_email]);

            if(!empty($query->first()->role_id) && $query->first()->role_id == 2){  // Doctor
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

    function resetPassword($token = null) {  //  Reset password
        $this->viewBuilder()->layout('loginLayout');

        if ($this->request->is('post')) {

            if($this->request->data['password'] == $this->request->data['confirm_password']){

                $token = $this->request->data['token'];
                if($token != NULL){
                    $userTable = TableRegistry::get('Users');

                    $user_data = $userTable->find('all')
                        ->where(['Users.token' => $token]);

                    $user_data = $user_data->first();

                    $user_data->token = $token;
                    $user_data->password = $this->request->data['password'];

                    if ($userTable->save($user_data)) {
                        $this->Flash->adminSuccess('Password reset successful', ['key' => 'admin_success']);
                        $this->redirect(array('controller' => 'users', 'action' => 'index'));
                    }else{
                        $message = 'Password could not be reset!, Please try again';
                        $this->Flash->adminError($message, ['key' => 'admin_error']);
                    }
                }else{
                    $this->redirect(array('controller' => 'users', 'action' => 'login'));
                }
            } else {
                $this->Flash->adminError('Password and Confirm Password does not match', ['key' => 'admin_error']);
                $this->redirect(array('controller' => 'users', 'action' => 'resetPassword'));
            }
        }
        $this->set('token',$token);
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
                        $site_link = Router::url( '/', true );

                        $info = array(
                            'to'                => $user_info['email'],
                            'subject'           => 'Password Reset Link',
                            'template'          => 'reset_password_link',
                            'data'              => array('User' => $user_info, 'base_url' => $site_link),
                        );
                        $this->EmailHandler->sendEmail($info);

                        $this->Flash->adminSuccess('A reset password link has been sent to your email address', ['key' => 'admin_success']);
                    }
                } else {
                    $this->Flash->adminError('Email does not exist', ['key' => 'admin_error']);

                }
            } else{
                $error_message = __('Invalid username or password, try again');
                $this->Flash->adminError($error_message, ['key' => 'admin_error']);
            }
        }
    }

    public function changePassword($token = null){
            if( $this->request->is('post') ) {

                $token = $this->request->data['token'];
                $user_info = $this->Users->find()->where(['Users.token'=>$token])->first();

                if(!empty($user_info)){
                    if( strlen( $this->request->data['password'] )>7 ) {
                        if( $this->request->data['password'] == $this->request->data['confirm_password'] ) {

                            $user_info['password'] = $this->request->data['password'];
                            $user_info['confirm_password'] = $this->request->data['confirm_password'];

                            if( $this->Users->save($user_info) ) {
                                $this->Flash->adminSuccess('Password has been changed successfully', ['key' => 'admin_success']);
                                $this->redirect(['action' => 'changePassword/'.$token]);
                            }else{
                                $message = 'Password could not be change!, Please try again';
                                $this->Flash->adminError($message, ['key' => 'admin_error']);
                            }
                        }else{
                            $message = 'Password didn\'t match with confirm password!';
                            $this->Flash->adminError($message, ['key' => 'admin_error']);

                        }
                    }else{
                        $message = 'Password must have a minimum of 8 characters!';
                        $this->Flash->adminError($message, ['key' => 'admin_error']);
                    }
                }else {
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

    function __search(){

        $session = $this->request->session();
        $doctor_id = $session->read('Auth.User.id');

        if($session->check('users_search_query')){
            $search = $session->read('users_search_query');
            $where = [ 'Users.doctor_id' => $doctor_id,
                'OR' => [
                    ['Users.first_name LIKE' => '%' . $search . '%'],
                    ['Users.phone LIKE' => '%' . $search . '%'],
                    ['Users.email LIKE' => '%' . $search . '%'],
                    ['Users.age LIKE' => '%' . $search . '%'],
                    ['Users.created LIKE' => '%' . $search . '%'],
                ]
            ];
        }else{
            $where = ['Users.doctor_id' => $doctor_id];
        }
        return $where;
    }

    function reset(){
        $session = $this->request->session();
        $session->delete('users_search_query');
        $this->redirect(['action' => 'index']);
    }

    function getUser($user_id){
        $all_prescriptions = $this->Common->getAllPrescriptions($user_id);
        $prescriptions_link = null;
        foreach($all_prescriptions as $all_prescription){
            $prescriptions_link .=  '<li><a href="'. Router::url('/admin/prescriptions/view/'.$all_prescription->id, true ).'">'.$all_prescription->created.'</a></li>';
        }

        echo json_encode(array('user' => $this->Users->get($user_id), 'prescriptions' => $prescriptions_link));die;

    }

    function isUserAvailable(){
        $this->autoRender = false;

        $phone = $this->Users->findByPhone($this->request->data['phone']);

        $phone = $phone->toArray();
        if(empty($phone)){
            echo 'true';die;
        }else{
            echo 'false';die;
        }
    }
}
