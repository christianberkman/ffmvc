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
    # Controller name
    $this->controllerName = ($this->request->get(config::CONTROLLER_ARG) ?? config::DEFAULT_CONTROLLER);
      if(!$this->checkControllerString()) self::fatalError('Controller', "Invalid controller string: {$this->controllerName}");

    # Controller file
    $this->controllerFile = config::CONTROLLER_DIR ."/". $this->controllerName .".php";
      if(!is_file($this->controllerFile)) self::fatalError('Controller', "Could not find controller file: {$this->controllerFile}");
    require_once $this->controllerFile;
      if(!class_exists('Controller')) self::fatalError('Controller', "Controller class was not declared in {$this->controllerFile}");
    $this->controller = new Controller();
  }

  //
  // Error functions
  //
  static public function fatalError(string $heading = config::FATAL_ERROR_DEFAULT_HEADING, $message = config::FATAL_ERROR_DEFAULT_MSG){
    ob_clean();
    echo "<h1>Fatal Error</h1>";
    echo "<h2>{$heading}</h2>";
    echo "<p>{$message}</p>";
    echo "<hr />";
    echo "<p><em>ffmvc ". self::VERSION;
    exit;
  }

  //
  // Other functions
  //
  /**
   * Check if controller string matches regex
   * @param  string $string controller string
   * @return bool
   */
  public function checkControllerString(){
    $regex = "/^([a-zA-Z][a-zA-z0-9-_.]*)(\/[a-zA-Z][a-zA-z0-9-_.]*)*$/";
    return preg_match($regex, $this->controllerName);
  }

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
  private $get, $post;

  /**
   * Constructor
   */
  public function __construct(){
    $this->sanitizeGet();

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
  public function get($key = NULL){
    # Return array if key is NULL
    if($key === NULL) return $this->get;
    # Return NULL if key is not set
    if(!isset($this->get[$key])) return NULL;
    # Return key value
    else return $this->get[$key];
  }
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
