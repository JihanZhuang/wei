<?php
/**
 * center
 *
 * Copyright (c) 2008-2010 Twin Huang. All rights reserved.
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *   http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 *
 * @package     Qwin
 * @subpackage  
 * @author      Twin Huang <twinh@yahoo.cn>
 * @copyright   Twin Huang
 * @license     http://www.opensource.org/licenses/apache2.0.php Apache License
 * @version     $Id$
 * @since       2010-12-10 00:37:30
 */
?>
<div class="ui-widget">
<table class="ui-table ui-widget-content ui-corner-all" cellpadding="0" cellspacing="0">
            <tr class="ui-widget-header ui-table-header">
                <td colspan="3" class="ui-corner-top">
                    <?php echo qw_lang('LBL_CONFIG_CENTER') ?>
                </td>
            </tr>
            <tr class="ui-widget-content">
                <td class="ui-state-default" width="20%"><?php echo qw_lang('LBL_FIELD_NAME') ?></td>
                <td class="ui-state-default"><?php echo qw_lang('LBL_FIELD_DESCRIPTION') ?></td>
                <td class="ui-state-default" width="10%"><?php echo qw_lang('LBL_FIELD_OPERATION') ?></td>
            </tr>
            <?php
            foreach($data as $row):
            ?>
            <tr class="ui-widget-content">
                <td class="ui-state-default"><?php echo $row['name'] ?></td>
                <td><?php echo $row['description'] ?></td>
                <td><?php echo qw_jquery_operation_button($url->createUrl($set, array('controller' => 'Config', 'action' => 'Render', 'groupId' => $row['unique'])), $lang->t('LBL_ACTION_EDIT'), 'ui-icon-tag') ?></td>
            </tr>
            <?php
            endforeach;
            ?>
        </table>
</div>