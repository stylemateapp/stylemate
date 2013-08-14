<?php

    /**
     * This is the model class for table "location".
     *
     * The followings are the available columns in table 'clothing_type':
     * @property string       $id
     * @property string       $name
     * @property int          $user_id
     *
     * The followings are the available model relations:
     * @property User $user
     *
     * @method Location findByPk
     * @method Location findByAttributes
     */

    class Location extends BaseModel
    {
        /**
         * Returns the static model of the specified AR class.
         *
         * @param string $className active record class name.
         *
         * @return Location the static model class
         */

        public static function model($className = __CLASS__)
        {
            return parent::model($className);
        }

        /**
         * @return string the associated database table name
         */

        public function tableName()
        {
            return 'location';
        }

        /**
         * @return array validation rules for model attributes.
         */

        public function rules()
        {
            return array(
                array('name, user_id', 'required'),
                array('name', 'length', 'max' => 100),
            );
        }

        /**
         * @return array relational rules.
         */

        public function relations()
        {
            return array(
                'user' => array(self::BELONGS_TO, 'User', 'user_id'),
            );
        }
    }