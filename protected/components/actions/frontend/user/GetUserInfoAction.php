<?php
/**
 * Controller class action for retrieving of user information array through web API
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

class GetUserInfoAction extends Action
{
    protected $locations = array();
    protected $styles = array();
    protected $selectedStyles = array();
    protected $occasions = array();

    /**
     * @var User $user
     */

    protected $user;

    /**
     * Main action method
     */

    public function run()
    {
        $this->user = User::model()->findByPk(Yii::app()->user->id);

        $this->retrieveLocations();
        $this->retrieveStyles();
        $this->retrieveOccasions();

        ResponseHelper::sendResponse(
            200,
            array(
                 'success'        => true,
                 'locations'      => $this->locations,
                 'styles'         => $this->styles,
                 'selectedStyles' => $this->selectedStyles,
                 'occasions'      => $this->occasions,
            )
        );
    }

    /**
     *
     */

    protected function retrieveLocations()
    {
        if (!empty($this->user->defaultLocation->name)) {

            $coordinates = GeoLocationHelper::getCoordinatesByAddress($this->user->defaultLocation->name);

            $defaultLocation = array(
                'name'      => $this->user->defaultLocation->name,
                'latitude'  => $coordinates['latitude'],
                'longitude' => $coordinates['longitude'],
            );

            $otherLocations = array();

            foreach ($this->user->otherLocations as $location) {

                $coordinates = GeoLocationHelper::getCoordinatesByAddress($location->name);

                $arr = array(
                    'name'      => $location->name,
                    'latitude'  => $coordinates['latitude'],
                    'longitude' => $coordinates['longitude'],
                );

                $otherLocations[] = $arr;
            }

            $this->locations = array(
                'default'        => $defaultLocation,
                'otherLocations' => $otherLocations
            );

        }
    }

    /**
     *
     */

    protected function retrieveStyles()
    {
        $styles = CommonHelper::activeRecordToArray(
            Category::getCategoriesByGroup(Yii::app()->params['styleGroupId'])
        );

        $userStyles   = CommonHelper::activeRecordToArray($this->user->userStyles);

        $selectedStyles = array();

        foreach ($styles as $key => $style) {

            $found = false;

            foreach ($userStyles as $userStyle) {

                if ($userStyle['id'] == $style['id']) {

                    $found = true;
                    $selectedStyles[] = $style['id'];
                    break;
                }
            }

            if ($found) {

                $styles[$key]['selected'] = 'selected';

            } else {

                $styles[$key]['selected'] = '';
            }
        }

        $this->styles = $styles;
        $this->selectedStyles = $selectedStyles;
    }

    /**
     *
     */

    protected function retrieveOccasions()
    {
        $occasions = CommonHelper::activeRecordToArray(Category::getCategoriesByGroup(Yii::app()->params['occasionGroupId']));

        $this->occasions = $occasions;
    }
}