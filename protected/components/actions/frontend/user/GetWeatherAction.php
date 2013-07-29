<?php
/**
 * Controller class action for retrieving weather for specified latitude / longitude
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

class GetWeatherAction extends Action
{
    /**
     * Main action method
     */

    public function run()
    {
        $api_key = '543b19476c6de1a7691e76224c09b6a8';

        $API_ENDPOINT = 'https://api.forecast.io/forecast/';
        $url          = $API_ENDPOINT . $api_key . '/';

        if (!isset($_GET['url'])) {

            die();
        }

        $url = $url . urldecode($_GET['url']);
        $url = file_get_contents($url);

        print_r($url);
    }
}