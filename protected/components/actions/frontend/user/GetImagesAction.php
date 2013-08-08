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
        $this->retrieveOccasion();
        $this->retrieveTemperatureRange();

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

        shuffle($images);

        if (!empty($images)) {

            ResponseHelper::sendResponse(
                200,
                array('success' => true, 'images' => $images)
            );

        } else {

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
        $temperature = Yii::app()->request->getParam('temperature');
        $date        = (int) Yii::app()->request->getParam('date');

        // We could use 'Atlanta' or 'New York' for example as temperature values (instead of numbers)

        if (is_string($temperature) && ($date >= 1 && $date <= 7)) {

            $coordinates = GeoLocationHelper::getCoordinatesByAddress($temperature);

            if ($coordinates['latitude'] == 0 && $coordinates['longitude'] == 0) {

                $this->temperatureRange = -1;
                return;
            }

            $temperature = $this->retrieveWeatherForSelectedDay($coordinates['latitude'], $coordinates['longitude'], $date);

        } elseif (is_numeric($temperature)) {

            $temperature = (int)Yii::app()->request->getParam('temperature');
        }

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
     * Tried to query for temperature in specified geo pointer for specified day (1 = today, 7 = (today + 6 days))
     *
     * @param float $latitude
     * @param float $longitude
     * @param int $day
     *
     * @return int
     */

    protected function retrieveWeatherForSelectedDay($latitude, $longitude, $day)
    {
        $api_key = '543b19476c6de1a7691e76224c09b6a8';

        $forecast = new WeatherHelper($api_key);

        return $this->calculateTemperatureForCloseDay($forecast->getForecastForDay($day, $latitude, $longitude));
    }

    /**
     * Tries to return temperature for day or next day based on occasion
     *
     * If occasion is nighttime, calculates average temperature for today or next day nighttime
     *
     * If occasion is daytime, calculates average temperature for today or next day daytime
     *
     * @param $conditions
     *
     * @return int
     */

    protected function calculateTemperatureForCloseDay($conditions)
    {
        $temperature = 0;
        $count       = 0;

        if($this->isOccasionNightTime()) {

            foreach ($conditions as $condition) {

                $time = $condition->getTime('H');

                if ($this->isNightTime($time)) {

                    $temperature += $condition->getTemperature();
                    $count++;
                }
            }
        } else {

            foreach ($conditions as $condition) {

                $time = $condition->getTime('H');

                if(!$this->isNightTime($time)) {

                    $temperature += $condition->getTemperature();
                    $count++;
                }
            }
        }

        return round($temperature / $count);
    }

    /**
     *
     */

    protected function retrieveOccasion()
    {
        $this->occasion = (int) Yii::app()->request->getParam('occasion');
    }

    /**
     * @return bool
     */

    protected function isOccasionNightTime()
    {
        $occasionName = Category::model()->findByPk($this->occasion)->name;

        if(!empty($occasionName)) {

            switch ($occasionName) {

                case $occasionName == 'Date' || $occasionName == 'Night Out' || $occasionName == 'Special Occasion':

                    return true;
                    break;

                case $occasionName == 'Vacation' || $occasionName == 'Business' || $occasionName == 'Weekend':

                    return false;
                    break;
            }
        }

        return false;
    }

    /**
     * @param int $hour
     *
     * @return bool
     */

    protected function isNightTime($hour)
    {
        if(($hour >= 21 && $hour > 12) || ($hour <= 5 && $hour >= 0)) return true;
        else return false;
    }
}