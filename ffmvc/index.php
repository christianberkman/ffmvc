<?php
/**
 * Few File MVC (ffmvc)
 * Created by Christian Berkman
 *
 * Main file
 * No need to edit anything else than the location of the config gile
 */

/**
 * ffmvc config file
 * You may supply only the filename is the config file is in the same folder as this file.
 */
 define("BASE_DIR", dirname(__FILE__));
 require_once "ffmvc_config.php";

/**
 * ------------ DO NOT CHANGE ANYTHING BELOW THIS LINE ------------
 */

/**
 * Boot ffmvc
 */
 $ffmvc = new Ffmvc();

/**
 * Main ffmvc class
 */
class Ffmvc{
  const VERSION = "0.1 alpha";

  public $request;
  private $controllerName, $controller;
  private static $instance;

  //
  // Boot functions
  //

  /**
   * Constructor
   */
  public function __construct(){
    // Instance
    self::$instance =& $this;

    // Classes
    $this->request = new Request();

    // Load controller
    $this->loadController();

  }

  /**
   * Require controller
   */
  private function loadController(){
    // Check if controller file exists
    $this->controllerFile = config::CONTROLLER_DIR ."/". $this->request->controllerName .".php";
    if(!is_file($this->controllerFile)) self::fatalError('Controller', "Could not find controller file: {$this->controllerFile}");

    // Require file, check if class is declared
    require_once $this->controllerFile;
      if(!class_exists('Controller')) self::fatalError('Controller', "Controller class was not declared in {$this->controllerFile}");
    $this->controller = new Controller();

    // Access method
      if(!method_exists($this->controller, $this->request->methodName)) self::fatalError('Controller', "Controller class did not declare method: {$this->request->methodName}");
    $methodName = $this->request->methodName;
    $this->controller->$methodName();
  }

  //
  // Other Functions
  //

  /**
   * Display a fatal error message
   * @param string $heading Error heading
   * @param string %message Error message
   */
  static public function fatalError(string $heading = config::FATAL_ERROR_DEFAULT_HEADING, $message = config::FATAL_ERROR_DEFAULT_MSG){
    ob_clean();
    echo "<h1>Fatal Error</h1>";
    echo "<h2>{$heading}</h2>";
    echo "<p>{$message}</p>";
    echo "<hr />";
    echo "<p><em>ffmvc ". self::VERSION;
    exit;
  }

  /**
   * Return instance of this class
   * @return Ffmvc class
   */
  public static function &get_instance(){
    return self::$instance;
  }
} # ffmvc class

function &get_ffmvc_instance(){
  return Ffmvc::get_instance();
}

/**
 * Request class
 */
class Request{
  private $get;

  public $url;
  public $controllerName;
  public $methodName;

  /**
   * Constructor
   */
  public function __construct(){
    $this->sanitizeGet();

    // URL
    $this->url = $_SERVER['REQUEST_URI'];

    // Controller
    $this->controllerName = ($this->get(config::CONTROLLER_ARG) ?? config::DEFAULT_CONTROLLER);
      if(!preg_match("/^([a-zA-Z][a-zA-z0-9-_.]*)(\/[a-zA-Z][a-zA-z0-9-_.]*)*$/", $this->controllerName)) ffmvc::fatalError("Request", "Controller name is invalid: {$this->controllerName}");

    // Method
    $this->methodName = ($this->get(config::METHOD_ARG) ?? config::DEFAULT_METHOD);
      if(!preg_match("/^[a-zA-Z][a-zA-Z_]*$/", $this->methodName)) ffmvc::fatalError('Request', "Method name is invalid: {$this->methodName}");
  }

  /**
   * Stript tags from $_GET
   */
  private function sanitizeGet(){
    $this->get = array_map('strip_tags', $_GET);
  }

  /**
   * Return value from $_GET
   * @param  string $key from $_GET
   * @return string|NULL
   */
  public function get(string $key = NULL){
    # Return array if key is NULL
    if($key === NULL) return $this->get;
    # Return NULL if key is not set
    if(!isset($this->get[$key])) return NULL;
    # Return key value
    else return $this->get[$key];
  }

  /**
   * Return value from $_POST
   * @param  string $key key from $_POST
   * @return string|null
   */
  public function post($key = NULL){
    # Return array if key is NULL
    if($key === NULL) return $_POST;
    # Return NULL if key is not set
    if(!isset($_POST[$key])) return NULL;
    # Return key value
    else return $_POST;
  }

  /**
   * Return TRUE if request method is GET
   * @return boolean
   */
  public function isGet(){ return ($_SERVER['REQUEST_METHOD'] == "GET"); }

  /**
   * Return TRUE if request method is POST
   * @return boolean
   */
  public function isPost(){ return ($_SERVER['REQUEST_METHOD'] == "POST"); }
} # request class

/**
 * Base Controller Class
 */
class BaseController{

  public $request;

  public function __construct(){
    $ffmvc =& get_ffmvc_instance();
      $this->request = $ffmvc->request;
    unset($ffmvc);
  }

} # class BaseController

/**
 * Global functions
 */

function view(string $viewName, array $data = []){
  # Check if view file exists
  if(!preg_match("/^([a-zA-Z][a-zA-z0-9-_.]*)(\/[a-zA-Z][a-zA-z0-9-_.]*)*$/", $viewName)) ffmvc::fatalError('View', "View name is invalid: {$viewName}");

  # Check if view file exists
  $viewFile = config::VIEWS_DIR ."/". $viewName .".php";
    if(!is_file($viewFile)) ffmvc::fatalError('View', "View file does not exist: {$viewFile}");

  # Set variables from data
  foreach($data as $key => $value){ $$key = $value; }

  # Require file
  require_once $viewFile;
}
