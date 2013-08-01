<?php
/**
 * Controller class action for retrieving of  through web API
 *
 * Used in AngularJS application
 *
 * In order to use this action user should be already authenticated (this fact is ensured using ApiRequestFilter)
 *
 * @author    Smirnov Egor <egorsmir@gmail.com>
 * @link      http://lastdayz.ru
 * @copyright Copyright &copy; 2013 Smirnov Egor aka LastDay
 *
 * @property Controller $controller
 */

class GetImagesAction extends Action
{
    protected $styles;
    protected $temperatureRange;
    protected $occasion;

    /**
     * Main action method
     */

    public function run()
    {
        $this->retrieveStyles();
        $this->retrieveTemperatureRange();
        $this->retrieveOccasion();

        /**
         * Filtering by temperature Range
         */

        $criteria = new CDbCriteria();
        $criteria->with = array('categories');
        $criteria->condition = 'categories.id = ' . $this->temperatureRange;

        $images = Image::model()->findAll($criteria);

        /**
         * Filtering by occasion
         */

        foreach($images as $key => $image) {

            $occasions = CommonHelper::activeRecordToArray($image->categoriesOccasion);

            if(!isset($occasions[$this->occasion])) {

                unset($images[$key]);
            }
        }

        /**
         * Filtering by style
         */

        foreach($images as $key => $image) {

            $found = false;
            $styles = CommonHelper::activeRecordToArray($image->categoriesStyle);

            foreach ($styles as $style) {

                $styleId = $style['id'];

                if(isset($this->styles[$styleId])) {

                    $found = true;
                    break;
                }
            }

            if(!$found) {

                unset($images[$key]);
            }
        }

        /**
         * Quite ugly code for structuring nice image field arrays, should be fixed at some moment
         */

        $imageFields = array();

        foreach($images as $image) {

            $imageFields[$image->id] = CommonHelper::activeRecordToArray($image->imageFields);
        }

        $newImageFields = array();

        foreach($imageFields as $key => $imageField) {

            foreach($imageField as $item) {

                $clothingType = ClothingType::model()->findByPk($item['clothing_type'])->name;

                if (!isset($newImageFields[$key][$clothingType])) {

                    $newImageFields[$key][$clothingType] = array();
                }

                $newImageFields[$key][$clothingType][] =
                    array(
                        'reference_url'   => $item['reference_url'],
                        'reference_image' => $item['reference_image']
                    );
            }
        }

        /**
         * Convert images models to array
         */

        $images = CommonHelper::activeRecordToArray($images);

        foreach($images as $key => $image) {

            if(isset($newImageFields[$key])) {

                $images[$key]['items'] = $newImageFields[$key];
            }
        }

        if(!empty($images)) {

            ResponseHelper::sendResponse(
                200,
                array('success' => true, 'images' => $images)
            );
        }
        else {

            ResponseHelper::sendResponse(
                400,
                array('success' => false, 'errorMessage' => 'Nothing found according to your search criteria :(')
            );
        }
    }

    /**
     *
     */

    protected function retrieveStyles()
    {
        $user = User::model()->findByPk(Yii::app()->user->id);

        $this->styles = CommonHelper::activeRecordToArray($user->userStyles);
    }

    /**
     *
     */

    protected function retrieveTemperatureRange()
    {
        $temperature = (int) Yii::app()->request->getParam('temperature');

        switch($temperature) {

            case $temperature < 40:

                $this->temperatureRange = Category::model()->findByAttributes(array('name' => 'under 40'))->id;
                break;

            case $temperature >= 40 && $temperature < 60:

                $this->temperatureRange = Category::model()->findByAttributes(array('name' => '40-60'))->id;
                break;

            case $temperature >= 60 && $temperature < 75:

                $this->temperatureRange = Category::model()->findByAttributes(array('name' => '60-75'))->id;
                break;

            case $temperature >= 75 && $temperature < 90:

                $this->temperatureRange = Category::model()->findByAttributes(array('name' => '75-90'))->id;
                break;

            case $temperature >= 90:

                $this->temperatureRange = Category::model()->findByAttributes(array('name' => '90 and up'))->id;
                break;
        }
    }

    /**
     *
     */

    protected function retrieveOccasion()
    {
        $this->occasion = (int) Yii::app()->request->getParam('occasion');
    }
}