<?php

namespace MvcLite\Router\Engine;

use MvcLite\Engine\DevelopmentUtilities\Debug;
use MvcLite\Engine\InternalResources\Delivery;
use MvcLite\Engine\Security\Validator;

/**
 * Redirection management class.
 *
 * @author belicfr
 */
class RedirectResponse
{
    /** Redirection route. */
    private Route $route;

    /** Current delivery object. */
    private Delivery $currentDelivery;

    private string $parameters;

    public function __construct(Route $route, string $parameters = "")
    {
        $this->route = $route;
        $this->currentDelivery = new Delivery();
        $this->parameters = $parameters;
    }

    /**
     * @param Validator $validator Validator instance
     * @return $this Current RedirectResponse object
     */
    public function withValidator(Validator $validator): RedirectResponse
    {
        $this->currentDelivery
            ->setValidator($validator)
            ->save();

        return $this;
    }

    /**
     * @param Request $request Request instance
     * @return $this Current RedirectResponse object
     */
    public function withRequest(Request $request): RedirectResponse
    {
        $this->currentDelivery
            ->setRequest($request)
            ->save();

        return $this;
    }

    /**
     * Redirect to current route.
     *
     * @return $this Current RedirectResponse object
     */
    public function redirect(): RedirectResponse
    {
        $parameters = "?" . $this->parameters;

        header("Location: " . $this->route->getCompletePath() . $parameters);

        return $this;
    }
}