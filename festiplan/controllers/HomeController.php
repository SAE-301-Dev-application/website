<?php
namespace controllers;

use services\ExampleService;
use yasmf\View;

/**
 *
 */
class HomeController
{
    /**
     * @var ExampleService
     */
    private ExampleService $exampleService;

    public function __construct(ExampleService $exampleService)
    {
        $this->exampleService = $exampleService;
    }

    /**
     * @param $pdo
     * @return View
     */
    public function index($pdo)
    {
        $variable = $this->exampleService->getExample($pdo);

        $view = new View("/views/example");
        $view->setVar('variable', $variable);
        return $view;
    }
}


