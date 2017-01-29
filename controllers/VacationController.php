<?php

namespace Controllers;

use Model\VacationModel;
use UserAuth;

require_once('controllers/BaseController.php');

class VacationController extends BaseController {

    public function requestAction() {
        if(isset($_POST['submit'])) {

            // TODO: obavezna validacija post parametara

            $vacation = new VacationModel();
            $vacation->user_id = UserAuth::user()->id;
            $vacation->start = $_POST['start'];
            $vacation->end = $_POST['end'];
            $vacation->status = 'pending';
            $vacation->insert();
        }
    }

    public function historyAction() {
        $vacations = VacationModel::getAllForUser(UserAuth::user()->id);
        $this->parameters = ['vacations' => $vacations];
    }

    public function approveAction() {
        if(isset($_GET['button'])) {
            $action = $_GET['button'];
            $id = $_GET['id'];

            $vacation = VacationModel::find($id);

            $vacation->status = $action;
            $vacation->save();
        }

        $vacations = VacationModel::getAll();
        $this->parameters = ['vacations' => $vacations];
    }
}