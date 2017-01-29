<?php

// TODO: napuniti klase pomocu autoloadera
require_once('app/UserAuth.php');
require_once('models/UserModel.php');
require_once('models/VacationModel.php');
require_once('database/Database.php');

// First thing we do is initialise user authentication.
UserAuth::initialise();


$controller = isset($_GET['controller']) ? $_GET['controller'] : "home";
$action = isset($_GET['action']) ? $_GET['action'] : "index";

//var_dump(UserAuth::isLoggedIn()); exit;

if(UserAuth::isLoggedIn()) {
    // TODO: postaviti razlicit default u zavisnosti od toga koji tip korisnika je ulogovan
    // We read the 'controller' and 'action' parameters if they are set, or set the
    // default values if the are not.
    $controller = isset($_GET['controller']) ? $_GET['controller'] : "home";
    $action = isset($_GET['action']) ? $_GET['action'] : "index";
} else if($controller == 'user') {
    // ako nije ulogovan, ali ide na login ili error, pustimo ga
    // TODO: dodati izuzetke stranica za koje korisnik ne mora da bude ulogovan kao 404 akcija, ili ceo kontroler error
} else {
    $controller = "user";
    $action = "login";
}

$className = ucfirst($controller) . 'Controller';
$classNameWithPackage = 'Controllers\\' . $className;
$pathToController = 'controllers/' . $className . '.php';

if (file_exists($pathToController)) {
    require_once($pathToController);
} else {
    die("Controller in path '$pathToController' does not exist!");
}

$controllerInstance = new $classNameWithPackage();
$actionName = $action . "Action";

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
