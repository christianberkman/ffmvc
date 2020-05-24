# Few Files MVC (ffmvc)
Few Files MVC if a Model, View Controller framework that uses few files. It was developed mainly to learn about object oriented programming in PHP but it should work as-is.

While inspired by CodeIgniter it is _by far_ not as feature packed. Good to use when you have a very simple project and you want to structure it MVC style but do not need a load of features configuration options.

### What it does
+ Make your whole project accessible via one URL: `/index.php?c=CONTROLLER&m=METHOD`
+ Provide very basic functionality like checking if files and classes exits
+ Save you some time if you wanted to do something similar

### What it not does
+ Debugging
+ Logging
+ Query builder

## How to set up
1. Copy the files to the root of your project:
 +  `index.php` _Main file, may be changed to anything you'd like_
 + `ffmvc_config.php` _Config file, may be changes to anything you'd like_
 + Folders for the controllers, models and views: `m/` , `v/`, `c/` _May be changed to anything you'd like_
2. Go over the options in the config file, make sure to set the correct `BASE_URL`
3. Make sure the main file is including the config file if you have renamed it
4. Shoudl work!

## Reference
Please also refer to comments in the source code when needed.

### main class: Ffmvc

#### public function `fatalError(string $heading, string $message)`
Will stop execution and displays a fatal error message as the only output. Can be called from any controller, model or view using `ffmvc::fatalError()`

### request class: Request
The request class will automatically sanitize all `$_GET` variables by using `strip_tags()`. _This is not applied to `$_POST`._

#### public `$url`
Alias for `$_SERVER['REQUEST_URI']`

#### public `$controllerName`
Current controller name / controller path

#### public `$methodName`
Current method name

#### public function `get(string $key)`
+ Returns `$_GET[$key]` when `$key` is given
+ Returns `NULL` when `$key` is given but not set
+ Returns sanitized `$_GET` when `$key` is `NULL`

#### public function `post(string $key)`
+ Returns `$_POST[$key]` when `$key` is given
+ Returns `NULL` when `$key` is given but not set
+ Returns `$_POST` when `$key` is `NULL`

#### public function `isGet()`
returns `TRUE` if request method is GET.

#### public function `isPost()`
returns `TRUE` if request method is POST.

### Controllers
By default controllers are located in `c/`. Controllers may be orgenized in subfolders and called like `?=subfolder/controller`. Controller files should start with a letter and may contain letters and symbols `_ - .`.

Controller classes are __always__ called `Controller` to minimize name clashes. It must extend `BaseController` and call it's constructor to make use of ffmvc functionalities:

```php
class Controller extends BaseController{
  public function __construct(){
    parent::__construct()
  }

  public function index(){
    echo "This is the index page";
  }
}
```  

#### public `$request`
Instance of the request classes

### Model
By default models are located in `m/`. Models may be orgenized in subfolders Model files should start with a letter and may contain letters and symbols `_ - .`. Model files may include one or more models. Models must extend `BaseModel` and call it's constructor to make use of ffmvc functionalities.

```php
class ModelOne extends BaseModel{
  public function __construct(){
    parent::__construct()
  }
}

class ModelTwo extends BaseModel{
  public function __construct(){
    parent::__construct()
  }
}
```

Models can be loaded inside controllers by loading the model file and then creating a new instance:
```PHP
model('exampleModel'); // will load m/exampleModel.php
$myModelOne = new ModelOne();
$myModelTwo = new ModelTwo();
```

#### public `$db`
  instance of the databse connection initialized by `ffmvc`

### Views
By default views are located in `v/`. Views may be orgenized in subfolders. View files should start with a letter and may contain letters and symbols `_ - .`.

View files are loaded using the global `view()` function:
```php
public function controllerIndex(){
  view('myView'); // loads v/myView.php
}
```

#### function `view(string $viewName, array $data = NULL)`
+ $viewName name of the view, for example `dashboard/section1` loads `v/dashboard/section1.php`
+ $data optional data supplied as an array.
