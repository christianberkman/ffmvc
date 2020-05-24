<?php
/**
 * Few Files MVC
 * by Christian Berkman
 *
 * example controller
 */

class Controller extends BaseController{
  public function __construct(){
    parent::__construct();
  }

  public function index(){
    // Load Models
    model("exampleModel");
    $exampleModel = new exampleModel();

    $data = [
      'controllerName' => $this->request->controllerName
      ,'methodName' => $this->request->methodName
      ,'requestUrl' => $this->request->url
    ];
    view('exampleView', $data);
  }

  public function second(){
    echo "This is the second() function in exampleController.php";
  }
} # class controller


 ?>
