<?php
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
?>

<CakePHPBakeOpenTag= $this->Form->create($<?= $singularVar ?>) CakePHPBakeCloseTag>
<section class="workspace">
    <div class="workspace-body">
        <div class="page-heading">
            <ol class="breadcrumb breadcrumb-small">
                <li><a href="<CakePHPBakeOpenTag=$this->Url->build(array('action' => 'index' )) CakePHPBakeCloseTag>" title="<CakePHPBakeOpenTag= __('<?= $singularHumanName ?>') CakePHPBakeCloseTag>"> <CakePHPBakeOpenTag= __('<?= $singularHumanName ?>') CakePHPBakeCloseTag></a></li>
                <li class="active"><a href="#">Add <CakePHPBakeOpenTag= __('<?= $singularHumanName ?>') CakePHPBakeCloseTag></a></li>
            </ol>
        </div>
        <div class="main-container">
            <div class="content">
                <div class="page-wrap">
                    <div class="col-sm-12 col-md-12">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="panel panel-default panel-hovered panel-stacked">
                                    <div class="panel-heading"><CakePHPBakeOpenTag= __('<?= Inflector::humanize($action) ?> <?= $singularHumanName ?>') CakePHPBakeCloseTag></div>
                                    <div class="panel-body">
                                        <CakePHPBakeOpenTagphp
                                        <?php
                                        foreach ($fields as $field) {
                                            if (in_array($field, $primaryKey)) {
                                                continue;
                                            }
                                            if (isset($keyFields[$field])) {
                                                $fieldData = $schema->column($field);
                                                if (!empty($fieldData['null'])) {
                                                    ?>
                                                    echo $this->Form->input('<?= $field ?>', ['options' => $<?= $keyFields[$field] ?>, 'empty' => true]);
                                                    <?php
                                                } else {
                                                    ?>
                                                    echo $this->Form->input('<?= $field ?>', ['options' => $<?= $keyFields[$field] ?>]);
                                                    <?php
                                                }
                                                continue;
                                            }
                                            if (!in_array($field, ['created', 'modified', 'updated'])) {
                                                ?> echo'<div class="col-sm-6">
                                                    <div class="form-row">
                                                        <label class="name"><?= Inflector::humanize($field) ?><span class="required" aria-required="true"></span></label>
                                                        <div class="inputs">';
                                                            echo $this->Form->input('<?= $field ?>', ['class' => 'form-control', 'label' => false, 'required' => true, 'type' =>'text']);
                                                        echo '</div>
                                                    </div>
                                                </div>';
                                                <?php
                                            }
                                        }
                                        if (!empty($associations['BelongsToMany'])) {
                                            foreach ($associations['BelongsToMany'] as $assocName => $assocData) {?>
                                                echo $this->Form->input('<?= $assocData['property'] ?>._ids', ['options' => $<?= $assocData['variable'] ?>]);
    <?php
                }
}
?> CakePHPBakeCloseTag>
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
            <a href="<CakePHPBakeOpenTagphp echo $this->Url->build(array('action' => 'index' )) CakePHPBakeCloseTag>" class="btn btn-default  btn-cancel" title="Cancel">Cancel</a>
            <div class="flex-item">
                <CakePHPBakeOpenTag= $this->Form->button(__('Submit'), ['class' => 'btn save event-save']) CakePHPBakeCloseTag>
            </div>
        </div>
    </footer>
    
</section>
<CakePHPBakeOpenTag= $this->Form->end() CakePHPBakeCloseTag>
