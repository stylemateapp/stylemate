<?php
/**
 * Controller is the customized base controller class.
 * All controller classes for this application should extend from this base class.
 */
class Controller extends CController
{

	/***
	 * @var string the default layout for the controller view. Defaults to '//layouts/column1',
	 * meaning using a single column layout. See 'protected/views/layouts/column1.php'.
	 */

	public $layout = '//layouts/main';

	/**
	 * @var array context menu items. This property will be assigned to {@link CMenu::items}.
	 */

	public $menu = array();

	/**
	 * @var array the breadcrumbs of the current page. The value of this property will
	 * be assigned to {@link CBreadcrumbs::links}. Please refer to {@link CBreadcrumbs::links}
	 * for more details on how to specify this property.
	 */

	public $breadcrumbs = array();
    public $isOwner = false;
    public $partial = false;

    /**
     * Controller init function
     */

    public function init()
    {
        if(!is_null(Yii::app()->request->getParam('partial')))
        {
            $this->partial = true;
        }

        if(!is_null(Yii::app()->request->getParam('noHeaderFooter')))
        {
            $this->layout = 'noHeaderFooter';
        }

        parent::init();
    }

    /**
     * Re-define of standard controller render() method for case of $_GET['partial']
     *
     * @param string $view
     * @param null   $data
     * @param bool   $return
     *
     * @return string|void
     */

    public function render($view, $data=null, $return=false)
    {
        if($this->partial)
        {
            $this->renderPartial($view, $data, $return);
        }
        else
        {
            parent::render($view, $data, $return);
        }
    }

    /**
     * Shortcut for setting YII Flash Message of Notice level
     *
     * @param $message
     *
     * @return mixed
     */

    public function setNotice($message)
    {
        return Yii::app()->user->setFlash('notice', $message);
    }

    /**
     * Shortcut for setting YII Flash Message of Error level
     *
     * @param $message
     */

    public function setError($message)
    {
        Yii::app()->user->setFlash('error', $message);
    }

    /**
     * Shortcut for setting YII Flash Message of Warning level
     *
     * @param $message
     */

    public function setWarning($message)
    {
        Yii::app()->user->setFlash('warning', $message);
    }

    /**
     * Shortcut for printing all available flashes
     */

    public function printAllFlashes()
    {
        foreach(Yii::app()->user->getFlashes() as $severity => $message)
        {
            $this->renderPartial(
                '/shared/flashes/' . $severity,
                array(
                    'message' => $message,
                )
            );
        }
    }

    /**
     * Shortcut for deleting all the flashes
     */

    public function clearAllFlashes()
    {
        foreach(Yii::app()->user->getFlashes() as $severity => $message)
        {
            Yii::app()->user->setFlash($severity, null);
        }
    }

    /**
     * Shortcut for sending email
     *
     * @param       $to
     * @param       $subject
     * @param       $view
     * @param array $viewVars
     *
     * @return bool
     */

    public function sendEmail($to, $subject, $view, $viewVars = array())
    {
        $email           = Yii::app()->email;
        $email->from     = Yii::app()->params['emailSender'];
        $email->to       = $to;
        $email->subject  = $subject;
        $email->view     = $view;
        $email->viewVars = $viewVars;

        if($email->send())
        {
            return true;
        }
        else
        {
            return false;
        }
    }

    /**
     * Redirects the browser to the specified URL or route (controller/action).
     *
     * @param mixed   $url        the URL to be redirected to. If the parameter is an array,
     *                            the first element must be a route to a controller action and the rest
     *                            are GET parameters in name-value pairs.
     * @param boolean $terminate  whether to terminate the current application after calling this method
     * @param integer $statusCode the HTTP status code. Defaults to 302. See {@link http://www.w3.org/Protocols/rfc2616/rfc2616-sec10.html}
     *                            for details about HTTP status code.
     */

    public function redirect($url, $terminate = true, $statusCode = 302)
    {
        if(is_array($url))
        {
            $route = isset($url[0]) ? $url[0] : '';
            $url   = $this->createUrl($route, array_splice($url, 1));
        }

        if(Yii::app()->getRequest()->getIsAjaxRequest())
        {
            echo '<script type="text/javascript">location.href="' . $url . '";</script>';
            exit;
        }
        else
        {
            Yii::app()->getRequest()->redirect($url, $terminate, $statusCode);
        }
    }

    /**
     * Throwing an error in case of AJAX request or exception in case of ordinary request
     *
     * @param $status
     * @param $message
     *
     * @throws CHttpException
     */

    public function throwException($status, $message)
    {
        if(Yii::app()->request->isAjaxRequest)
        {
            echo Yii::t('yii', $message);
            exit;
        }
        else
        {
            throw new CHttpException($status, Yii::t('yii', $message));
        }
    }

    /**
     * This method return true if user have administrator rights
     *
     * @return bool
     */

    public function isAdmin()
    {
        return Yii::app()->user->checkAccess('administrator');
    }

    /**
     * Renders JS files for this controller / action pair if they are defined
     *
     * @param bool $useScriptTag - whether to include JS file contents directly into page or use script tag for it
     */

    public function includeJsForThisPage($useScriptTag = true)
    {
        echo '
        <script type="text/javascript">

            Page = {};

            Page.baseUrl = "' . Yii::app()->request->baseUrl . '/";
            Page.pageUrl = "' . $this->createUrl($this->id . '/' . $this->action->id) . '/";
            Page.loaderImage = "<img src=\"' . Yii::app()->request->baseUrl . '/images/loader-circle.gif\" />";
            Page.userId = ' . Yii::app()->user->id . ';
        </script>
        ';

        $jsPaths = array(
            Yii::getPathOfAlias('webroot') . '/js/' . $this->id . '/controllers.js',
            Yii::getPathOfAlias('webroot') . '/js/' . $this->id . '/directives.js',
            Yii::getPathOfAlias('webroot') . '/js/' . $this->id . '/filters.js',
            Yii::getPathOfAlias('webroot') . '/js/' . $this->id . '/services.js',
            Yii::getPathOfAlias('webroot') . '/js/' . $this->id . '/' . $this->action->id . '.js',
        );

        foreach($jsPaths as $js)
        {
            if(file_exists($js))
            {
                $pathToJs = str_replace(Yii::getPathOfAlias('webroot'), Yii::app()->request->baseUrl, $js);

                if($useScriptTag)
                {
                    echo '<script type="text/javascript" src="' . $pathToJs . '"></script>
                    ';
                }
                else
                {
                    $this->renderPartial($pathToJs);
                }
            }
        }
    }

    /**
     * Performs the AJAX validation (based on Gii standard auto-generated code)
     *
     * @param CModel $model -  model to be validated
     * @param string $postVariable - name of variable from $_POST array that is used to retrieve data for ajax validation
     */

    public function performAjaxValidation($model, $postVariable = '')
    {
        if(empty($postVariable))
        {
            $postVariable = strtolower(get_class($model)) . '-form';
        }

        if(isset($_POST['ajax']) && $_POST['ajax'] === $postVariable)
        {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }
}