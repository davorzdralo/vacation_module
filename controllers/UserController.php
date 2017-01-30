<?php

namespace Controllers;

use Models\UserModel;
use App\UserAuth;

class UserController extends BaseController {

    /**
     * Displays the login form for the user.
     */
    public function loginAction() {
        // If an already logged in user comes to login page, we redirect him to
        // an appropriate page for his role.
        if(UserAuth::isLoggedIn()) {
            if (UserAuth::user()->role == 'employee') {
                header("Location: index.php?controller=vacation&action=request");
            } else if (UserAuth::user()->role == 'admin') {
                header("Location: index.php?controller=vacation&action=approve");
            }
        }

        // Check if there are errors from submit action, and pass the error message as
        // parameter to the view if there are.
        if(isset($_GET['error']) && $_GET['error'] == 'true') {
            $this->parameters['error']= 'Invalid login data, please check your username and password';
        }

        // Check if we have come to login from successful registration, and pass the
        // success message if we have.
        if(isset($_GET['registered']) && $_GET['registered'] == 'true') {
            $this->parameters['registered']= 'You have been successfully registered!';
        }
    }

    /**
     * Receives the login data from the form, and either logs the user in, or
     * redirects him back to login page if the login failed.
     */
    public function loginSubmitAction() {
        $username = $_POST['username'];
        $password = $_POST['password'];

        // First, we try to log in the user.
        if(UserAuth::login($username, $password)) {
            // if there are no errors, redirect the user to appropriate employee/admin home page.
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

    /**
     * Displays the registration form for the user, and registers a new user on submit.
     */
    public function registerAction() {

        // If the submit button is set, we need to attempt to register the user.
        if(isset($_POST['btn-signup'])) {
            $username = $_POST['username'];
            $password = $_POST['password'];

            // First, we check if the username is already taken. If it is, we set the error message
            // and do nothing more. If the username is available, we attempt to register the user.
            // If the registration is successful, we redirect the user to login page, otherwise we
            // set an appropriate error message.

            if(UserModel::usernameTaken($username)) {
                $this->parameters['error'] = "This username is already taken";
            } else if (UserModel::register($username, $password)) {
                header("Location: index.php?controller=user&action=login&registered=true");
            } else {
                $this->parameters['error'] = "There was a problem with your registration";
            }

            // We pass the username we received as a parameter to the view so that we can set
            // username again, in order to not reset it on every submit.
            $this->parameters['username'] = $username;
        }
    }

    /**
     * A simple logout action that logs the user out and redirects him back to the login page.
     */
    public function logoutAction() {
        UserAuth::logout();
        header("Location: index.php?controller=user&action=login");
    }
}