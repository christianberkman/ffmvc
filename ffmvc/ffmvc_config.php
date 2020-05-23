<?php
/**
 * Few Files MVC
 * by Christian Berkman
 *
 * configuration file
 */

class config{
  // Base URL of your project
  // without trailing slash
  // e.g. http://localhost/, https://mydomain.com/project/file.php
  const BASE_URL = '//localhost/ffmvc/index.php';

  // Title of your project
  const TITLE = "ffmvc development";

  // Folders containing your controllers, models and views
  const CONTROLLER_DIR = BASE_DIR ."/c";
  const VIEWS_DIR = BASE_DIR ."/v";
  const MODELS_DIR = BASE_DIR ."/m";

  // $_GET arguments to find controller and method name
  const CONTROLLER_ARG = 'c';
  const METHOD_ARG = 'm';

  // Default controller and method
  const DEFAULT_CONTROLLER = 'index';
  const DEFAUTL_METHOD = 'index';

  // Fatal error
  const FATAL_ERROR_DEFAULT_HEADING = 'Fatal Error';
  const FATAL_ERROR_DEFAULT_MSG = 'Something went wrong, cannot continue';
}
