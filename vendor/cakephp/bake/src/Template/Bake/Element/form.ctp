<%
/**
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @since         0.1.0
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */
use Cake\Utility\Inflector;

$fields = collection($fields)
    ->filter(function($field) use ($schema) {
        return $schema->columnType($field) !== 'binary';
    });

if (isset($modelObject) && $modelObject->behaviors()->has('Tree')) {
    $fields = $fields->reject(function ($field) {
        return $field === 'lft' || $field === 'rght';
    });
}
%>

<?= $this->Form->create($<%= $singularVar %>) ?>
<section class="workspace">
    <div class="workspace-body">
        <div class="page-heading">
            <ol class="breadcrumb breadcrumb-small">
                <li><a href="<?=$this->Url->build(array('action' => 'index' )) ?>" title="<?= __('<%= $singularHumanName %>') ?>"> <?= __('<%= $singularHumanName %>') ?></a></li>
                <li class="active"><a href="#">Add <?= __('<%= $singularHumanName %>') ?></a></li>
            </ol>
        </div>
        <div class="main-container">
            <div class="content">
                <div class="page-wrap">
                    <div class="col-sm-12 col-md-12">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="panel panel-default panel-hovered panel-stacked">
                                    <div class="panel-heading"><?= __('<%= Inflector::humanize($action) %> <%= $singularHumanName %>') ?></div>
                                    <div class="panel-body">
                                        <?php
                                        <%
                                        foreach ($fields as $field) {
                                            if (in_array($field, $primaryKey)) {
                                                continue;
                                            }
                                            if (isset($keyFields[$field])) {
                                                $fieldData = $schema->column($field);
                                                if (!empty($fieldData['null'])) {
                                                    %>
                                                    echo $this->Form->input('<%= $field %>', ['options' => $<%= $keyFields[$field] %>, 'empty' => true]);
                                                    <%
                                                } else {
                                                    %>
                                                    echo $this->Form->input('<%= $field %>', ['options' => $<%= $keyFields[$field] %>]);
                                                    <%
                                                }
                                                continue;
                                            }
                                            if (!in_array($field, ['created', 'modified', 'updated'])) {
                                                %> echo'<div class="col-sm-6">
                                                    <div class="form-row">
                                                        <label class="name"><%= Inflector::humanize($field) %><span class="required" aria-required="true"></span></label>
                                                        <div class="inputs">';
                                                            echo $this->Form->input('<%= $field %>', ['class' => 'form-control', 'label' => false, 'required' => true, 'type' =>'text']);
                                                        echo '</div>
                                                    </div>
                                                </div>';
                                                <%
                                            }
                                        }
                                        if (!empty($associations['BelongsToMany'])) {
                                            foreach ($associations['BelongsToMany'] as $assocName => $assocData) {%>
                                                echo $this->Form->input('<%= $assocData['property'] %>._ids', ['options' => $<%= $assocData['variable'] %>]);
    <%
                }
}
%> ?>
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
