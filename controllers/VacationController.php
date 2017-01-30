<?php

namespace Controllers;

use Models\VacationModel;
use App\UserAuth;

/**
 * Provides functionalities related to the reservation and approval of vacations.
 */
class VacationController extends BaseController {

    /**
     * Displays the page for making vacation requests.
     */
    public function requestAction() {

        // If the user has submitted a request, we save it in the database using a model.
        if(isset($_POST['submit'])) {
            $vacation = new VacationModel();
            $vacation->user_id = UserAuth::user()->id;
            $vacation->start = $_POST['start'];
            $vacation->end = $_POST['end'];
            $vacation->status = 'pending';
            $vacation->insert();
        }


        // We read the remaining vacation days from the database and pass them to the view.
        $remainingDays = VacationModel::remainingVacationDays(UserAuth::user()->id);

        $this->parameters = [
            'remainingDays' => $remainingDays,
            'user' => UserAuth::user()->username,
        ];

        $this->layout = 'user_layout';
    }

    /**
     * Displays the page that shows the user a list of all of his vacation requests.
     */
    public function historyAction() {
        $vacations = VacationModel::getAllForUser(UserAuth::user()->id);

        $this->layout = 'user_layout';
        $this->parameters = ['vacations' => $vacations];
    }

    /**
     * Displays the page with all the requested vacations for the admin to manage, allowing him to
     * approve or deny the requests.
     */
    public function approveAction() {
        if(isset($_GET['button'])) {
            $action = $_GET['button'];
            $id = $_GET['id'];

            $vacation = VacationModel::find($id);

            $vacation->status = $action;
            $vacation->update();
        }

        $vacations = VacationModel::getAll();

        $this->layout = 'user_layout';
        $this->parameters = ['vacations' => $vacations];
    }
}