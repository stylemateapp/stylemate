<?php

    /**
     * This is the model class for table "category".
     *
     * The followings are the available columns in table 'category':
     * @property string        $id
     * @property string        $name
     * @property string        $category_group_id
     *
     * The followings are the available model relations:
     * @property CategoryGroup $categoryGroup
     * @property Image[]       $images
     * @property User[]        $users
     *
     * @method Category findByAttributes
     */

    class Category extends BaseModel
    {
        /**
         * Returns the static model of the specified AR class.
         *
         * @param string $className active record class name.
         *
         * @return Category the static model class
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
            return 'category';
        }

        /**
         * @return array validation rules for model attributes.
         */

        public function rules()
        {
            return array(
                array('name, category_group_id', 'required'),
                array('name', 'length', 'max' => 45, 'min' => 3),
                array('category_group_id', 'length', 'max' => 11),
                array('id, name, category_group_id', 'safe', 'on' => 'search'),
            );
        }

        /**
         * @return array relational rules.
         */
        public function relations()
        {
            return array(
                'categoryGroup' => array(self::BELONGS_TO, 'CategoryGroup', 'category_group_id'),
                'images'        => array(self::MANY_MANY, 'Image', 'image_category(category_id, image_id)'),
                'users'         => array(self::MANY_MANY, 'User', 'user_style(category_id, user_id)'),
            );
        }

        /**
         * @return array customized attribute labels (name=>label)
         */

        public function attributeLabels()
        {
            return array(
                'id'                => 'ID',
                'name'              => 'Category Name',
                'category_group_id' => 'Category Group',
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
            $criteria->compare('category_group_id', $this->category_group_id, true);

            return new CActiveDataProvider($this,
                array(
                     'criteria' => $criteria,
                )
            );
        }

        /**
         * Returns array with all categories with concrete category group
         *
         * @param null|int $categoryGroup - number of category group we want to retrieve
         *
         * @return array
         */

        public static function getCategoriesByGroup($categoryGroup = null)
        {
            if (is_int($categoryGroup)) {

                return Category::model()->orderByName()->findAllByAttributes(
                    array('category_group_id' => $categoryGroup)
                );
            } else {

                return Category::model()->orderByName()->findAll();
            }
        }
    }