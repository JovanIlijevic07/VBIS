<?php

namespace app\controllers;


use app\core\Application;
use app\core\Constant;
use app\core\Controller;

class HomeController extends Controller
{
    public function home()
    {
        return $this->view("home", "main", null);
    }

    public function about()
    {
        return $this->view("about", "main", null);
    }

    public function contact()
    {
        return $this->view("contact", "main", null);
    }

    public function authorizeRoles(): array
    {
        return [];
    }
}