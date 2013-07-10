<?php
/**
 * Base model class
 *
 * @author Smirnov Egor <egorsmir@gmail.com>
 * @link http://lastdayz.ru
 * @copyright Copyright &copy; 2012 Smirnov Egor aka LastDay
 *
 * @property $autoIncrement
 */

class BaseModel extends CActiveRecord
{
    /**
     * named scope for selection of fields
     *
     * @param $array array of selected fields
     *
     * @return $this
     */

    public function selectBy($array)
    {
        $this->getDbCriteria()->mergeWith(
            array(
                 'select' => $array,
            )
        );

        return $this;
    }

    /**
     * named scope ordering by title field
     *
     * @param string $direction ASC or DESC ordering
     *
     * @return $this
     */

    public function orderByTitle($direction = 'ASC')
    {
        $this->getDbCriteria()->mergeWith(
            array(
                 'order' => 'title ' . $direction,
            )
        );

        return $this;
    }

    /**
     * named scope ordering by name field
     *
     * @param string $direction ASC or DESC ordering
     *
     * @return $this
     */

    public function orderByName($direction = 'ASC')
    {
        $this->getDbCriteria()->mergeWith(
            array(
                 'order' => 'name ' . $direction,
            )
        );

        return $this;
    }

    /**
     * named scope ordering by sort field
     *
     * @param string $direction ASC or DESC ordering
     *
     * @return $this
     */

    public function orderBySort($direction = 'ASC')
    {
        $this->getDbCriteria()->mergeWith(
            array(
                 'order' => 'IF(ISNULL(sort),1,0), sort ' . $direction,
            )
        );

        return $this;
    }

    /**
     * Returning value of current auto_increment value
     *
     * @return string
     */

    public function getAutoIncrement()
    {
        $connection = Yii::app()->db;
        $command    = $connection->createCommand("SHOW TABLE STATUS LIKE '" . get_called_class() . "'");
        $row        = $command->queryRow();
        $nextId     = 'PAM' . $row['Auto_increment'];

        return $nextId;
    }
}