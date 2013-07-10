<?php

/**
 * Cache helper for better using of YII cache
 *
 * @author Smirnov Egor <egorsmir@gmail.com>
 * @link http://lastdayz.ru
 * @copyright Copyright &copy; 2011-2012 Smirnov Egor aka LastDay
 */

class Cache
{

    /**
     * Method that returns cached value of variable that is returned from file path
     *
     * @static
     *
     * @param string $id - key for cached variable (eg, 'params.skills')
     * @param string $filePath - path to file that returns needed variable
     *
     * @return mixed
     */

    public static function retrieveFromFile($id, $filePath)
    {
        $timing = Yii::app()->params['cacheTimings']['default'];

        if(isset(Yii::app()->params['cacheTimings'][$id]))
        {
            $timing = Yii::app()->params['cacheTimings'][$id];
        }

        $value = Yii::app()->cache->get($id);

        if($value === false)
        {
            Yii::app()->cache->set($id, require($filePath), $timing);
            $value = Yii::app()->cache->get($id);
        }

        return $value;
    }
}