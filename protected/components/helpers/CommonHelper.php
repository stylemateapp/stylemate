<?php

/**
 * Class for common small helper methods
 *
 * They could used anyway in the site
 *
 * @author    Smirnov Egor <egorsmir@gmail.com>
 * @link      http://lastdayz.ru
 * @copyright Copyright &copy; 2012 Smirnov Egor aka LastDay
 *
 */

class CommonHelper
{

    /**
     * Utility function for represenating dates in views
     *
     * @param string $timestamp - timestamp of needed date
     *
     * @return string date
     */

    public static function date($timestamp)
    {
        if ($timestamp === '0000-00-00')
        {
            return Yii::t('jobroom', 'N/A');
        }

        return CHtml::encode(Yii::app()->dateFormatter->format('d MMMM yyyy', $timestamp));
    }

    /**
     * Utility function for representing dates in views
     *
     * @static
     *
     * @param $timestamp
     *
     * @return string
     *
     * @codeCoverageIgnore
     */
    public static function dateShort($timestamp)
    {
        if ($timestamp === '0000-00-00')
        {
            return Yii::t('jobroom', 'N/A');
        }

        $time = (Yii::app()->dateFormatter->format('dd/MM/yyyy', $timestamp) == date('dd/MM/yyyy')) ?
            Yii::app()->dateFormatter->format('hh:mm', $timestamp) :
            Yii::app()->dateFormatter->format('dd/MM/yyyy', $timestamp);

        return CHtml::encode($time);
    }

    /**
     * Utility function for represnting dates in views
     *
     * @param string $timestamp - timestamp of needed date
     *
     * @return string date
     */

    public static function dateFull($timestamp)
    {
        if ($timestamp === '0000-00-00')
        {
            return Yii::t('jobroom', 'N/A');
        }

        return CHtml::encode(Yii::app()->dateFormatter->format('MMMM d, yyyy HH:mm', $timestamp));
    }

    /**
     * Helper method that is shortcut for raising events for model
     *
     * @static
     *
     * @param CActiveRecord $model
     * @param string $eventName
     *
     */
    public static function runEventHandlers($model, $eventName)
    {
        $event = new CModelEvent($model);
        EventDispatcher::getInstance()->{$eventName}($event);
    }

    /**
     * Method that returns new CHtmlPurifier instance (useful in models)
     *
     * @static
     * @return CHtmlPurifier $htmlpurifier
     */

    public static function htmlPurifyInstance()
    {
        $htmlpurifier = new CHtmlPurifier();

        $htmlpurifier->options = array(
            'HTML.Allowed' => 'div, p, pre, strong, em, h1, h2, h3, h4, h5, h6, ul, ol, li, strike, s, span[style], br'
        );

        return $htmlpurifier;
    }

    /**
     * Method for converting Active Record to flat array.
     *
     * If primary key is not 'id' you should specify this primary key as a parameter
     *
     * @static
     *
     * @param array|CActiveRecord  $model
     * @param string $primaryKey
     *
     * @return array
     */

    public static function activeRecordToArray($model, $primaryKey = 'id')
    {
        if(!is_array($model))
        {
            return $model->attributes;
        }

        $arr = array();

        foreach($model as $m)
        {
            $arr[$m->{$primaryKey}] = $m->attributes;
        }

        return $arr;
    }

    /**
     * Helper method that renders view for 2 cases - typical call or AJAX call
     *
     * @static
     *
     * @param string $view - view name
     * @param array  $data - data sent to view
     * @param boolean $attachJavaScriptFiles - whether to load attached JS files or not, by default - false
     *
     * @codeCoverageIgnore
     */
    public static function renderView($view, $data = array(), $attachJavaScriptFiles = false)
    {
        if(Yii::app()->request->isAjaxRequest)
        {
            if($attachJavaScriptFiles)
            {
                Yii::app()->clientScript->scriptMap['jquery.js']               = false;
                Yii::app()->clientScript->scriptMap['jquery.min.js']           = false;
                Yii::app()->clientScript->scriptMap['jquery.yiiactiveform.js'] = false;

                Yii::app()->controller->renderPartial($view, $data + array('isAjax' => true), false, true);
            }
            else
            {
                Yii::app()->clientScript->scriptMap['*.js'] = false;

                Yii::app()->controller->renderPartial($view, $data + array('isAjax' => true), false, true);
            }
        }
        else
        {
            Yii::app()->controller->render($view, $data + array('isAjax' => false));
        }
    }

    /**
     * Helper that converts needed $_POST variable to array tht could be used in AJAX query
     *
     * @static
     *
     * @param string $postVar
     * @return string
     *
     * @codeCoverageIgnore
     */
    public static function postVariableToJavaScript($postVar)
    {
        return http_build_query(array($postVar => Yii::app()->request->getPost($postVar)));
    }

    /**
     * Function that is useful in situations when we are going to send variables from view to sub-view (from parent to children view)
     *
     * @static
     *
     * @param array $vars - we have to use this param as get_defined_vars has different contexts for different files / classes etc.
     *
     * @return array
     *
     * @codeCoverageIgnore
     */
    public static function variablesFromCurrentView($vars)
    {
        return $vars['_data_'];
    }

    /**
     * @param string $index
     * @param mixed $value
     */

    public static function addToSession($index, $value)
    {
        $tmp                        = Yii::app()->session[$index];
        $tmp[]                      = $value;
        Yii::app()->session[$index] = $tmp;
    }

    /**
     * @param int $sessionIndex
     * @param int $index
     * @param mixed $value
     */

    public static function updateSession($sessionIndex, $index, $value)
    {
        $tmp                               = Yii::app()->session[$sessionIndex];
        $tmp[$index]                       = $value;
        Yii::app()->session[$sessionIndex] = $tmp;
    }

    /**
     * @param int   $sessionIndex
     * @param int   $index
     */

    public static function deleteSession($sessionIndex, $index)
    {

        $tmp = Yii::app()->session[$sessionIndex];

        if(isset($tmp[$index]))
        {
            unset($tmp[$index]);
            Yii::app()->session[$sessionIndex] = $tmp;
        }
    }

    /**
     * Wrapper for transactional operations
     *
     * @param callable $func
     */

    public static function doDbTransaction(Closure $func)
    {
        $transaction = Yii::app()->db->beginTransaction();

        try
        {
            $func();
            $transaction->commit();
        }
        catch(Exception $e)
        {
            $transaction->rollback();
        }
    }

    /**
     * PHP pathinfo() function works bad with UTF-characters
     *
     * Code snippet from http://php.net/manual/ru/function.pathinfo.php
     *
     * @static
     *
     * @param string $filepath
     *
     * @return array
     */

    public static function pathinfo_utf8($filepath)
    {
        $ret = array();

        preg_match('%^(.*?)[\\\\/]*(([^/\\\\]*?)(\.([^\.\\\\/]+?)|))[\\\\/\.]*$%im', $filepath, $m);

        if($m[1])
        {
            $ret['dirname'] = $m[1];
        }
        if($m[2])
        {
            $ret['basename'] = $m[2];
        }
        if($m[5])
        {
            $ret['extension'] = $m[5];
        }
        if($m[3])
        {
            $ret['filename'] = $m[3];
        }
        return $ret;
    }
}