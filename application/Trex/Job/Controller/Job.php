<?php
/**
 * Job
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
 * @package     Trex
 * @subpackage  Job
 * @author      Twin Huang <twinh@yahoo.cn>
 * @copyright   Twin Huang
 * @license     http://www.opensource.org/licenses/apache2.0.php Apache License
 * @version     $Id$
 * @since       2010-07-18 10:19:53
 */

class Trex_Job_Controller_Job extends Trex_ActionController
{
    public function convertListSalary($value, $name, $row, $copyRow)
    {
        if(0 == $copyRow['salary_from'] && 0 == $copyRow['salary_to'])
        {
            return $this->_lang->t('LBL_SALARY_NEGOTIABLE');
        }
        return $copyRow['salary_from'] . '-' . $copyRow['salary_to'];
    }

    public function convertViewSalary($value, $name, $row, $copyRow)
    {
        if(0 == $copyRow['salary_from'] && 0 == $copyRow['salary_to'])
        {
            return $this->_lang->t('LBL_SALARY_NEGOTIABLE');
        }
        return $copyRow['salary_from'] . '-' . $copyRow['salary_to'];
    }

    public function convertListNumber($value, $name, $row, $copyRow)
    {
        if(0 == $value)
        {
            return $this->_lang->t('LBL_NUMBER_SEVERAL');
        }
        return $value;
    }

    public function convertEditRelatedId($value, $name, $data, $copyData)
    {
        if(null != $value)
        {
            $company = $this->metaHelper->getDoctrineQuery(array(
                'namespace' => 'Trex',
                'module' => 'Company',
                'controller' => 'Company',
            ), false)->where('id = ?', $value)->fetchOne();
            $this->_meta['field']->set('related_id.form._value2', $company['name']);
        }
        return $value;
    }

    public function convertDbDescription($value, $name, $data, $copyData)
    {
        return nl2br($value);
    }

    public function convertEditDescription($value, $name, $data, $copyData)
    {
        return str_replace('<br />', '', $value);
    }
}
