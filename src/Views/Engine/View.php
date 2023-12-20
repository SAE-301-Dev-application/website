<?php

namespace MvcLite\Views\Engine;

use MvcLite\Engine\DevelopmentUtilities\Debug;
use MvcLite\Engine\InternalResources\Delivery;
use MvcLite\Router\Engine\Request;
use MvcLite\Views\Engine\Exceptions\NotFoundViewException;

class View
{
    public static function render(string $viewPath, array $props = [])
    {
        $absoluteViewPath = "./src/Views/$viewPath.php";

        if (!file_exists($absoluteViewPath))
        {
            $error = new NotFoundViewException();
            $error->render();
        }

        $props["props"] = Delivery::get();
        extract($props);

        include_once $absoluteViewPath;

        (new Delivery())->save();
    }
}