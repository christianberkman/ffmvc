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
    echo "This is the index() function in exampleController.php";
  }

  public function second(){
    echo "This is the second() function in exampleController.php";
  }
} # class controller


 ?>
