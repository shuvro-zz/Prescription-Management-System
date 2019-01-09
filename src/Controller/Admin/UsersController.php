<?php
namespace App\Controller\Admin;

use App\Controller\AppController;
use Cake\Core\Configure;
use Cake\Event\Event;
use Cake\Utility\Security;
use Cake\Routing\Router;
use Cake\Mailer\Email;

// New Define
use Cake\Auth\DefaultPasswordHasher;
use Cake\Auth\Auth;
use Cake\ORM\TableRegistry;
use Cake\Utility\Text;
use Cake\Filesystem\File;
use App\Model\Entity\Medicine;


class UsersController extends AppController
{
    public $components = ['EmailHandler','Common', 'FileHandler'];

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
            'registration',
            'apiRegistration',
            'getOnlinePatients',
            'getLocalPatients',
            'saveLocalPatientsToOnline'
        ]);
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

            $exit_patient = $this->Users->find('all')
                ->where([
                    'Users.phone' => $this->request->data['phone'],
                    'Users.first_name' => $this->request->data['first_name'],
                    'Users.doctor_id' => $this->request->session()->read('Auth.User.id')
                ])->first();

            if (empty($exit_patient)){
                $user = $this->Users->patchEntity($user, $this->request->data);

                $session = $this->request->session();
                $doctor_id = $session->read('Auth.User.id');

                $user->role_id = 3;
                $user->doctor_id = $doctor_id;

                if ($this->request->data['today_appointment']){
                    $user->appointment_date = date('Y/m/d');
                }

                if ($this->Users->save($user)) {
                    $success_message = __('The patient has been saved.');
                    $this->Flash->adminSuccess($success_message, ['key' => 'admin_success']);
                } else {
                    $error_message = __('The patient could not be saved. Please, try again.');
                    $this->Flash->adminError($error_message, ['key' => 'admin_error']);
                }

                return $this->redirect(['action' => 'index']);
            }else{
                $warning_message = __('The patient already exit.');
                $this->Flash->adminWarning($warning_message, ['key' => 'admin_warning']);

                return $this->redirect(['action' => 'add']);
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

            if ($user['role_id'] != 2){
                $user_phone = $this->Users->find('all')
                    ->where([
                        'Users.phone' => $this->request->data['phone'],
                        'Users.first_name' => $this->request->data['first_name'],
                        'Users.doctor_id' => $this->request->session()->read('Auth.User.id'),
                        'Users.id !=' => $id
                    ])->first();
            }

            if(empty($user_phone)){
                $user = $this->Users->patchEntity($user, $this->request->data);

                if ($this->request->data['today_appointment']){
                    $user->appointment_date = date('Y/m/d');
                    $user->is_visited = 0;
                }else{
                    $user->appointment_date = null;
                }

                if ($this->Users->save($user)) {

                    if ($this->request->session()->read('Auth.User.role_id') == 1 AND $user['is_localhost'] == 1){
                        $token = $this->generateExpireDateToken($user);
                        $token_msg = " Your key is " .$token. " has been send this doctors email address.";
                    }else{
                        $token_msg = "";
                    }

                    $success_message = __('The patient has been edited.'.$token_msg );
                    $this->Flash->adminSuccess($success_message, ['key' => 'admin_success']);
                } else {
                    $error_message = __('The patient could not be edit. Please, try again.');
                    $this->Flash->adminError($error_message, ['key' => 'admin_error']);
                }

                return $this->redirect(['action' => 'index']);
            }else{
                $this->Flash->adminWarning(__('The patient already exit'), ['key' => 'admin_warning']);
                return $this->redirect(['action' => 'edit/'.$id]);
            }
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

            $haveEmail = $this->Users->find('all')->where([
                            'Users.email' => $this->request->data['email'],
                            'Users.role_id' => 2 // doctor
                        ])->first();

            if (empty($haveEmail)){

                $user = $this->Users->patchEntity($user, $this->request->data);
                $month = strtotime("+12 Months");
                $user->expire_date = date('d/m/Y', $month);
                $user->role_id = 2;
                $user->token = $this->generateToken();

                if ($this->Users->save($user)) {
                    $success_message = __('Registration is successful.');
                    $this->Flash->adminSuccess($success_message, ['key' => 'admin_success']);
                    $this->login();

                    $user_info = $this->request->data;
                    $site_link = Router::url( '/', true );

                    if(Configure::read('email_send_allow')) {
                        $info = array(
                            'to' => $user_info['email'],
                            'subject' => 'Thanks for Registration',
                            'template' => 'registration_success',
                            'data' => array('User' => $user_info, 'base_url' => $site_link),
                        );
                        $this->EmailHandler->sendEmail($info);
                    }

                    return $this->redirect(['action' => 'index']);
                } else {
                    $error_message = __('The user could not be saved. Please, try again.');
                    $this->Flash->adminError($error_message, ['key' => 'admin_error']);
                }
            }
            else{
                $error_message = __('The email address already exit, Please use another email address.');
                $this->Flash->adminWarning($error_message, ['key' => 'admin_error']);
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
                $doctorInfo = $this->Users->find('all')->where(['Users.email' => $this->request->data['email']])->first();
                if ($doctorInfo){
                    $date_convert = date_create_from_format('d/m/Y', $doctorInfo['expire_date']);
                    if($doctorInfo['role_id'] == 1 OR strtotime(date_format($date_convert, 'd-m-Y')) > strtotime('now') ){
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

                        }else {
                            $error_message = __('You don\'t have permission to access');
                            $this->Flash->adminError($error_message, ['key' => 'admin_error']);
                            return $this->redirect(['action' => 'login']);
                        }

                    }else{
                        $error_message = __('Your registration has been expired, Please contact with Admin');
                        $this->Flash->adminWarning($error_message, ['key' => 'admin_error']);
                        return $this->redirect(['action' => 'login']);
                    }
                }else{
                    $error_message = __('Email not found');
                    $this->Flash->adminError($error_message, ['key' => 'admin_error']);
                    return $this->redirect(['action' => 'login']);
                }
            }
        }else{
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
                $session->write('Auth.User.cember_name', $this->request->data['cember_name']);
                $session->write('Auth.User.cember_address', $this->request->data['cember_address']);
                $session->write('Auth.User.visiting_time', $this->request->data['visiting_time']);
                $session->write('Auth.User.specialist', $this->request->data['specialist']);
                $session->write('Auth.User.off_day', $this->request->data['off_day']);
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
            if(!empty($query->first()->role_id) and ($query->first()->role_id == 2 or $query->first()->role_id == 1) ){  // Doctor = 2 and Admin = 1
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
    }

    public function generateToken(){
        return Text::uuid();
    }

    function __search(){

        $session = $this->request->session();
        $user_id = $session->read('Auth.User.id');

        if($session->check('users_search_query')){
            $search = $session->read('users_search_query');
            $where = [$this->checkById($user_id),
                'OR' => [
                    ['Users.first_name LIKE' => '%' . $search . '%'],
                    ['Users.phone LIKE' => '%' . $search . '%'],
                    ['Users.email LIKE' => '%' . $search . '%']
                ]
            ];
        }else{
            $where = $this->checkById($user_id);
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

        if($all_prescriptions){
            $prescriptions_link = null;
            foreach($all_prescriptions as $all_prescription){
                $prescriptions_link .=  '<li><a href="'. Router::url('/admin/prescriptions/view/'.$all_prescription->id, true ).'" target="_blank">'.$all_prescription->created->format('d F Y').'</a></li>';
            }
        }
        $latest_prescription = $this->Common->getLatestPrescription($user_id);
        $user = $this->Users->get($user_id);

        $last_visit_date = '';
        if($latest_prescription){
            $last_visit_date = $latest_prescription->created->format('j M Y');
        }

        echo json_encode(array('user' => $user, 'prescriptions' => $prescriptions_link, 'last_visit_date' => $last_visit_date));die;
    }

    function isUserAvailable(){
        $this->autoRender = false;

        $phone = $this->Users->findByPhone($this->request->data['phone'])
            ->where([
                'Users.doctor_id' => $this->request->session()->read('Auth.User.id')
            ]);

        $phone = $phone->toArray();
        if(empty($phone)){
            echo 'true';die;
        }else{
            echo 'false';die;
        }
    }

    function checkById($user_id){
        if($this->request->session()->read('Auth.User.role_id') == 1){ //Admin role_id
            $checkById = ['Users.role_id' => 2]; //Doctor role_id
        }else{
            $checkById = ['Users.doctor_id' => $user_id];
        }
        return $checkById;
    }

    function changeProfilePicture($id = null){
        $user = $this->Users->get($id, [
            'contain' => []
        ]);

        if( $this->request->is(['patch', 'post', 'put']) ) {
            $picture = $this->request->data['profile_picture'];
            $fileInfo = pathinfo($picture['name']);

            if ($fileInfo['extension'] == 'jpg' or $fileInfo['extension'] == 'png'){
                $uploaded_profile_pic_name = $this->uploadProfilePicture($picture);

                if ($user->profile_picture){
                    $file = new File(WWW_ROOT.DS. 'uploads'.DS. 'users' .DS. $user->profile_picture);
                    $file->delete();
                }

                if ($uploaded_profile_pic_name){
                    $user['profile_picture'] = $uploaded_profile_pic_name;

                    if ($this->Users->save($user)){
                        $session = $this->request->session();
                        $session->write('Auth.User.profile_picture', $uploaded_profile_pic_name);
                        $this->Flash->adminSuccess('Profile picture upload successfully', ['key' => 'admin_success']);
                    }else{
                        $this->Flash->adminError('Profile picture could not be upload', ['key' => 'admin_error']);
                    }
                }
            }else{
                $this->Flash->adminError('Please upload jpg or png file', ['key' => 'admin_error']);
            }
            return $this->redirect(['action' => 'change_profile_picture/'.$id]);
        }

        $this->set(compact('user'));
        $this->set('_serialize', ['user']);
    }

    function uploadProfilePicture($profile_pic){
        if( isset($profile_pic) ){
            if ($profile_pic) {
                $result = $this->FileHandler->uploadImage($profile_pic);
                if ($result) {
                    $profile_pic_name= $this->FileHandler->_uploadimgname;
                }
            }
        }
        return $profile_pic_name;
    }

   function prescriptionTemplate(){

       $session = $this->request->session();
       $userId = $session->read('Auth.User')['id'];

       $user = $this->Users->get($userId, [
           'contain' => []
       ]);

       $this->loadModel('PrescriptionTemplates');
       $prescription_templates = $this->PrescriptionTemplates->find('all')->toArray();

       if( $this->request->is(['patch', 'post', 'put']) ) {

           $user = $this->Users->patchEntity($user, $this->request->data);

           if ($this->Users->save($user)) {

               $session->write('Auth.User.prescription_template_id', $this->request->data['prescription_template_id']);

               $this->Flash->adminSuccess('Prescription template changed successfully', ['key' => 'admin_success']);
           } else {
               $this->Flash->adminError('Prescription template could not be changed', ['key' => 'admin_error']);
           }
       }

       $this->set(compact('prescription_templates', 'user'));
       $this->set('_serialize', ['prescription_templates']);

       $this ->render('prescription_template');
    }

    function generateExpireDateToken($user){

        $date_convert = date_create_from_format('d/m/Y', $user['expire_date']);
        $date = date_format($date_convert, 'd/m/Y');

        $token = base64_encode($user['email'] ."|". $date);

        $session = $this->request->session();
        $doctor = $session->read('Auth.User');

        $info = array(
            'to'                => $user['email'],
            'subject'           => 'Application active token',
            'template'          => 'activation_token',
            'data'              => array('User' => $user, 'Doctor' => $doctor, 'Token' => $token)
        );

        if(!Configure::read('is_localhost')) {
            $this->EmailHandler->sendEmail($info);
        }

        return $token;
    }

    function addTodayAppointment($id = null){
        $this->autoRender = false;

        $patient = $this->Users->get($id);
        $patient->appointment_date = date('Y/m/d ');
        $patient->is_visited = 0;

        if ( $this->Users->save($patient)){
            $this->Flash->adminSuccess('Patient has been added for today\'s appointment', ['key' => 'admin_success']);
        }else{
            $this->Flash->adminError('Patient could not be added for today\'s appointment ', ['key' => 'admin_error']);
        }

        return $this->redirect(['action' => 'index']);
    }



/************************************************
///////////////////Api///////////////////////////
*************************************************/

    function apiRegistration(){
         $exit_doctor = $this->Users->find('all')
                             ->where([
                                 'Users.email' => trim($this->request->data['email']),
                                 'Users.role_id' => 2 // doctor
                             ])->first();

         if ($exit_doctor == null){
             $doctor = $this->Users->newEntity();
         }else{
             $doctor = $exit_doctor;
         }

         if ($this->request->is('post')) {
             $doctor = $this->Users->patchEntity($doctor, $this->request->data);
             $doctor->role_id = 2;
             $doctor->is_localhost = 1;
             $doctor->is_sync = 1;
             $doctor->expire_date = $this->request->data['expire_date'];
             $doctor->token = $this->generateToken();

             if ($this->Users->save($doctor)) {
                 echo json_encode(['status' => 'success']);die;
             } else {
                 echo json_encode(['fail']);die;
             }
         }
    }

    function getOnlinePatients(){
        $this->autoRender = false;
        header('Content-Type: application/json');

        if ($this->request->is('get')){
            $online_doctor_id = $this->Common->getOnlineDoctorId($this->request->query['doctor_email']);

            $online_patients = $this->Users->find('all', ['limit' => 100])->order(['Users.id' => 'asc'])
                                ->where([
                                    'Users.doctor_id' => $online_doctor_id,
                                    'Users.role_id' => 3,
                                    'Users.is_sync' => 0
                                ])->toArray();

            echo json_encode($online_patients);die;

        }elseif($this->request->is('post')){
            $local_patients = $this->request->data;
            $this->changeIsSyncOnlinePatients($local_patients);
        }
    }

    function changeIsSyncOnlinePatients($local_patients){
        foreach ($local_patients as $local_patient){
            $patient = $this->Users->get($local_patient['id']);
            $patient->is_sync = 1;
            $this->Users->save($patient);
        }
    }

    function getLocalPatients(){
        $this->autoRender = false;
        header('Content-Type: application/json');

        $online_doctor_id = $this->Common->getOnlineDoctorId($this->request->query['doctor_email']);

        if ($online_doctor_id){
            $save_report = $this->saveLocalPatientsToOnline($this->request->data, $online_doctor_id);
            if ($save_report){
                echo json_encode([
                    'status' => 'success',
                    'online_total' => $save_report[0]['online_total'],
                    'online_success' => $save_report[0]['online_success'],
                    'online_duplicate' => $save_report[0]['online_duplicate'],
                ]);die;
            }
        }
        echo json_encode([  'status' => 'fail']);die;
    }

    function saveLocalPatientsToOnline($local_patients, $online_doctor_id){
        $online_total = $online_success = $online_duplicate = 0;

        $online_total = count($local_patients);
        foreach($local_patients as $local_patient){
            $have_patient = $this->Users->find()->where(['Users.first_name' => $local_patient['first_name'], 'Users.phone' => $local_patient['phone'], 'Users.doctor_id' => $online_doctor_id])->first();

            if ($have_patient){
                $have_patient->is_sync = 1;
                $this->Users->save($have_patient);

                $online_duplicate++;
            }else{
                $user = $this->Users->newEntity();
                $user = $this->Users->patchEntity($user, $local_patient);
                $user->doctor_id = $online_doctor_id;
                $user->is_sync = 1;
                $this->Users->save($user);

                $online_success++;
            }
        }

        if ($online_duplicate > 0 OR $online_success > 0){
            return Array(['online_total' => $online_total, 'online_success' => $online_success, 'online_duplicate' => $online_duplicate]);
        }
        return false;
    }
}

