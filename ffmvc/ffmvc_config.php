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

  // Database type
  const DB_TYPE = 'sqlite3';

  // Database: sqlite3
  const DB_FILE = 'database.sqlite';

  // Database: mysql
  #const DB_SERVER = 'localhost';
  #const DB_USER = '';
  #const DB_PASS = '';
  #const DB_SCEHMA = '';

  // Fatal error
  const FATAL_ERROR_DEFAULT_HEADING = 'Fatal Error';
  const FATAL_ERROR_DEFAULT_MSG = 'Something went wrong, cannot continue';

  // Folders containing your controllers, models and views
  const CONTROLLER_DIR = BASE_DIR ."/c";
  const VIEWS_DIR = BASE_DIR ."/v";
  const MODELS_DIR = BASE_DIR ."/m";

  // $_GET arguments to find controller and method name
  const CONTROLLER_ARG = 'c';
  const METHOD_ARG = 'm';

  // Default controller and method
  const DEFAULT_CONTROLLER = 'index';
  const DEFAULT_METHOD = 'index';

}
