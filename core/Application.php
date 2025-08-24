<?php

namespace app\core;

class Application
{
    public Router $router;
    public Form $form;
    public Session $session;
    public static Application $app;

    public function __construct()
    {
        $this->router = new Router();
        $this->form = new Form();
        $this->session = new Session();

        self::$app = $this;
    }

    public function run()
    {
        $this->router->resolve();
    }
}