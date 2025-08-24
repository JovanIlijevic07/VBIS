<?php

namespace app\controllers;

use app\core\Application;
use app\core\Constant;
use app\core\Controller;
use app\models\UserModel;

class UserController extends Controller
{
    public function list(): array
    {
        $model = new UserModel();
        var_dump($model->list("where name like '%nikola%'")); exit;
    }

    public function one(): array
    {
        $model = new UserModel();
        $model->mapData($model->one(""));
        echo "<pre>";
        var_dump($model); exit;
    }

    public function create()
    {
        if (!Application::$app->session->get(Constant::$auth_session))
        {
            header("location:" . "/login");
        }

        return $this->view("userCreate", "main", null);
    }

    public function createPost()
    {
        if (!Application::$app->session->get(Constant::$auth_session))
        {
            header("location:" . "/login");
        }

        $model = new UserModel();
        $model->mapData($this->request->all());

        $model->validate();

        if ($model->errors)
        {
            Application::$app->session->setFlash(Constant::$flash_session_error, "Neuspesno kreiran user!");
            return $this->view("userCreate", "main", $model);
        }

        $model->create();

        Application::$app->session->setFlash(Constant::$flash_session_success, "Uspesno kreiran korisnik!");
        header("location:" . "/userCreate");
    }

    public function authorizeRoles(): array
    {
        return [Constant::$super_administrator_role, Constant::$administrator_role];
    }
}