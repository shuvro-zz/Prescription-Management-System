<?= $this->Form->create($user) ?>
    <section class="workspace">
        <div class="workspace-body">
            <div class="page-heading">
                <ol class="breadcrumb breadcrumb-small">
                    <li><a href="<?=$this->Url->build(array('action' => 'index' )) ?>" title="<?= __('Doctor') ?>"> <?= __('Doctor') ?></a></li>
                    <li class="active"><a href="#"><?= __('My Profile') ?></a></li>
                </ol>
            </div>
            <div class="main-container">
                <div class="content">
                    <div class="page-wrap">
                        <div class="col-sm-12 col-md-12">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="panel panel-default panel-hovered panel-stacked">
                                        <div class="panel-heading"><?= __('Edit Profile') ?></div>
                                        <div class="panel-body">
                                            <?php
                                            $user = $this->request->session()->read('Auth.User');

                                            echo '<div class="form-row">
                                                <div class="col-sm-6">
                                                    <label class="name">First Name<span class="required" aria-required="true"></span></label>
                                                        <div class="inputs">';
                                                    echo $this->Form->input('first_name', ['class' => 'form-control', 'label' => false, 'required' => true, 'type' =>'text']);
                                                    echo '</div>
                                                </div>
                                                <div class="col-sm-6">
                                                    <label class="name">Last Name<span class="required" aria-required="true"></span></label>
                                                    <div class="inputs">';
                                                        echo $this->Form->input('last_name', ['class' => 'form-control', 'label' => false, 'required' => true, 'type' =>'text']);
                                                    echo '</div>
                                                </div>
                                            </div>

                                            <div class="form-row">
                                                <div class="col-sm-6">
                                                    <label class="name">Address Line1<span class="required" aria-required="true"></span></label>
                                                    <div class="inputs">';
                                                        echo $this->Form->input('address_line1', ['class' => 'form-control', 'label' => false, 'required' => true, 'type' =>'text']);
                                                    echo '</div>
                                                </div>
                                                <div class="col-sm-6">
                                                    <label class="name">Address Line2<span class="required" aria-required="true"></span></label>
                                                    <div class="inputs">';
                                                        echo $this->Form->input('address_line2', ['class' => 'form-control', 'label' => false, 'required' => true, 'type' =>'text']);
                                                    echo '</div>
                                                </div>
                                            </div>

                                            <div class="form-row">
                                                <div class="col-sm-6">
                                                    <label class="name">Email<span class="required" aria-required="true"></span></label>
                                                    <div class="inputs">';
                                                        echo $this->Form->input('email', ['class' => 'form-control','disabled' => 'disabled', 'label' => false, 'type' =>'email']);
                                                    echo '</div>
                                                </div>

                                                <div class="col-sm-6">
                                                    <label class="name">Phone<span class="required" aria-required="true"></span></label>
                                                    <div class="inputs">';
                                                        echo $this->Form->input('phone', ['class' => 'form-control', 'label' => false, 'required' => true, 'type' =>'text']);
                                                    echo '</div>
                                                </div>
                                            </div>

                                            <div class="form-row">
                                                <div class="col-sm-12">
                                                    <label class="name">Educational Qualification<span class="required" aria-required="true"></span></label>
                                                    <div class="inputs">';
                                                        echo $this->Form->input('educational_qualification', ['class' => 'form-control', 'label' => false]);
                                                    echo '</div>
                                                </div>
                                            </div>

                                            <div class="form-row">
                                                <div class="col-sm-6">
                                                    <label class="name">Clinic Name<span class="required" aria-required="true"></span></label>
                                                    <div class="inputs">';
                                                        echo $this->Form->input('clinic_name', ['class' => 'form-control', 'label' => false, 'required' => true, 'type' =>'text']);
                                                    echo '</div>
                                                </div>
                                                <div class="col-sm-6">
                                                    <label class="name">Logo<span class="required" aria-required="true"></span></label>
                                                    <div class="inputs">';
                                                        echo $this->Form->input('logo', ['class' => 'form-control', 'label' => false, 'required' => true, 'type' =>'text']);
                                                    echo '</div>
                                                </div>
                                            </div>';
                                            ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <footer class="footer ">
            <div class="flex-container">
                <a href="<?php echo $this->Url->build(array('action' => 'index' )) ?>" class="btn btn-default  btn-cancel" title="Cancel">Cancel</a>
                <div class="flex-item">
                    <?= $this->Form->button(__('Submit'), ['class' => 'btn save event-save']) ?>
                </div>
            </div>
        </footer>

    </section>
<?= $this->Form->end() ?>