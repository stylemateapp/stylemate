<?php

    /**
     * This is the model class for table "image".
     *
     * The followings are the available columns in table 'image':
     * @property string       $id
     * @property string       $name
     * @property string       $title
     * @property string       $url
     * @property string       $imageUrl
     * @property string       $categoriesStyleList
     * @property string       $categoriesWeatherList
     * @property string       $categoriesOccasionList
     *
     * The followings are the available model relations:
     * @property Category[]   $categories
     * @property Category[]   $categoriesStyle
     * @property Category[]   $categoriesWeather
     * @property Category[]   $categoriesOccasion
     * @property ImageField[] $imageFields
     *
     * @method Image findByPk
     * @method Image[] findAll
     */

    class Image extends BaseModel
    {
        /**
         * Returns the static model of the specified AR class.
         *
         * @param string $className active record class name.
         *
         * @return Image the static model class
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
            return 'image';
        }

        /**
         * @return array
         */

        public function behaviors()
        {
            return array(
                'CAdvancedArBehavior' => array(
                    'class' => 'application.extensions.CAdvancedArBehavior'
                )
            );
        }

        /**
         * @return array validation rules for model attributes.
         */

        public function rules()
        {
            return array(
                array('name, title, url', 'length', 'max' => 255),
                array('title, url', 'safe'),
                array('id, name', 'safe', 'on' => 'search'),
                array(
                    'name',
                    'file',
                    'types' => 'jpg, gif, png',
                    'maxSize' => 1024 * 1024 * 100,
                    'allowEmpty' => false,
                    'on' => 'insert'
                ),
                array(
                    'name',
                    'file',
                    'types'      => 'jpg, gif, png',
                    'maxSize'    => 1024 * 1024 * 100,
                    'allowEmpty' => true,
                    'on'         => 'update'
                ),
            );
        }

        /**
         * @return array relational rules.
         */

        public function relations()
        {
            return array(
                'categories'         => array(self::MANY_MANY, 'Category', 'image_category(image_id, category_id)'),
                'categoriesStyle' => array(
                    self::MANY_MANY,
                    'Category',
                    'image_category(image_id, category_id)',
                    'condition' => 'categoriesStyle.category_group_id =' . Yii::app()->params['styleGroupId']
                ),
                'categoriesWeather' => array(
                    self::MANY_MANY,
                    'Category',
                    'image_category(image_id, category_id)',
                    'condition' => 'categoriesWeather.category_group_id =' . Yii::app()->params['weatherGroupId']
                ),
                'categoriesOccasion' => array(
                    self::MANY_MANY,
                    'Category',
                    'image_category(image_id, category_id)',
                    'condition' => 'categoriesOccasion.category_group_id =' . Yii::app()->params['occasionGroupId']
                ),
                'imageFields'        => array(self::HAS_MANY, 'ImageField', 'image_id'),
            );
        }

        /**
         * @return array customized attribute labels (name=>label)
         */

        public function attributeLabels()
        {
            return array(
                'id'   => 'ID',
                'name' => 'Image file',
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
         * @return bool
         */

        protected function beforeSave()
        {
            parent::beforeSave();

            if(!empty($_POST['Image']['categories'])) {

                $categoriesArray = array();

                foreach($_POST['Image']['categories'] as $data) {

                    $categories = json_decode($data);

                    foreach($categories as $category) {

                        $categoriesArray[] = $category;
                    }
                }

                $this->categories = $categoriesArray;
            }

            return true;
        }

        /**
         * In this method we update field with image URL
         */

        protected function afterSave()
        {
            parent::afterSave();

            $image        = Image::model()->findByPk($this->id);
            $uploadedFile = CUploadedFile::getInstance($this, 'name');

            if(!empty($uploadedFile)) {

                $nameOfFile = $this->id . '-' . $uploadedFile;

                if ($uploadedFile->saveAs(Yii::getPathOfAlias('webroot') . '/uploads/' . $nameOfFile)) {

                    $image->name = $nameOfFile;
                    $image->save(false);
                }
            }
        }

        /**
         *
         */

        protected function afterDelete()
        {
            parent::afterDelete();

            $physicalPathToImage = Yii::getPathOfAlias('webroot') . '/uploads/' . $this->name;

            if (file_exists($physicalPathToImage)) {

                unlink($physicalPathToImage);
            }
        }

        /**
         * Getter for image file attached to this class instance
         *
         * @return string
         */

        public function getImageUrl()
        {
            $physicalPathToImage = Yii::getPathOfAlias('webroot') . '/uploads/' . $this->name;

            if (file_exists($physicalPathToImage)) {

                return Yii::app()->request->baseUrl . '/uploads/' . $this->name;
            }
            else {

                return '';
            }
        }

        /**
         * Getter for list style categories attached to this class instance
         *
         * @return string
         */

        public function getCategoriesStyleList()
        {
            $categoryArray = array();

            foreach($this->categoriesStyle as $category) {

                $categoryArray[] = $category->name;
            }

            return implode(', ', $categoryArray);
        }

        /**
         * Getter for list weather categories attached to this class instance
         *
         * @return string
         */

        public function getCategoriesWeatherList()
        {
            $categoryArray = array();

            foreach ($this->categoriesWeather as $category) {

                $categoryArray[] = $category->name;
            }

            return implode(', ', $categoryArray);
        }

        /**
         * Getter for list occasion categories attached to this class instance
         *
         * @return string
         */

        public function getCategoriesOccasionList()
        {
            $categoryArray = array();

            foreach ($this->categoriesOccasion as $category) {

                $categoryArray[] = $category->name;
            }

            return implode(', ', $categoryArray);
        }
    }