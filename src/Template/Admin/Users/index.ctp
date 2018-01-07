

<div class="page page-ui-tables">

    <ol class="breadcrumb breadcrumb-small">
        <li><?php echo $this->Html->link('Dashboard',['controller' => 'dashboard', 'action' => 'index', '_full' => true]); ?></li>
        <li class="active"><a href="#">All Users</a></li>
    </ol>

    <div class="page-wrap">
        <!-- row -->
        <div class="row">

            <div class="col-md-12">
                <?php echo $this->Flash->render('admin_success'); ?>
                <?php echo $this->Flash->render('admin_error'); ?>
            </div>


            <!-- Basic Table -->
            <div class="col-md-12">
                <div class="panel panel-lined panel-hovered mb20 table-responsive basic-table">
                    <div class="panel-heading">

                        <div class="col-md-4">
                        All Users
                        </div>

                        <div class="col-md-4">
                            <ul class="list-unstyled left-elems">
                                <li>
                                    <div class="form-search hidden-xs">
                                        <?php echo $this->Form->create('User',array('id' => 'site-search','url'=>array('action'=>'index')));?>
                                        <?php echo $this->Form->input('search',array('class' => 'form-control', 'label' => false, 'placeholder' => 'Type here for search...')); ?>

                                        <button type="submit" class="ion ion-ios-search-strong"></button>
                                        <?php echo $this->Form->end();?>
                                    </div>
                                </li>
                            </ul>
                        </div>

                    </div>
                    <div class="panel-body">
                        <table class="table">
                            <thead>
                            <tr>
                                <!--
                                <th class="col-lg-1"><button type="button" class="btn btn-default btn-sm fa fa-trash"></th>
                                -->
                                <th>ID<?php //echo $this->Paginator->sort('id','Id'); ?></th>
                                <th>Name<?php //echo $this->Paginator->sort('first_name','Name'); ?></th>
                                <th>Email<?php //echo $this->Paginator->sort('email','Email'); ?></th>
                                <th class="actions"><?php echo __('Actions') ?></th>

                            </tr>
                            </thead>
                            <tbody>
                            <?php if(!empty($users)){ foreach ($users as $user){ ?>
                                <tr>
                                    <!--
                                    <td>
                                        <div class="ui-checkbox ui-checkbox-primary ml5">
                                            <label><input type="checkbox"><span></span>
                                            </label>
                                        </div>
                                    -->
                                    <td><?php echo $user->id ?></td>
                                    <td><?php echo $user->first_name.' '.$user->last_name ?></td>
                                    <td><?php echo $user->email ?></td>
                                    <td class="actions">
                                        <?php

                                        echo $this->Html->link(
                                            '<span class="fa fa-pencil-square"></span>',
                                            ['action' => 'edit', $user->id],
                                            ['escapeTitle' => false, 'title' => 'Edit User']
                                        );

                                        echo $this->Form->postLink(
                                            '<span class="fa fa-trash"></span>',
                                            ['action' => 'delete', $user->id],
                                            ['escapeTitle' => false, 'title' => 'Delete User','confirm' => __('Are you sure you want to delete # {0}?', $user->id)]
                                        );

                                        echo $this->Html->link( '<span class="fa fa-wrench"></span>', array( 'action' => 'reset_password', $user->id ), array('escape'=>false,'title'=>'Reset Password') ) .'&nbsp';

                                        ?>

                                    </td>
                                </tr>
                            <?php }}; ?>


                            </tbody>
                        </table>

                        <div class="paginator">
                            <ul class="pagination">
                                <?php echo $this->Paginator->prev('< ' . __('previous')) ?>
                                <?php echo $this->Paginator->numbers() ?>
                                <?php echo $this->Paginator->next(__('next') . ' >') ?>
                            </ul>
                            <p><?php echo $this->Paginator->counter() ?></p>
                        </div>

                    </div>
                </div>
            </div>


        </div>


        <!-- #end row -->
    </div> <!-- #end page-wrap -->
</div>

