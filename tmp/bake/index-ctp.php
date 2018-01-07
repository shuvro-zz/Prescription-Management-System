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
        return !in_array($schema->columnType($field), ['binary', 'text']);
    })
    ->take(7);

if (isset($modelObject) && $modelObject->behaviors()->has('Tree')) {
    $fields = $fields->reject(function ($field) {
        return $field === 'lft' || $field === 'rght';
    });
}
?>
<div class="workspace-dashboard page page-ui-tables">

    <div class="page-heading">
        <div class="flex-container">
            <div class="flex-item"><h4><CakePHPBakeOpenTag= __('<?= $pluralHumanName ?>') CakePHPBakeCloseTag></h4></div>
            <div class="flex-item">
                <CakePHPBakeOpenTagphp echo $this->Html->link(
                    '<span class="icon">+</span> Add <?= $singularHumanName ?>',
                    ['action' => 'add'],
                    ['class' => 'add-event-btn', 'escapeTitle' => false, 'title' => 'Add <?= $singularHumanName ?>']
                ) CakePHPBakeCloseTag>
            </div>
        </div>
    </div>

    <div class="col-md-12">
        <CakePHPBakeOpenTagphp echo $this->Flash->render('admin_success'); CakePHPBakeCloseTag>
        <CakePHPBakeOpenTagphp echo $this->Flash->render('admin_error'); CakePHPBakeCloseTag>
    </div>

    <div class="event-listing">
        <div class="event-listing-top flex-container status-function">
            <div class="status-area flex-container">
                <div class="event-src-box">
                    <CakePHPBakeOpenTagphp echo $this->Form->create('<?= $pluralHumanName ?>',['type' => 'get'],array('id' => 'site-search','url'=>array('action'=>'index'),'method'=>'get'));CakePHPBakeCloseTag>
                    <CakePHPBakeOpenTagphp echo $this->Form->input('search',array('class' => 'form-control', 'label' => false, 'placeholder' => 'Type here for search...')); CakePHPBakeCloseTag>
                    <button type="submit"> <i class="fa fa-search"></i></button>
                    <CakePHPBakeOpenTagphp echo $this->Form->end();CakePHPBakeCloseTag>
                </div>
            </div>
        </div>

        <div class="table-responsive table-part">
            <CakePHPBakeOpenTagphp echo $this->Form->create('<?= $pluralHumanName ?>',['type' => 'post'],array('id' => 'delete-all','url'=>array('action'=>'delete-all'),'method'=>'post'));CakePHPBakeCloseTag>
            <CakePHPBakeOpenTagphp echo $this->Form->button(__('Remove'), ['class' => 'btn btn-danger']) CakePHPBakeCloseTag>
            <table class="table table-hover  table-striped">
                <thead>
                    <tr>
        <?php foreach ($fields as $field): ?>
                        <?php if($field!='id'): ?>
                        <th><CakePHPBakeOpenTag= $this->Paginator->sort('<?= $field ?>') CakePHPBakeCloseTag></th>
                        <?php endif; ?>
        <?php endforeach; ?>
                        <th class="actions"><CakePHPBakeOpenTag= __('Actions') CakePHPBakeCloseTag></th>
                    </tr>
                </thead>
                <tbody>
                    <CakePHPBakeOpenTagphp foreach ($<?= $pluralVar ?> as $<?= $singularVar ?>): CakePHPBakeCloseTag>
                    <tr>
        <?php        $i=0;
                  foreach ($fields as $field) {

                        if($i>0):
                    $isKey = false;
                    if (!empty($associations['BelongsTo'])) {
                        foreach ($associations['BelongsTo'] as $alias => $details) {
                            if ($field === $details['foreignKey']) {
                                $isKey = true;
        ?>
                        <td><CakePHPBakeOpenTag= $<?= $singularVar ?>->has('<?= $details['property'] ?>') ? $this->Html->link($<?= $singularVar ?>-><?= $details['property'] ?>-><?= $details['displayField'] ?>, ['controller' => '<?= $details['controller'] ?>', 'action' => 'view', $<?= $singularVar ?>-><?= $details['property'] ?>-><?= $details['primaryKey'][0] ?>]) : '' CakePHPBakeCloseTag></td>
        <?php
                                break;
                            }
                        }
                    }
                    if ($isKey !== true) {
                        if (!in_array($schema->columnType($field), ['integer', 'biginteger', 'decimal', 'float'])) {
        ?>
                        <td><CakePHPBakeOpenTag= h($<?= $singularVar ?>-><?= $field ?>) CakePHPBakeCloseTag></td>
        <?php
                        } else {
        ?>
                        <td><CakePHPBakeOpenTag= $this->Number->format($<?= $singularVar ?>-><?= $field ?>) CakePHPBakeCloseTag></td>
        <?php
                        }
                    }
                        endif;
                        $i++;
                }

                $pk = '$' . $singularVar . '->' . $primaryKey[0];
        ?>
                        <td class="actions" style="width: 204px;">
                            <div class="dropdown action-button">
                                <span class="dropdown-toggle event-action" type="button" data-toggle="dropdown" >
                                    <CakePHPBakeOpenTagphp echo $this->Html->image('/css/admin_styles/images/dashboard-settings-sm.png', ['alt' => 'Settings']) CakePHPBakeCloseTag>
                                </span>
                                <ul class="dropdown-menu action-dropdown">
                                    <li>
                                        <CakePHPBakeOpenTagphp
                                        echo $this->Html->link(
                                        '<span class="fa fa-pencil-square"></span> Edit',
                                        ['action' => 'edit', <?= $pk ?>],
                                        ['escapeTitle' => false, 'title' => 'Edit Venue']
                                        );
                                        CakePHPBakeCloseTag>
                                    </li>
                                    <li>
                                        <CakePHPBakeOpenTagphp
                                        echo $this->Form->postLink(
                                        '<span class="fa fa-trash"></span> Delete',
                                        ['action' => 'delete', <?= $pk ?>],
                                        ['escapeTitle' => false, 'title' => 'Delete Coupon','confirm' => __('Are you sure you want to delete # {0}?', <?= $pk ?>)]
                                        );
                                        CakePHPBakeCloseTag>
                                    </li>
                                </ul>
                            </div>
                        </td>
                    </tr>
                    <CakePHPBakeOpenTagphp endforeach; CakePHPBakeCloseTag>
                </tbody>
            </table>
            <CakePHPBakeOpenTagphp echo $this->Form->end();CakePHPBakeCloseTag>
        </div>

        <div class="bottom-pagination">
            <div class="pagination-area flex-container">
                <div class="pagination-status-text">
                    Showing <CakePHPBakeOpenTagphp echo $this->Paginator->counter() CakePHPBakeCloseTag> entries
                </div>
                <ul class="pagination">
                    <CakePHPBakeOpenTagphp
                    if($this->Paginator->numbers()) {
                    echo $this->Paginator->prev('< ' . __(''));
                    echo $this->Paginator->numbers();
                    echo $this->Paginator->next(__('') . ' >');
                    }
                    CakePHPBakeCloseTag>
                </ul>
            </div>
        </div>
    </div>
</div>
