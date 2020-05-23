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
    var_dump($this->request->isGet());
  }
} # class controller


 ?>
