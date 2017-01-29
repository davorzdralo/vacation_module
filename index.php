<?php

/* Auto-loader for PHP classes used in project. It works for all classes that
 * follow the convention: the class must be located in a directory of the
 * same name as the namespace, with no nesting. The class must have the same
 * name as the file, except the .php extension. "Views" can not be loaded this
 * way, and they are still manually required when needed.
 */
spl_autoload_register(function ($classname) {
    $parts = explode("\\", $classname);
    $filepath = strtolower($parts[0]) . DIRECTORY_SEPARATOR . $parts[1] . '.php';
    if (file_exists($filepath)) {
        require_once($filepath);
    }
});


// First thing we do is initialise user authentication. For now, this simpluy starts the session.
use App\UserAuth;
UserAuth::initialise();

// We read the 'controller' and 'action' parameters if they are set, or set the
// default values if the are not. By default, we redirect the user to the login page
// whre they will get redirected to an appropriate "home" page if they are already logged in.
$controller = isset($_GET['controller']) ? $_GET['controller'] : "user";
$action = isset($_GET['action']) ? $_GET['action'] : "login";

if(!UserAuth::isLoggedIn() && $controller != 'user') {
    $controller = "user";
    $action = "login";
}

$className = 'Controllers\\' . ucfirst($controller) . 'Controller';
$actionName = $action . "Action";

$controllerInstance = new $className();

// Check that the appropriate action method exists in the controller class, and that it is callable.
if (method_exists($controllerInstance, $actionName) && is_callable([$controllerInstance, $actionName])) {
    $controllerInstance->{$actionName}();
} else {
    die("Action '$action' does not exist!");
}

$content = render("views/$controller/$action.php", $controllerInstance->parameters);
$controllerInstance->parameters['content'] = $content;

print render('views/layouts/' . $controllerInstance->layout . '.php', $controllerInstance->parameters);

function render($view, $parameters) {
    ob_start();
    //extract everything in param into the current scope
    extract($parameters);
    include($view);

    $output = ob_get_contents();
    ob_end_clean();
    return $output;
}
