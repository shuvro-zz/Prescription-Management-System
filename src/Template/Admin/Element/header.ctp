<?php use Cake\Routing\Router;?>
<header id="header" class="topbar">
    <div class="logo">
        <a href="<?php echo $this->Url->build('/admin/dashboard');?>" title="">
            <h1 style="margin-bottom: 0px">PMS</h1>

            <?php /*echo $this->Html->image('/css/admin_styles/images/logo.png', ['alt' => 'Logo']) */?>
        </a>
    </div>
    <div class="topbar-inner">
        <div class="flex-container">
            <div class="flex-item">
                <div class="flex-container">
                    <!-- <div class="toggle-menu">
                        <span class="toggle-menu-bar"><i class="fa fa-bars"></i></span>
                    </div>
                    <a href="<?php /*echo $this->Url->build('/');*/?>" target="_blank"> <span class="nav-text">Visit Site</span></a>-->
                </div>
            </div>
            <div class="flex-item">
                <div class="profile-area dropdown">
<!--                    <div class="notification">-->
<!--                        <a href="" class="notifier dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">-->
<!--                            <span class="fa fa-bell-o"></span>-->
<!--                            <span class="counter">04</span>-->
<!--                        </a>-->
<!--                       <ul class="dropdown-menu notification-dropdown" aria-labelledby="offer-notification">-->
<!---->
<!--                               <div class="notification-inner">-->
<!--                                   <li>-->
<!--                                       <span>03/01 08:38</span><a href="" class="ng-binding">You have created a new Events.</a>-->
<!--                                   </li>-->
<!--                                   <li>-->
<!--                                       <span>27/12 13:06</span><a href="" class="ng-binding">You have created a new Events.</a>-->
<!--                                   </li>-->
<!--                                   <li>-->
<!--                                       <span>20/12 09:26</span><a href="" class="ng-binding">You have created a new Events.</a>-->
<!--                                   </li>-->
<!---->
<!--                                   <li>-->
<!--                                       <span>19/12 15:20</span><a href="">You have created a new Events.</a>-->
<!--                                   </li>-->
<!--                               </div>-->
<!---->
<!--                               <li class="view_all_li"><a href="#">View All</a></li>-->
<!--                           </ul>-->
<!--                    </div>-->
<!--                    <div class="message-box">-->
<!--                         <a href="" class="message dropdown-toggle" type="button" id="dropdownMenu" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">-->
<!--                            <span class="fa fa-envelope-o"></span>-->
<!--                            <span class="counter">12</span>-->
<!--                        </a>-->
<!--                            <ul class="dropdown-menu message-dropdown" aria-labelledby="message-notification">-->
<!---->
<!--                               <div class="notification-inner">-->
<!--                             <div class="media">-->
<!--                               <div class="media-left">-->
<!--                                   <a href="#">-->
<!--                                     <img class="media-object" src="/css/admin_styles/images/dashboard-user.png" alt="...">-->
<!--                                   </a>-->
<!--                                 </div>-->
<!--                               <div class="media-body">-->
<!--                               <li>-->
<!--                                   <span>03/01 08:38</span><a href="" class="ng-binding">You Received a New Message!</a>-->
<!--                                   </li>-->
<!--                                </div>-->
<!--                               </div>-->
<!---->
<!--                               <div class="media">-->
<!--                                      <div class="media-left">-->
<!--                                          <a href="#">-->
<!--                                            <img class="media-object" src="/css/admin_styles/images/dashboard-user.png" alt="...">-->
<!--                                          </a>-->
<!--                                        </div>-->
<!--                                      <div class="media-body">-->
<!--                                      <li>-->
<!--                                          <span>03/01 08:38</span><a href="" class="ng-binding">You Received a New Message!</a>-->
<!--                                          </li>-->
<!--                                       </div>-->
<!--                                      </div>-->
<!---->
<!--                                      <div class="media">-->
<!--                                         <div class="media-left">-->
<!--                                             <a href="#">-->
<!--                                               <img class="media-object" src="/css/admin_styles/images/dashboard-user.png" alt="...">-->
<!--                                             </a>-->
<!--                                           </div>-->
<!--                                         <div class="media-body">-->
<!--                                         <li>-->
<!--                                             <span>03/01 08:38</span><a href="" class="ng-binding">You Received a New Message!</a>-->
<!--                                             </li>-->
<!--                                          </div>-->
<!--                                         </div>-->
<!---->
<!--                                         <div class="media">-->
<!--                                            <div class="media-left">-->
<!--                                                <a href="#">-->
<!--                                                  <img class="media-object" src="/css/admin_styles/images/dashboard-user.png" alt="...">-->
<!--                                                </a>-->
<!--                                              </div>-->
<!--                                            <div class="media-body">-->
<!--                                            <li>-->
<!--                                                <span>03/01 08:38</span><a href="" class="ng-binding">You Received a New Message!</a>-->
<!--                                                </li>-->
<!--                                             </div>-->
<!--                                            </div>-->
<!---->
<!--                                            <div class="media">-->
<!--                                               <div class="media-left">-->
<!--                                                   <a href="#">-->
<!--                                                     <img class="media-object" src="/css/admin_styles/images/dashboard-user.png" alt="...">-->
<!--                                                   </a>-->
<!--                                                 </div>-->
<!--                                               <div class="media-body">-->
<!--                                               <li>-->
<!--                                                   <span>03/01 08:38</span><a href="" class="ng-binding">You Received a New Message!</a>-->
<!--                                                   </li>-->
<!--                                                </div>-->
<!--                                               </div>-->
<!---->
<!--                               </div>-->
<!---->
<!--                               <li class="view_all_li"><a href="#">View All</a></li>-->
<!--                           </ul>-->
<!--                    </div>-->

                    <div class="user-profile dropdown">
                        <?php
                            $user = $this->request->session()->read('Auth.User');
                            if (($user['profile_picture'])){
                                $profile_pic = $this->request->webroot.'uploads/users/'.$user['profile_picture'];
                            }else{
                                $profile_pic = $this->request->webroot.'css/admin_styles/images/dashboard-students.png';
                            }
                        ?>

                        <img src="<?php echo $profile_pic ?>" alt="User" class="profile_picture" >

                        <a href="#" data-toggle="dropdown" aria-expanded="true"><span class="user-name"><?php echo ucfirst($user['first_name']).' '.ucfirst($user['last_name']) ?> <i class="fa fa-angle-down"></i></span></a>
                        <div class="dropdown-menu  user-dropdown">

                            <li>
                                <a href="<?php echo $this->Url->build(['controller' => 'users','action' => 'myProfile',$user['id'] ])?>" class="view_all_li"><i class="fa fa-user-md" aria-hidden="true"></i> My Profile</a>
                            </li>

                            <li>
                                <a href="<?php echo $this->Url->build(['controller' => 'users','action' => 'changeProfilePicture',$user['id'] ])?>" class="view_all_li"><i class="fa fa-user-md" aria-hidden="true"></i> Change Profile Picture</a>
                            </li>

                            <li>
                                <a href="<?php echo $this->Url->build(['controller' => 'users','action' => 'changePassword',$user['token'] ])?>" class="view_all_li"><i class="fa fa-cog" aria-hidden="true"></i> Change Password</a>
                            </li>

                            <li>
                                <a href="<?php echo $this->Url->build(['controller' => 'settings','action' => 'add' ])?>" class="view_all_li"><i class="fa fa-cog" aria-hidden="true"></i> Settings</a>
                            </li>

                            <li>
                                <a href="<?php echo $this->Url->build(['controller' => 'users','action' => 'logout' ])?>" class="view_all_li"><i class="fa fa-sign-out" aria-hidden="true"></i> Logout</a>
                            </li>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>
