<?php

namespace app\core;

class View
{
    public function render($viewName, $layoutName, $params)
    {
        $layout = $this->layout($layoutName);
        $view = $this->partialView($viewName, $params);

        $view = str_replace("{{ renderSection }}", $view, $layout);

        echo $view;
    }

    public function layout($layoutName)
    {
        ob_start();
        include_once __DIR__ . "/../views/layouts/$layoutName.php";
        return ob_get_clean();
    }

    public function partialView($viewName, $params)
    {
        if ($params !== null) {
            foreach ($params as $key => $value) {
                $$key = $value;
            }
        }

        ob_start();
        include_once __DIR__ . "/../views/$viewName.php";
        return ob_get_clean();
    }
}