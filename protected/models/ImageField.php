<?php

    /**
     * This is the model class for table "image_field".
     *
     * The followings are the available columns in table 'image_field':
     * @property string       $id
     * @property string       $image_id
     * @property string       $clothing_type
     * @property string       $reference_url
     * @property string       $reference_image
     *
     * The followings are the available model relations:
     * @property ClothingType $clothingType
     * @property Image        $image
     */

    class ImageField extends BaseModel
    {
        /**
         * Returns the static model of the specified AR class.
         *
         * @param string $className active record class name.
         *
         * @return ImageField the static model class
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
            return 'image_field';
        }

        /**
         * @return array validation rules for model attributes.
         */

        public function rules()
        {
            return array(
                array('image_id, clothing_type, reference_url, reference_image', 'required'),
                array('image_id, clothing_type', 'length', 'max' => 11),
                array('reference_url, reference_image', 'length', 'max' => 255),
                array('id, image_id, clothing_type, reference_url, reference_image', 'safe', 'on' => 'search'),
            );
        }

        /**
         * @return array relational rules.
         */

        public function relations()
        {
            return array(
                'clothingType' => array(self::BELONGS_TO, 'ClothingType', 'clothing_type'),
                'image'        => array(self::BELONGS_TO, 'Image', 'image_id'),
            );
        }

        /**
         * @return array customized attribute labels (name=>label)
         */

        public function attributeLabels()
        {
            return array(
                'id'              => 'ID',
                'image_id'        => 'Image',
                'clothing_type'   => 'Clothing Type',
                'reference_url'   => 'Reference Url',
                'reference_image' => 'Reference Image',
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
            $criteria->compare('image_id', $this->image_id, true);
            $criteria->compare('clothing_type', $this->clothing_type, true);
            $criteria->compare('reference_url', $this->reference_url, true);
            $criteria->compare('reference_image', $this->reference_image, true);

            return new CActiveDataProvider($this,
                array(
                     'criteria' => $criteria,
                )
            );
        }
    }