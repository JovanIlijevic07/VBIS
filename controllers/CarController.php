<?php

namespace app\controllers;

use app\core\Constant;
use app\core\Controller;
use app\models\CarModel;

class CarController extends Controller
{
    public function carList()
    {
        return $this->view("carList", "main", null);
    }

    public function carListApi()
    {
        $model = new CarModel();
        echo json_encode($model->list(""));
    }

    public function authorizeRoles()
    {
        return [Constant::$korisnik_role];
    }
}