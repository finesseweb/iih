<?php

/**
 * Zend Framework
 *
 * LICENSE
 *
 * This source file is subject to the new BSD license that is bundled
 * with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://framework.zend.com/license/new-bsd
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@zend.com so we can send you a copy immediately.
 *
 * @category   Zend
 * @package    Zend_Controller
 * @copyright  Copyright (c) 2005-2012 Zend Technologies USA Inc. (http://www.zend.com)
 * @license    http://framework.zend.com/license/new-bsd     New BSD License
 * @version    $Id: Action.php 24594 2012-01-05 21:27:01Z matthew $
 */
/**
 * @see Zend_Controller_Action_HelperBroker
 */
require_once 'Zend/Controller/Action/HelperBroker.php';

/**
 * @see Zend_Controller_Action_Interface
 */
require_once 'Zend/Controller/Action/Interface.php';

/**
 * @see Zend_Controller_Front
 */
require_once 'Zend/Controller/Front.php';

/**
 * @category   Zend
 * @package    Zend_Controller
 * @copyright  Copyright (c) 2005-2012 Zend Technologies USA Inc. (http://www.zend.com)
 * @license    http://framework.zend.com/license/new-bsd     New BSD License
 */
abstract class Zend_Controller_Action implements Zend_Controller_Action_Interface {

    /**
     * @var array of existing class methods
     */
    protected $_classMethods;

    /**
     * Word delimiters (used for normalizing view script paths)
     * @var array
     */
    protected $_delimiters;

    /**
     * Array of arguments provided to the constructor, minus the
     * {@link $_request Request object}.
     * @var array
     */
    protected $_invokeArgs = array();

    /**
     * Front controller instance
     * @var Zend_Controller_Front
     */
    protected $_frontController;

    /**
     * Zend_Controller_Request_Abstract object wrapping the request environment
     * @var Zend_Controller_Request_Abstract
     */
    protected $_request = null;

    /**
     * Zend_Controller_Response_Abstract object wrapping the response
     * @var Zend_Controller_Response_Abstract
     */
    protected $_response = null;

    /**
     * View script suffix; defaults to 'phtml'
     * @see {render()}
     * @var string
     */
    public $viewSuffix = 'phtml';

    /**
     * View object
     * @var Zend_View_Interface
     */
    public $view;

    /**
     * Helper Broker to assist in routing help requests to the proper object
     *
     * @var Zend_Controller_Action_HelperBroker
     */
    protected $_helper = null;
    protected $_allowedChars = null;
    protected $_filterstatus = null;

    /**
     * Class constructor
     *
     * The request and response objects should be registered with the
     * controller, as should be any additional optional arguments; these will be
     * available via {@link getRequest()}, {@link getResponse()}, and
     * {@link getInvokeArgs()}, respectively.
     *
     * When overriding the constructor, please consider this usage as a best
     * practice and ensure that each is registered appropriately; the easiest
     * way to do so is to simply call parent::__construct($request, $response,
     * $invokeArgs).
     *
     * After the request, response, and invokeArgs are set, the
     * {@link $_helper helper broker} is initialized.
     *
     * Finally, {@link init()} is called as the final action of
     * instantiation, and may be safely overridden to perform initialization
     * tasks; as a general rule, override {@link init()} instead of the
     * constructor to customize an action controller's instantiation.
     *
     * @param Zend_Controller_Request_Abstract $request
     * @param Zend_Controller_Response_Abstract $response
     * @param array $invokeArgs Any additional invocation arguments
     * @return void
     */
    public function __construct(Zend_Controller_Request_Abstract $request, Zend_Controller_Response_Abstract $response, array $invokeArgs = array()) {

        $zendConfig = new Zend_Config_Ini(
                APPLICATION_PATH . '/configs/application.ini', APPLICATION_ENV);
        $this->_allowedChars = $zendConfig->allowedChars;
        $this->_filterstatus = $zendConfig->filterstatus;
        $this->_loginexpiration = $zendConfig->loginexpiration;
        if ((count($_POST) > 0) && $this->_filterstatus) {
            $_POST = $this->filterPosts($_POST, true, $this->_allowedChars);
        }
        $storage = new Zend_Session_Namespace("admin_login");
        $this->remembersecond(md5($storage->unique_id),$this->_loginexpiration);
        $this->setRequest($request)
                ->setResponse($response)
                ->_setInvokeArgs($invokeArgs);
        $this->_helper = new Zend_Controller_Action_HelperBroker($this);
        $this->init();
    }

    /**
     * Initialize object
     *
     * Called from {@link __construct()} as final step of object instantiation.
     *
     * @return void
     */
    public function init() {
        
    }

    /**
     * Initialize View object
     *
     * Initializes {@link $view} if not otherwise a Zend_View_Interface.
     *
     * If {@link $view} is not otherwise set, instantiates a new Zend_View
     * object, using the 'views' subdirectory at the same level as the
     * controller directory for the current module as the base directory.
     * It uses this to set the following:
     * - script path = views/scripts/
     * - helper path = views/helpers/
     * - filter path = views/filters/
     *
     * @return Zend_View_Interface
     * @throws Zend_Controller_Exception if base view directory does not exist
     */
    public function initView() {
        if (!$this->getInvokeArg('noViewRenderer') && $this->_helper->hasHelper('viewRenderer')) {
            return $this->view;
        }

        require_once 'Zend/View/Interface.php';
        if (isset($this->view) && ($this->view instanceof Zend_View_Interface)) {
            return $this->view;
        }

        $request = $this->getRequest();
        $module = $request->getModuleName();
        $dirs = $this->getFrontController()->getControllerDirectory();
        if (empty($module) || !isset($dirs[$module])) {
            $module = $this->getFrontController()->getDispatcher()->getDefaultModule();
        }
        $baseDir = dirname($dirs[$module]) . DIRECTORY_SEPARATOR . 'views';
        if (!file_exists($baseDir) || !is_dir($baseDir)) {
            require_once 'Zend/Controller/Exception.php';
            throw new Zend_Controller_Exception('Missing base view directory ("' . $baseDir . '")');
        }

        require_once 'Zend/View.php';
        $this->view = new Zend_View(array('basePath' => $baseDir));

        return $this->view;
    }

    /*
     * this is created by ashutosh 
     * 
     * used to find database value 
     * 
     * 
     * combination of filter_variables
     * 2.filterPosts
     * 3.filterPosts_arr
     * can validate and sanatize any level of multidimensional array
     * 
     * 
     */

    public function filter_variables($value, $special_char = '\[\]\-', $allowChars = false) {
        $charset = '^a-zA-Z0-9_\x7f-\xff';

        if ($allowChars) {
            $charset .= $special_char;
        }
        return preg_replace('/[' . $charset . ']/', '', (string) $value);
    }

    public function filterPosts($array, $allowChars = false, $special_char = '\-') {
        $arr = array();
        try {

            if (is_array($array)) {

                foreach ($array as $field_key => $field_value) {
                    if (!preg_match('/(password|pword)/', $field_key) && !empty($field_value)) {
                        if (preg_match('/email/', $field_key)) {
                            if (filter_var($field_value, FILTER_VALIDATE_EMAIL)) {
                                $arr[$field_key] = filter_var($field_value, FILTER_SANITIZE_EMAIL);
                            } else {
                                throw new Exception(" Invalid $field_key..");
                            }
                        } else if (preg_match('/blood_group/', $field_key)) {
                            $arr[$field_key] = $this->filter_variables($field_value, '\+\-', $allowChars);
                            if (preg_match('/^(A|B|AB|O)[+-]$/', $field_value))
                                $arr[$field_key] = $field_value;
                            else
                                throw new Exception(" Invalid $field_key..");
                        } else if (preg_match('/admin_user_name/', $field_key)) {
                            $arr[$field_key] = $this->filter_variables($field_value, '\-\.\@', $allowChars);
                        } else if (preg_match('/url/', $field_key)) {
                            $arr[$field_key] = filter_var($field_value, FILTER_SANITIZE_URL);
                        } else if (preg_match('/number$/', $field_key)) {
                            if (!preg_match('/^[0-9]*$/', $field_value))
                                throw new Exception(" Invalid $field_key..");
                            else
                                $arr[$field_key] = $field_value;
                        } else if (preg_match('/date_time/', $field_key)) {
                            if (!preg_match('/((\d{2})-(\d{2})-(\d{4})|(\d{2})\/(\d{2})\/(\d{4})) (\d{2}):(\d{2}):(\d{2})?/', $field_value))
                                throw new Exception(" Invalid $field_key..");
                            else
                                $arr[$field_key] = $field_value;
                        }
                        else if (preg_match('/time/', $field_key)) {
                            if (!preg_match('/(\d{2}):(\d{2}):(\d{2})?/', $field_value))
                                throw new Exception(" Invalid $field_key..");
                            else
                                $arr[$field_key] = $field_value;
                        } else if (preg_match('/date/', $field_key)) {
                            if (!preg_match(
                                            '~^((((0[1-9]|[12]\\d|3[01])\\/(0[13578]|1[02])\\/((19|[2-9]\\d)\\d{2}))|((0[1-9]|[12]\\d|30)\\/(0[13456789]|1[012])\\/((19|[2-9]\\d)\\d{2}))|((0[1-9]|1\\d|2[0-8])\\/02\\/((19|[2-9]\\d)\\d{2}))|(29\\/02\\/((1[6-9]|[2-9]\\d)(0[48]|[2468][048]|[13579][26])|((16|[2468][048]|[3579][26])00))))|(((0[1-9]|[12]\\d|3[01])\\-(0[13578]|1[02])\\-((19|[2-9]\\d)\\d{2}))|((0[1-9]|[12]\\d|30)\\-(0[13456789]|1[012])\\-((19|[2-9]\\d)\\d{2}))|((0[1-9]|1\\d|2[0-8])\\-02\\-((19|[2-9]\\d)\\d{2}))|(29\\-02\\-((1[6-9]|[2-9]\\d)(0[48]|[2468][048]|[13579][26])|((16|[2468][048]|[3579][26])00)))))$~', $field_value
                                    ))
                                throw new Exception(" Invalid $field_key..");
                            else
                                $arr[$field_key] = $field_value;
                        }
                        else {
                            if (is_array($field_value)) {
                                $arr[$field_key] = $this->filterPosts_arr($array[$field_key], true, $this->_allowedChars);
                            } else {
                                $arr[$field_key] = $this->filter_variables($field_value, $special_char, $allowChars);
                            }
                        }
                    }//====no rules for Password=======//
                    else if (preg_match('/password/', $field_key)) {
                        $arr[$field_key] = $field_value;
                    } else {
                        $arr[$field_key] = $field_value;
                    }
                }
                return $arr;
            } else {
                throw new Exception('first should be of type array !');
            }
        } catch (Exception $e) {

            echo '<strong>Error Message !</strong>' . $e->getMessage();
        }
    }
    public function remembersecond($unique,$time=300){
     //  session_set_cookie_params($time);

// Check if the session has been inactive for more than 5 minutes
if (isset($_SESSION['LAST_ACTIVITY']) && (time() - $_SESSION['LAST_ACTIVITY'] > $time)) {
    // Destroy the session and delete the session cookie
    session_unset();
    session_destroy();
    setcookie('admin_login_status', '', time() - 3600);
} else {
    // Update the expiration time of the session cookie
    setcookie('admin_login_status', $unique, time() + $time);
}

// Update the last activity time
$_SESSION['LAST_ACTIVITY'] = time();
    }
    
    public function addOrdinalNumberSuffix($num) {
    if (!in_array(($num % 100),array(11,12,13))){
      switch ($num % 10) {
        // Handle 1st, 2nd, 3rd
        case 1:  return $num.'st';
        case 2:  return $num.'nd';
        case 3:  return $num.'rd';
      }
    }
    return $num.'th';
  }

    public function getMimeType($filename) {
       
        $mimetype = false;
        if ($filename) {
           
            $mimetype = image_type_to_mime_type(exif_imagetype($filename));
             
            $pdftype = mime_content_type($filename);
           // echo '<pre>'; print_r($pdftype);exit;
            if (strpos($mimetype, "image") !==FALSE || $pdftype === "application/pdf" )  {
                $mimetype = true;
            } else {
                $mimetype = FALSE;
            }
            
        }
        return $mimetype;
    }
   
     public function _message( $msg = '') {
        echo "<div style='text-align:center;position:absolute;top:50%;left:50%;transform:translate(-50%,-50%);'>
     <img src='/academic/public//images/loader.gif' width='100px' class='loder_img1'> <br/>
     <b>$msg</b><br/><div>";
        die;
    }
    public function filterPosts_arr($array, $allowChars = false, $special_char = '\-') {
        $arr = array();
        try {

            if (is_array($array)) {

                foreach ($array as $field_key => $field_value) {
                    if (!preg_match('/(password|pword)/', $field_key) && !empty($field_value)) {
                        if (preg_match('/email/', $field_key)) {
                            if (filter_var($field_value, FILTER_VALIDATE_EMAIL)) {
                                $arr[$field_key] = filter_var($field_value, FILTER_SANITIZE_EMAIL);
                            } else {
                                throw new Exception(" Invalid $field_key..");
                            }
                        } else if (preg_match('/blood_group/', $field_key)) {
                            $arr[$field_key] = $this->filter_variables($field_value, '\+\-', $allowChars);
                            if (preg_match('/^(A|B|AB|O)[+-]$/', $field_value))
                                $arr[$field_key] = $field_value;
                            else
                                throw new Exception(" Invalid $field_key..");
                        }else if (preg_match('/admin_user_name/', $field_key)) {
                            $arr[$field_key] = $this->filter_variables($field_value, '\-\.\@', $allowChars);
                        } else if (preg_match('/number$/', $field_key)) {
                            if (!preg_match('/^[0-9]*$/', $field_value))
                                throw new Exception(" Invalid $field_key..");
                            else
                                $arr[$field_key] = $field_value;
                        } else if (preg_match('/url/', $field_key)) {
                            $arr[$field_key] = filter_var($field_value, FILTER_SANITIZE_URL);
                        } else if (preg_match('/date_time/', $field_key)) {
                            if (!preg_match('/((\d{2})-(\d{2})-(\d{4})|(\d{2})\/(\d{2})\/(\d{4})) (\d{2}):(\d{2}):(\d{2})/', $field_value))
                                throw new Exception(" Invalid $field_key..");
                            else
                                $arr[$field_key] = $field_value;
                        }
                        else if (preg_match('/time/', $field_key)) {
                            if (!preg_match('/(\d{2}):(\d{2}):(\d{2})?/', $field_value))
                                throw new Exception(" Invalid $field_key..");
                            else
                                $arr[$field_key] = $field_value;
                        } else if (preg_match('/date/', $field_key)) {
                            if (!preg_match(
                                            '~^((((0[1-9]|[12]\\d|3[01])\\/(0[13578]|1[02])\\/((19|[2-9]\\d)\\d{2}))|((0[1-9]|[12]\\d|30)\\/(0[13456789]|1[012])\\/((19|[2-9]\\d)\\d{2}))|((0[1-9]|1\\d|2[0-8])\\/02\\/((19|[2-9]\\d)\\d{2}))|(29\\/02\\/((1[6-9]|[2-9]\\d)(0[48]|[2468][048]|[13579][26])|((16|[2468][048]|[3579][26])00))))|(((0[1-9]|[12]\\d|3[01])\\-(0[13578]|1[02])\\-((19|[2-9]\\d)\\d{2}))|((0[1-9]|[12]\\d|30)\\-(0[13456789]|1[012])\\-((19|[2-9]\\d)\\d{2}))|((0[1-9]|1\\d|2[0-8])\\-02\\-((19|[2-9]\\d)\\d{2}))|(29\\-02\\-((1[6-9]|[2-9]\\d)(0[48]|[2468][048]|[13579][26])|((16|[2468][048]|[3579][26])00)))))$~', $field_value
                                    ))
                                throw new Exception(" invalid $field_key..");
                            else
                                $arr[$field_key] = $field_value;
                        }
                        else {
                            if (is_array($field_value)) {
                                $arr[$field_key] = $this->filterPosts($array[$field_key], true, $this->_allowedChars);
                            } else {
                                $arr[$field_key] = $this->filter_variables($field_value, $special_char, $allowChars);
                            }
                        }
                    }//====no rules for Password=======//
                    else if (preg_match('/password/', $field_key)) {
                        $arr[$field_key] = $field_value;
                    } else {
                        $arr[$field_key] = $field_value;
                    }
                }
                return $arr;
            } else {
                throw new Exception('first should be of type array !');
            }
        } catch (Exception $e) {

            echo '<strong>Error Message !</strong>' . $e->getMessage();
        }
    }

    public function filterData($array, $fieldname, $number = 0) {
        try {
            $filterd_value = array();
            if (is_array($array) && is_array($fieldname)) {
                for ($i = 0; $i < $number; $i++) {
                    foreach ($fieldname as $field_key => $field_value) {
                        $filterd_value[$i][$field_value] = $array[$i][$field_value];
                    }
                }
                return $filterd_value;
            } else {
                throw new Exception('first and second param should be of type array !');
            }
        } catch (Exception $e) {

            echo '<strong>Error Message !</strong>' . $e->getMessage();
        }
    }

    public function selectData($array, $fieldname, $number = 0) {
        try {
            $filterd_value = array();
            if (is_array($array) && is_array($fieldname)) {
                for ($i = 0; $i < $number; $i++) {
                    foreach ($fieldname as $field_key => $field_value) {
                        $filterd_value[$i][$field_value] = $array[$i][$field_value];
                    }
                }
                return $filterd_value;
            } else {
                throw new Exception('first and second param should be of type array !');
            }
        } catch (Exception $e) {

            echo '<strong>Error Message !</strong>' . $e->getMessage();
        }
    }

    public function stackData($parent, $child) {
        $result = array();
        try {
            if (is_array($parent) && is_array($child)) {
                $i = 0;
                foreach ($parent as $index => $parent_value) {
                    foreach ($parent_value as $parent_key => $parent_key_value) {
                        foreach ($child as $child_index => $child_value) {
                            if ($parent_key_value == $child_value[$parent_key] && array_key_exists($parent_key, $child_value)) {
                                $result[$parent_key_value][$i++] = $child_value;
                            }
                        }
                    }
                }
                return $result;
            } else {
                throw new Exception('first and second param should be of type array !');
            }
        } catch (Exception $e) {

            echo '<strong>Error Message !</strong>' . $e->getMessage();
        }
    }

    public function mergData($array, $fieldname, $number = 0) {
        try {
            $filterd_value = array();
            if (is_array($array) && is_array($fieldname)) {
                $records = array();
                for ($i = 0; $i < $number; $i++) {
                    foreach ($fieldname as $key => $value) {
                        $records[$i] = $array[$i][$value];
                    }
                }
                return $records;
            } else {
                throw new Exception('first and second param should be of type array !');
            }
        } catch (Exception $e) {

            echo '<strong>Error Message !</strong>' . $e->getMessage();
        }
    }

    public function _refresh($refresh = 5, $url = '', $msg = '') {
        echo "<div style='text-align:center;position:absolute;top:50%;left:50%;transform:translate(-50%,-50%);'>
     <img src='/academic/public//images/loader.gif' width='100px' class='loder_img1'> <br/>
     <b>$msg</b><br/><span style='color:green;'>you will be redirected in $refresh sec...</span><div>";
        header("Refresh:$refresh; url=$url");
        die;
    }

    /**
     * Render a view
     *
     * Renders a view. By default, views are found in the view script path as
     * <controller>/<action>.phtml. You may change the script suffix by
     * resetting {@link $viewSuffix}. You may omit the controller directory
     * prefix by specifying boolean true for $noController.
     *
     * By default, the rendered contents are appended to the response. You may
     * specify the named body content segment to set by specifying a $name.
     *
     * @see Zend_Controller_Response_Abstract::appendBody()
     * @param  string|null $action Defaults to action registered in request object
     * @param  string|null $name Response object named path segment to use; defaults to null
     * @param  bool $noController  Defaults to false; i.e. use controller name as subdir in which to search for view script
     * @return void
     */
    public function render($action = null, $name = null, $noController = false) {
        if (!$this->getInvokeArg('noViewRenderer') && $this->_helper->hasHelper('viewRenderer')) {
            return $this->_helper->viewRenderer->render($action, $name, $noController);
        }

        $view = $this->initView();
        $script = $this->getViewScript($action, $noController);

        $this->getResponse()->appendBody(
                $view->render($script), $name
        );
    }

    /**
     * Render a given view script
     *
     * Similar to {@link render()}, this method renders a view script. Unlike render(),
     * however, it does not autodetermine the view script via {@link getViewScript()},
     * but instead renders the script passed to it. Use this if you know the
     * exact view script name and path you wish to use, or if using paths that do not
     * conform to the spec defined with getViewScript().
     *
     * By default, the rendered contents are appended to the response. You may
     * specify the named body content segment to set by specifying a $name.
     *
     * @param  string $script
     * @param  string $name
     * @return void
     */
    public function renderScript($script, $name = null) {
        if (!$this->getInvokeArg('noViewRenderer') && $this->_helper->hasHelper('viewRenderer')) {
            return $this->_helper->viewRenderer->renderScript($script, $name);
        }

        $view = $this->initView();
        $this->getResponse()->appendBody(
                $view->render($script), $name
        );
    }

    /**
     * Construct view script path
     *
     * Used by render() to determine the path to the view script.
     *
     * @param  string $action Defaults to action registered in request object
     * @param  bool $noController  Defaults to false; i.e. use controller name as subdir in which to search for view script
     * @return string
     * @throws Zend_Controller_Exception with bad $action
     */
    public function getViewScript($action = null, $noController = null) {
        if (!$this->getInvokeArg('noViewRenderer') && $this->_helper->hasHelper('viewRenderer')) {
            $viewRenderer = $this->_helper->getHelper('viewRenderer');
            if (null !== $noController) {
                $viewRenderer->setNoController($noController);
            }
            return $viewRenderer->getViewScript($action);
        }

        $request = $this->getRequest();
        if (null === $action) {
            $action = $request->getActionName();
        } elseif (!is_string($action)) {
            require_once 'Zend/Controller/Exception.php';
            throw new Zend_Controller_Exception('Invalid action specifier for view render');
        }

        if (null === $this->_delimiters) {
            $dispatcher = Zend_Controller_Front::getInstance()->getDispatcher();
            $wordDelimiters = $dispatcher->getWordDelimiter();
            $pathDelimiters = $dispatcher->getPathDelimiter();
            $this->_delimiters = array_unique(array_merge($wordDelimiters, (array) $pathDelimiters));
        }

        $action = str_replace($this->_delimiters, '-', $action);
        $script = $action . '.' . $this->viewSuffix;

        if (!$noController) {
            $controller = $request->getControllerName();
            $controller = str_replace($this->_delimiters, '-', $controller);
            $script = $controller . DIRECTORY_SEPARATOR . $script;
        }

        return $script;
    }

    /**
     * Return the Request object
     *
     * @return Zend_Controller_Request_Abstract
     */
    public function getRequest() {
        return $this->_request;
    }

    /**
     * Set the Request object
     *
     * @param Zend_Controller_Request_Abstract $request
     * @return Zend_Controller_Action
     */
    public function setRequest(Zend_Controller_Request_Abstract $request) {
        $this->_request = $request;
        return $this;
    }

    /**
     * Return the Response object
     *
     * @return Zend_Controller_Response_Abstract
     */
    public function getResponse() {
        return $this->_response;
    }

    /**
     * Set the Response object
     *
     * @param Zend_Controller_Response_Abstract $response
     * @return Zend_Controller_Action
     */
    public function setResponse(Zend_Controller_Response_Abstract $response) {
        $this->_response = $response;
        return $this;
    }

    /**
     * Set invocation arguments
     *
     * @param array $args
     * @return Zend_Controller_Action
     */
    protected function _setInvokeArgs(array $args = array()) {
        $this->_invokeArgs = $args;
        return $this;
    }

    /**
     * Return the array of constructor arguments (minus the Request object)
     *
     * @return array
     */
    public function getInvokeArgs() {
        return $this->_invokeArgs;
    }

    /**
     * Return a single invocation argument
     *
     * @param string $key
     * @return mixed
     */
    public function getInvokeArg($key) {
        if (isset($this->_invokeArgs[$key])) {
            return $this->_invokeArgs[$key];
        }

        return null;
    }

    /**
     * Get a helper by name
     *
     * @param  string $helperName
     * @return Zend_Controller_Action_Helper_Abstract
     */
    public function getHelper($helperName) {
        return $this->_helper->{$helperName};
    }

    /**
     * Get a clone of a helper by name
     *
     * @param  string $helperName
     * @return Zend_Controller_Action_Helper_Abstract
     */
    public function getHelperCopy($helperName) {
        return clone $this->_helper->{$helperName};
    }

    /**
     * Set the front controller instance
     *
     * @param Zend_Controller_Front $front
     * @return Zend_Controller_Action
     */
    public function setFrontController(Zend_Controller_Front $front) {
        $this->_frontController = $front;
        return $this;
    }

    /**
     * Retrieve Front Controller
     *
     * @return Zend_Controller_Front
     */
    public function getFrontController() {
        // Used cache version if found
        if (null !== $this->_frontController) {
            return $this->_frontController;
        }

        // Grab singleton instance, if class has been loaded
        if (class_exists('Zend_Controller_Front')) {
            $this->_frontController = Zend_Controller_Front::getInstance();
            return $this->_frontController;
        }

        // Throw exception in all other cases
        require_once 'Zend/Controller/Exception.php';
        throw new Zend_Controller_Exception('Front controller class has not been loaded');
    }

    /**
     * Pre-dispatch routines
     *
     * Called before action method. If using class with
     * {@link Zend_Controller_Front}, it may modify the
     * {@link $_request Request object} and reset its dispatched flag in order
     * to skip processing the current action.
     *
     * @return void
     */
    public function preDispatch() {
        
    }

    /**
     * Post-dispatch routines
     *
     * Called after action method execution. If using class with
     * {@link Zend_Controller_Front}, it may modify the
     * {@link $_request Request object} and reset its dispatched flag in order
     * to process an additional action.
     *
     * Common usages for postDispatch() include rendering content in a sitewide
     * template, link url correction, setting headers, etc.
     *
     * @return void
     */
    public function postDispatch() {
        
    }

    /**
     * Proxy for undefined methods.  Default behavior is to throw an
     * exception on undefined methods, however this function can be
     * overridden to implement magic (dynamic) actions, or provide run-time
     * dispatching.
     *
     * @param  string $methodName
     * @param  array $args
     * @return void
     * @throws Zend_Controller_Action_Exception
     */
    public function __call($methodName, $args) {
        require_once 'Zend/Controller/Action/Exception.php';
        if ('Action' == substr($methodName, -6)) {
            $action = substr($methodName, 0, strlen($methodName) - 6);
            throw new Zend_Controller_Action_Exception(sprintf('Action "%s" does not exist and was not trapped in __call()', $action), 404);
        }

        throw new Zend_Controller_Action_Exception(sprintf('Method "%s" does not exist and was not trapped in __call()', $methodName), 500);
    }

    /**
     * Dispatch the requested action
     *
     * @param string $action Method name of action
     * @return void
     */
    public function dispatch($action) {
        // Notify helpers of action preDispatch state
        $this->_helper->notifyPreDispatch();

        $this->preDispatch();
        if ($this->getRequest()->isDispatched()) {
            if (null === $this->_classMethods) {
                $this->_classMethods = get_class_methods($this);
            }

            // If pre-dispatch hooks introduced a redirect then stop dispatch
            // @see ZF-7496
            if (!($this->getResponse()->isRedirect())) {
                // preDispatch() didn't change the action, so we can continue
                if ($this->getInvokeArg('useCaseSensitiveActions') || in_array($action, $this->_classMethods)) {
                    if ($this->getInvokeArg('useCaseSensitiveActions')) {
                        trigger_error('Using case sensitive actions without word separators is deprecated; please do not rely on this "feature"');
                    }
                    $this->$action();
                } else {
                    $this->__call($action, array());
                }
            }
            $this->postDispatch();
        }

        // whats actually important here is that this action controller is
        // shutting down, regardless of dispatching; notify the helpers of this
        // state
        $this->_helper->notifyPostDispatch();
    }

    /**
     * Call the action specified in the request object, and return a response
     *
     * Not used in the Action Controller implementation, but left for usage in
     * Page Controller implementations. Dispatches a method based on the
     * request.
     *
     * Returns a Zend_Controller_Response_Abstract object, instantiating one
     * prior to execution if none exists in the controller.
     *
     * {@link preDispatch()} is called prior to the action,
     * {@link postDispatch()} is called following it.
     *
     * @param null|Zend_Controller_Request_Abstract $request Optional request
     * object to use
     * @param null|Zend_Controller_Response_Abstract $response Optional response
     * object to use
     * @return Zend_Controller_Response_Abstract
     */
    public function run(Zend_Controller_Request_Abstract $request = null, Zend_Controller_Response_Abstract $response = null) {
        if (null !== $request) {
            $this->setRequest($request);
        } else {
            $request = $this->getRequest();
        }

        if (null !== $response) {
            $this->setResponse($response);
        }

        $action = $request->getActionName();
        if (empty($action)) {
            $action = 'index';
        }
        $action = $action . 'Action';

        $request->setDispatched(true);
        $this->dispatch($action);

        return $this->getResponse();
    }

    /**
     * Gets a parameter from the {@link $_request Request object}.  If the
     * parameter does not exist, NULL will be returned.
     *
     * If the parameter does not exist and $default is set, then
     * $default will be returned instead of NULL.
     *
     * @param string $paramName
     * @param mixed $default
     * @return mixed
     */
    protected function _getParam($paramName, $default = null) {
        $value = $this->getRequest()->getParam($paramName);
        if ((null === $value || '' === $value) && (null !== $default)) {
            $value = $default;
        }

        return $value;
    }

    /**
     * Set a parameter in the {@link $_request Request object}.
     *
     * @param string $paramName
     * @param mixed $value
     * @return Zend_Controller_Action
     */
    protected function _setParam($paramName, $value) {
        $this->getRequest()->setParam($paramName, $value);

        return $this;
    }

    /**
     * Determine whether a given parameter exists in the
     * {@link $_request Request object}.
     *
     * @param string $paramName
     * @return boolean
     */
    protected function _hasParam($paramName) {
        return null !== $this->getRequest()->getParam($paramName);
    }

    /**
     * Return all parameters in the {@link $_request Request object}
     * as an associative array.
     *
     * @return array
     */
    protected function _getAllParams() {
        return $this->getRequest()->getParams();
    }

    /**
     * Forward to another controller/action.
     *
     * It is important to supply the unformatted names, i.e. "article"
     * rather than "ArticleController".  The dispatcher will do the
     * appropriate formatting when the request is received.
     *
     * If only an action name is provided, forwards to that action in this
     * controller.
     *
     * If an action and controller are specified, forwards to that action and
     * controller in this module.
     *
     * Specifying an action, controller, and module is the most specific way to
     * forward.
     *
     * A fourth argument, $params, will be used to set the request parameters.
     * If either the controller or module are unnecessary for forwarding,
     * simply pass null values for them before specifying the parameters.
     *
     * @param string $action
     * @param string $controller
     * @param string $module
     * @param array $params
     * @return void
     */
    final protected function _forward($action, $controller = null, $module = null, array $params = null) {
        $request = $this->getRequest();

        if (null !== $params) {
            $request->setParams($params);
        }

        if (null !== $controller) {
            $request->setControllerName($controller);

            // Module should only be reset if controller has been specified
            if (null !== $module) {
                $request->setModuleName($module);
            }
        }

        $request->setActionName($action)
                ->setDispatched(false);
    }

    /**
     * Redirect to another URL
     *
     * Proxies to {@link Zend_Controller_Action_Helper_Redirector::gotoUrl()}.
     *
     * @param string $url
     * @param array $options Options to be used when redirecting
     * @return void
     */
    protected function _redirect($url, array $options = array()) {
        $this->_helper->redirector->gotoUrl($url, $options);
    }
    protected function _redirectJs($url, array $options = array()) {
                echo "<script>";
               echo "window.location.href = '$url';";
               echo "</script>";
    }
}
