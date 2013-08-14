<?php

/**
 * Class for geoLocation-related helper functions
 *
 * @author    Smirnov Egor <egorsmir@gmail.com>
 * @link      http://lastdayz.ru
 * @copyright Copyright &copy; 2013 Smirnov Egor aka LastDay
 *
 */

class GeoLocationHelper
{
    /**
     * @param $address
     *
     * @return array
     */

    public static function getCoordinatesByAddress($address)
    {
        $address = str_replace(' ', '+', $address);
        $url     = 'http://maps.googleapis.com/maps/api/geocode/json?address=' . $address . '&sensor=false';
        $data    = self::sendRequest($url);

        if ($data) {

            $data    = json_decode($data);
            $status = $data->status;

            if ($status == 'OK') {

                if(!empty($data->results[0]->geometry->location->lat) && !empty($data->results[0]->geometry->location->lng)) {

                    return array(
                        'latitude'  => $data->results[0]->geometry->location->lat,
                        'longitude' => $data->results[0]->geometry->location->lng
                    );
                }
            }
        }

        return array('latitude' => 0, 'longitude' => 0);
    }

    /**
     * @param float $latitude
     * @param float $longitude
     *
     * @return string
     */

    public static function getAddressByCoordinates($latitude, $longitude)
    {
        $url     = 'http://maps.googleapis.com/maps/api/geocode/json?latlng=' . $latitude . ',' . $longitude . '&sensor=false&language=en';
        $data    = self::sendRequest($url);

        if ($data) {

            $data   = json_decode($data);
            $status = $data->status;

            if ($status == 'OK') {

                if (!empty($data->results[0]->address_components)) {

                    foreach ($data->results[0]->address_components as $component) {

                        foreach ($component->types as $type) {

                            if ($type == 'locality') {

                                return $component->long_name;
                            }
                        }
                    }
                }
            }
        }

        return '';
    }

    /**
     * @param $url
     *
     * @return mixed
     */

    private function sendRequest($url)
    {
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_URL, $url);

        $response = curl_exec($ch);

        curl_close($ch);

        if ($response != false) {

            return $response;
        }
    }
}