<?php

namespace Controllers;

// TODO: prebaciti u autoloader
require_once('controllers/BaseController.php');

use Model\UserModel;
use UserAuth;

class UserController extends BaseController {

    public function loginAction() {
        // If an already logged in user comes to login page, we should redirect
        // him to an appropriate page for his role.
        if(UserAuth::isLoggedIn()) {
            if (UserAuth::user()->role == 'employee') {
                header("Location: index.php?controller=vacation&action=request");
            } else if (UserAuth::user()->role == 'admin') {
                header("Location: index.php?controller=vacation&action=approve");
            }
        }

        // check if there are errors from submit action, and pass them as
        // parameters to the view if there are
        if(isset($_GET['error']) && $_GET['error'] == 'true') {
            $this->parameters = ['error' => 'Invalid login data, please check your username and password'];
        }
    }

    // TODO: spojiti sa login akcijom, nema potrebe za odvojenim submitom
    public function loginSubmitAction() {
        // try to login the user
        $username = $_POST['username'];
        $password = $_POST['password'];

        if(UserAuth::login($username, $password)) {
            // if there are no errors, redirect user to appropriate employee/admin home page.
            if (UserAuth::user()->role == 'employee') {
                header("Location: index.php?controller=vacation&action=request");
            } else if (UserAuth::user()->role == 'admin') {
                header("Location: index.php?controller=vacation&action=approve");
            }
        } else {
            // if there are errors, redirect back to login page and show error to user
            header("Location: index.php?controller=user&action=login&error=true");
        }
    }

    public function registerAction() {

        if(isset($_POST['btn-signup'])) {
            $username = $_POST['username'];
            $password = $_POST['password'];

            if(UserModel::usernameTaken($username)) {
                $this->parameters['error'] = "This username is already taken";
            } else if (UserAuth::register($username, $password)) {
                header("Location: index.php?controller=user&action=login&registered=true");
            } else {
                $this->parameters['error'] = "There was a problem with your registration";
            }

            $this->parameters['username'] = $username;
        }
    }

    public function logoutAction() {
        UserAuth::logout();
        header("Location: index.php?controller=user&action=login");
    }
}