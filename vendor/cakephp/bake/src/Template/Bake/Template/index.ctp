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
        return !in_array($schema->columnType($field), ['binary', 'text']);
    })
    ->take(7);

if (isset($modelObject) && $modelObject->behaviors()->has('Tree')) {
    $fields = $fields->reject(function ($field) {
        return $field === 'lft' || $field === 'rght';
    });
}
%>
<div class="workspace-dashboard page page-ui-tables">

    <div class="page-heading">
        <div class="flex-container">
            <div class="flex-item"><h4><?= __('<%= $pluralHumanName %>') ?></h4></div>
            <div class="flex-item">
                <?php echo $this->Html->link(
                    '<span class="icon">+</span> Add <%= $singularHumanName %>',
                    ['action' => 'add'],
                    ['class' => 'add-event-btn', 'escapeTitle' => false, 'title' => 'Add <%= $singularHumanName %>']
                ) ?>
            </div>
        </div>
    </div>

    <div class="col-md-12">
        <?php echo $this->Flash->render('admin_success'); ?>
        <?php echo $this->Flash->render('admin_error'); ?>
    </div>

    <div class="event-listing">
        <div class="event-listing-top flex-container status-function">
            <div class="status-area flex-container">
                <div class="event-src-box">
                    <?php echo $this->Form->create('<%= $pluralHumanName %>',['type' => 'get'],array('id' => 'site-search','url'=>array('action'=>'index'),'method'=>'get'));?>
                    <?php echo $this->Form->input('search',array('class' => 'form-control', 'label' => false, 'placeholder' => 'Type here for search...')); ?>
                    <button type="submit"> <i class="fa fa-search"></i></button>
                    <?php echo $this->Form->end();?>
                </div>
            </div>
        </div>

        <div class="table-responsive table-part">
            <?php echo $this->Form->create('<%= $pluralHumanName %>',['type' => 'post'],array('id' => 'delete-all','url'=>array('action'=>'delete-all'),'method'=>'post'));?>
            <?php echo $this->Form->button(__('Remove'), ['class' => 'btn btn-danger']) ?>
            <table class="table table-hover  table-striped">
                <thead>
                    <tr>
        <% foreach ($fields as $field): %>
                        <% if($field!='id'): %>
                        <th><?= $this->Paginator->sort('<%= $field %>') ?></th>
                        <% endif; %>
        <% endforeach; %>
                        <th class="actions"><?= __('Actions') ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($<%= $pluralVar %> as $<%= $singularVar %>): ?>
                    <tr>
        <%        $i=0;
                  foreach ($fields as $field) {

                        if($i>0):
                    $isKey = false;
                    if (!empty($associations['BelongsTo'])) {
                        foreach ($associations['BelongsTo'] as $alias => $details) {
                            if ($field === $details['foreignKey']) {
                                $isKey = true;
        %>
                        <td><?= $<%= $singularVar %>->has('<%= $details['property'] %>') ? $this->Html->link($<%= $singularVar %>-><%= $details['property'] %>-><%= $details['displayField'] %>, ['controller' => '<%= $details['controller'] %>', 'action' => 'view', $<%= $singularVar %>-><%= $details['property'] %>-><%= $details['primaryKey'][0] %>]) : '' ?></td>
        <%
                                break;
                            }
                        }
                    }
                    if ($isKey !== true) {
                        if (!in_array($schema->columnType($field), ['integer', 'biginteger', 'decimal', 'float'])) {
        %>
                        <td><?= h($<%= $singularVar %>-><%= $field %>) ?></td>
        <%
                        } else {
        %>
                        <td><?= $this->Number->format($<%= $singularVar %>-><%= $field %>) ?></td>
        <%
                        }
                    }
                        endif;
                        $i++;
                }

                $pk = '$' . $singularVar . '->' . $primaryKey[0];
        %>
                        <td class="actions" style="width: 204px;">
                            <div class="dropdown action-button">
                                <span class="dropdown-toggle event-action" type="button" data-toggle="dropdown" >
                                    <?php echo $this->Html->image('/css/admin_styles/images/dashboard-settings-sm.png', ['alt' => 'Settings']) ?>
                                </span>
                                <ul class="dropdown-menu action-dropdown">
                                    <li>
                                        <?php
                                        echo $this->Html->link(
                                        '<span class="fa fa-pencil-square"></span> Edit',
                                        ['action' => 'edit', <%= $pk %>],
                                        ['escapeTitle' => false, 'title' => 'Edit Venue']
                                        );
                                        ?>
                                    </li>
                                    <li>
                                        <?php
                                        echo $this->Form->postLink(
                                        '<span class="fa fa-trash"></span> Delete',
                                        ['action' => 'delete', <%= $pk %>],
                                        ['escapeTitle' => false, 'title' => 'Delete Coupon','confirm' => __('Are you sure you want to delete # {0}?', <%= $pk %>)]
                                        );
                                        ?>
                                    </li>
                                </ul>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <?php echo $this->Form->end();?>
        </div>

        <div class="bottom-pagination">
            <div class="pagination-area flex-container">
                <div class="pagination-status-text">
                    Showing <?php echo $this->Paginator->counter() ?> entries
                </div>
                <ul class="pagination">
                    <?php
                    if($this->Paginator->numbers()) {
                    echo $this->Paginator->prev('< ' . __(''));
                    echo $this->Paginator->numbers();
                    echo $this->Paginator->next(__('') . ' >');
                    }
                    ?>
                </ul>
            </div>
        </div>
    </div>
</div>
