<?php

/* Auto-loader for PHP classes used in project. It works for all classes that
 * follow the convention: the class must be located in a directory of the
 * same name as the namespace, with no nesting. The class must have the same
 * name as the file, except the .php extension. "Views" can not be loaded this
 * way, and they are still manually required when needed for rendering.
 */
spl_autoload_register(function ($classname) {
    $parts = explode("\\", $classname);
    $path = strtolower($parts[0]) . DIRECTORY_SEPARATOR . $parts[1] . '.php';
    if (file_exists($path)) {
        require_once($path);
    }
});


// First thing we do is initialise user authentication. For now, this simply starts the session.
use App\Renderer;
use App\UserAuth;
UserAuth::initialise();

// We read the 'controller' and 'action' parameters if they are set, or set the
// default values if the are not. By default, those are user controller, and login action.
$controller = isset($_GET['controller']) ? $_GET['controller'] : "user";
$action = isset($_GET['action']) ? $_GET['action'] : "login";

// If the user is not logged in, and the user tries to access any page outside
// of the user controller (that is log in, log out, or sign up) we redirect
// him to the login page.
if(!UserAuth::isLoggedIn() && $controller != 'user') {
    $controller = "user";
    $action = "login";
}

// After we have made sure that the user is going to the right controller and
// action, we need to dynamically instantiate the right class and call the
// right action method. We start with constructing the correct names.
$className = 'Controllers\\' . ucfirst($controller) . 'Controller';
$actionName = $action . "Action";

// Dynamically instantiate controller class.
$controllerInstance = new $className();

// Check that the appropriate action method exists in the controller class, and that it is callable.
// If everything is fine, call the action, otherwise kill the script immediately.
// TODO: redirect to 404 page instead of killing the script
if (method_exists($controllerInstance, $actionName) && is_callable([$controllerInstance, $actionName])) {
    $controllerInstance->{$actionName}();
} else {
    die("Action '$action' does not exist!");
}

// After the action method has been executed, it's time to render the view. We
// find the view based on controller and action names, and render it with
// parameters from the action method.

$view = "views/$controller/$action.php";

$renderer = new Renderer();
$renderer->render($controllerInstance, $view);
