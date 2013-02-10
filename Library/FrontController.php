<?php

/**
 * Front controller class
 */
class FrontController {

    /**
     * @var \Library\Controller Current controller.
     */

    private $controller; // после объявления объекта, на начальном этапе присваивается значения глобального класса Controller\IndexController
    
    /**
     * @var \PDO
     */
    private $db_conection;

    /**
     * @var string Current action name
     */
    private $action;
	private $logger;
	

    /**
     * @var array Request params.
     * TODO Replace this with request object
     */
    private $params;

    /**
     * @var \FrontController
     */
    private static $instance;

    /**
     * Constructor.
     */
    private function __construct() {

        $queryString = $_SERVER['QUERY_STRING']; // заносит в переменную  $queryString строку запроса
        $query = explode('/', $queryString); // разделяет слова запроса  слэшами /index/,/Library/ и т.д.
        $query = array_filter($query); //удаляет из массива все пустые строки

        $this->controller = $this->_getController(array_shift($query)); //присваивает переменной controller значение класса, допустим для /index/=Controller\IndexController
        $this->action = $this->_getAction(array_shift($query)); //присваивает переменной action значение второго слова запроса в форме, например для /table/ = tableAction
        $this->params = $this->grabParams($query); // создаёт массив в переменной params вида name=value

        $this->init_db();
		$this->init_logger();
		$this->init_session();
		
    }
    
    private function init_db() {


        $login = 'root';

        $passwd = 'bazilio';


        $this->db_conection = new PDO('mysql:host=localhost;dbname=blog', $login, $passwd);
    }
	private function init_logger(){
	
		$this->logger = \Library\loggerPHP::getInstance();
	}

    public function getDBConnection()
    {
        return $this-> db_conection;
    }

    /**
     * Gets controller object by it's class name.
     *
     * @param string $controllerName Controller class name.
     * @return \Library\Controller
     * @throws Library\PageNotFoundException Controller not found.
     */
    private function _getController($controllerName) {//создание имени класса контролера
        $controllerName = $controllerName ? : 'index';
        $controllerName = ucfirst($controllerName);
        $className = 'Controller\\' . $controllerName . 'Controller';
        return new $className; // динамическое конструирование имени в пространстве имен
    }

    /**
     * Gets action methods name.
     *
     * @param string $actionName Action name.
     * @return string
     */
    private function _getAction($actionName) {
        $actionName = $actionName ? : 'index';
        return $actionName . 'Action';
    }

    /**
     * Parses query string into query params array.
     *
     * @param string $query Query string,
     * @return array
     */
    private function _parseParams($query) {
        $queryStringLength = count($query);
        $params = array();

        for ($i = 0; $i < $queryStringLength; $i+=2) {
            if (isset($query[$i + 1])) {
                $key = $query[$i];
                $value = $query[$i + 1];
                $params[$key] = $value;
            }
        }

        return $params;
    }

    /**
     * Application run.\\
     */
    function run() {
        /** @var $view TYPE_NAME */
        $view = new \Library\View(); //создаёт экземпляп  объекта класса View() c namespace=LIBRARY, т.е. глобальный класс \Library\View
        $view->setLayout(ROOT . DIRECTORY_SEPARATOR . 'View' . DIRECTORY_SEPARATOR . 'layout.php'); //возвращает переменной layout объекта $view  значение строки запроса
        //index/View/layout.php
        $this->controller->setView($view); //присваивает переменной $view, унаследованной от класса \Library\Controller объект класса Library\View
        //TODO Set Request object to controller
		$this->logger->write(get_class($this->controller).' '.$this->action);
        call_user_func_array(array($this->controller, $this->action), array($this->params)); //вызываем метод класса, находящегося в переменной controller
        //indexAction(для первого входа на ссайт) с массивом параметров
		
    }

    /**
     * Singleton get instance.
     *
     * @static
     * @return FrontController
     */
	private function init_session(){
		session_start();
	}
    public static function getInstance() {
        if (!self::$instance) {
            self::$instance = new FrontController();
        }

        return self::$instance;
    }

    private function grabParams($query) {
        $queryParams = $this->_parseParams($query);
        return $queryParams;
    }
    public function setConst(){
        define('ROOTER','true');
    }

}

/**
 * Autoload function.
 *
 * @param string $className Class to autoload
 */
function __autoload($className) {
    $fullClassName = ROOT . DIRECTORY_SEPARATOR . str_replace('\\', DIRECTORY_SEPARATOR, $className) . '.php';
    if (file_exists($fullClassName)) {
        require_once $fullClassName;
    }
}