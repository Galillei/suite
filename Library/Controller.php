<?php
namespace Library;

/**
 * Base controller class.
 */
class Controller
{
    private $logIn;

    public function setLogIn($logIn)
    {

        $this->logIn = $logIn;
    }

    public function getLogIn()
    {
        return $this->logIn;
    }
    /**
     * @var View;
     */
    private $view;

    /**
     * @var Request
     */
    private $request;

    /**
     * Renders view to the browser.
     *
     * @param array $params View script params.
     * @param string $viewScript View script name.
     */
    public function renderView($params, $viewScript)
    {
//        echo 'params';
//        var_dump($params);
        $fullPath = $this->_constructFullViewScriptPath($viewScript);
        $this->view->setViewScript($fullPath);
        $this->view->setViewVariables($params);
        $this->view->render();
    }

    /**
     * Sets view object to controller.
     *
     * @param View $view View object
     */
    public function setView($view)
    {
        $this->view = $view;
    }

    /**
     * Sets request object to controller.
     *
     * @param Request $request Request to set.
     */
    public function setRequest($request)
    {
        //TODO:Implement
    }

    /**
     * Gets request object from controller.
     */
    public function getRequest()
    {
        //TODO:Implement
    }


    /**
     * Constructor
     */
    public function __construct()
    {
        $this->_init();
    }

    /**
     * Controller initialization.
     */
    protected function _init()
    {

    }

    /**
     * Constructs full viewscript path by file name.
     *
     * @param string $viewScript view script name.
     * @return string
     */
    private function _constructFullViewScriptPath($viewScript)
    {
        $charsToCut = strlen('Controller');
        $classNameWithNamespace = get_class($this);
        $classNameArray = explode('\\', $classNameWithNamespace);
        $className = end($classNameArray);
        $viewFolder = lcfirst(substr($className, 0, strlen($className) - $charsToCut));
//        echo '$viewScrip';
//        var_dump($viewScript);

        return ROOT . DIRECTORY_SEPARATOR . 'View' . DIRECTORY_SEPARATOR . $viewFolder . DIRECTORY_SEPARATOR . $viewScript;
    }

    /**
     * Redirects browser to specified url.
     *
     * @param string $url Destination url.
     */
    public function redirect($url)
    {
        header('Location: '. $url);
    }


}
