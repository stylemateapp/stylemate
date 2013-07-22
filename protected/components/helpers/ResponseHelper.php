<?php

/**
 * Class for helpers related to sending response to client
 *
 * This is helpful for responses to API requests
 *
 * They could used anyway in the site
 *
 * @author    Smirnov Egor <egorsmir@gmail.com>
 * @link      http://lastdayz.ru
 * @copyright Copyright &copy; 2013 Smirnov Egor aka LastDay
 *
 */

class ResponseHelper
{
    /**
     * Returns JSON response (by default) with specified HTTP status code(200 by default)
     *
     * @param int          $status       - HTTP status code
     * @param string|array $message      - body of the response (optional)
     * @param string       $content_type - content type of response (optional)
     */

    public static function sendResponse($status = 200, $message = '', $content_type = 'application/json')
    {
        $status_header = 'HTTP/1.1 ' . $status . ' ' . self::getStatusCodeMessage($status);

        header($status_header);
        header('Content-type: ' . $content_type);

        if ($message != '') {

            if(is_array($message)) {

                echo CJSON::encode($message);
            }
            else {

                echo CJSON::encode(array('message' => $message));
            }
        }
        else {

            $message = '';

            switch ($status) {

                case 401:
                    $message = 'You must be authorized to view this page.';
                    break;

                case 404:
                    $message = 'The requested URL ' . $_SERVER['REQUEST_URI'] . ' was not found.';
                    break;

                case 500:
                    $message = 'The server encountered an error processing your request.';
                    break;

                case 501:
                    $message = 'The requested method is not implemented.';
                    break;
            }

            echo CJSON::encode(array('message' => $message));
        }

        Yii::app()->end();
    }

    /**
     * Returning text for HTTP status
     *
     * @param $status - HTTP status code
     *
     * @return int string
     */

    public static function getStatusCodeMessage($status)
    {
        $codes = array(
            200 => 'OK',
            400 => 'Bad Request',
            401 => 'Unauthorized',
            402 => 'Payment Required',
            403 => 'Forbidden',
            404 => 'Not Found',
            500 => 'Internal Server Error',
            501 => 'Not Implemented',
        );

        return (isset($codes[$status])) ? $codes[$status] : '';
    }

    /**
     * Returns request data passed with POST / PUT request
     *
     * @return mixed
     */

    public static function getRequestData()
    {
    	return CJSON::decode(@file_get_contents('php://input'));
    }
}