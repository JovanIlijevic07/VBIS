<?php

namespace app\controllers;

use app\core\Application;
use app\core\Constant;
use app\core\Controller;
use app\models\AuthModel;

class AuthController extends Controller
{

    public function registration()
    {
        return $this->view("registration", "auth", null);
    }

    public function registrationPost()
    {
        $model = new AuthModel();
        $model->mapData($this->request->all());
        $model->validate();

        if ($model->errors)
        {
            return $this->view("registration", "auth", $model);
        }

        $model->registration();

        return $this->view("registration", "auth", null);
    }

    public function login()
    {
        if (Application::$app->session->get(Constant::$auth_session))
        {
            header("location:" . "/home");
        }

        return $this->view("login", "auth", null);
    }

    public function loginPost()
    {
        $model = new AuthModel();
        $model->mapData($this->request->all());
        $model->validate();

        if ($model->errors)
        {
            Application::$app->session->setFlash(Constant::$flash_session_error, "Neuspesno ulogovan!");
            return $this->view("login", "auth", $model);
        }

        if ($model->login())
        {
            Application::$app->session->set(Constant::$auth_session, $model->sessionData());
            Application::$app->session->setFlash(Constant::$flash_session_success, "Uspesno ulogovan!");

            header("location:" . "/home");
        }

        return $this->view("login", "auth", null);
    }

    public function logout()
    {
        if (Application::$app->session->get (Constant::$auth_session))
        {
            Application::$app->session->remove(Constant::$auth_session);
            header("location:" . "/login");
        }
    }

    public function accessDenied()
    {
        return $this->view("accessDenied", "main", null);
    }

    public function authorizeRoles(): array
    {
        return [];
    }
}