<?php

    /**
     * This is the model class for table "category_group".
     *
     * The followings are the available columns in table 'category_group':
     * @property string     $id
     * @property string     $name
     *
     * The followings are the available model relations:
     * @property Category[] $categories
     */

    class CategoryGroup extends BaseModel
    {
        /**
         * Returns the static model of the specified AR class.
         *
         * @param string $className active record class name.
         *
         * @return CategoryGroup the static model class
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
            return 'category_group';
        }

        /**
         * @return array validation rules for model attributes.
         */

        public function rules()
        {
            return array(
                array('name', 'required'),
                array('name', 'length', 'max' => 45),
                array('id, name', 'safe', 'on' => 'search'),
            );
        }

        /**
         * @return array relational rules.
         */

        public function relations()
        {
            return array(
                'categories' => array(self::HAS_MANY, 'Category', 'category_group_id'),
            );
        }

        /**
         * @return array customized attribute labels (name=>label)
         */

        public function attributeLabels()
        {
            return array(
                'id'   => 'ID',
                'name' => 'Name',
            );
        }

        /**
         * Retrieves a list of models based on the current search/filter conditions.
         * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
         */

        public function search()
        {
            $criteria = new CDbCriteria;

            $criteria->compare('id', $this->id, true);
            $criteria->compare('name', $this->name, true);

            return new CActiveDataProvider($this,
                array(
                     'criteria' => $criteria,
                )
            );
        }

        /**
         * @return array
         */

        public static function getListData()
        {
            return CHtml::listData(
                CategoryGroup::model()->orderByName()->findAll(),
                'id',
                'name'
            );
        }
    }