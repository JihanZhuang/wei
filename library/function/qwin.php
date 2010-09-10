<?php
/**
 * qwin
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
 * @subpackage  Function
 * @author      Twin Huang <twinh@yahoo.cn>
 * @copyright   Twin Huang
 * @license     http://www.opensource.org/licenses/apache2.0.php Apache License
 * @version     $Id$
 * @since       2010-08-18 10:28:04
 */

function p($a)
{
    echo '<p><pre>';
    qw('Qwin_Debug')->p($a);
    echo '</pre><p>';
}

function e($msg = '')
{
    qw('Qwin_Debug')->e($msg);
}

/**
 * 快速加载类
 *
 * @return obejct|null
 */
function qw($class, $param = null)
{
    return Qwin::run($class, $param);
}

/**
 * 快速加载类
 *
 * @param string $name
 * @return object|null
 */
function qwin($name)
{
    return Qwin::run($name);
}

function qw_form($param, $param2 = null)
{
    static $form;
    null == $form && $form = Qwin::run('Qwin_Form');
    return $form->render($param, $param2);
}

function qw_widget($param, $param2 = null)
{
    static $widget;
    null == $widget && $widget = Qwin::run('Qwin_Widget');
    return $widget->render($param, $param2);
}

function qw_url($array1 = null, $array2 = null)
{
    static $url;
    null == $url && $url = Qwin::run('-url');
    null == $array1 && $array1 = Qwin::run('-ini')->getSet();
    return $url->createUrl($array1, $array2);

}

function qw_lang($name = null)
{
    static $lang;
    null == $lang && $lang = Qwin::run('-lang');
    return $lang->t($name);
}

function qw_lang_to_js()
{
    return 'Qwin.Lang = ' . Qwin::run('-arr')->toJsObject(Qwin::run('-lang')->toArray()) . ';';
}

function qw_null_text($data = null)
{
    if(null != $data)
    {
        return $data;
    }
    return '<em>(null)</em>';
}

function qw_jquery()
{
    static $jquery;
    if(null == $jquery)
    {
        Qwin::addMap('-jquery', 'Qwin_Resource_JQuery');
        $jquery = Qwin::run('-jquery')
            ->setVersion('1.4.2')
            ->setUiVersion('1.8.4');
    }
    return $jquery;
}

function qw_referer_page($page = null)
{
    !isset($_SERVER['HTTP_REFERER']) && $_SERVER['HTTP_REFERER'] = $page;
    return urlencode($_SERVER['HTTP_REFERER']);
}

function qw_title_decorator($title, $fontStyle = null, $color = null)
{
    return Qwin_Helper_Html::titleDecorator($title, $fontStyle, $color);
}