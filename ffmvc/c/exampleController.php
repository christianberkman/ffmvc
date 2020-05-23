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
    echo $this->request->get('c');
  }
} # class controller


 ?>
