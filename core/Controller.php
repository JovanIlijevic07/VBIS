<?php

namespace app\core;


abstract class Controller
{
    public Request $request;
    public View $view;

    public function __construct()
    {
        $this->request = new Request();
        $this->view = new View();
        $this->authorize();
    }

    abstract public function authorizeRoles();

    public function authorize()
    {
        $roles = $this->authorizeRoles();

        if ($roles == [])
            return;

        $access = false;

        if (Application::$app->session->get(Constant::$auth_session) !== false)
        {
            foreach ($roles as $role) {
                if (Application::$app->session->checkRole($role))
                    $access = true;
            }

            if (!$access)
                header("location:" . "/accessDenied");

            return;
        }

        header("location:" . "/login");
    }

    public function view($viewName, $layoutName, $params)
    {
        return $this->view->render($viewName, $layoutName, $params);
    }
}