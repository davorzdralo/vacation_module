<?php

namespace Controllers;

/**
 * Base class for controllers. It has properties for parameters that are passed into the view,
 * and the default layout, changable by the user in an inheriting controller.
 */
abstract class BaseController
{
    public $parameters = [];

    public $layout = 'layout';
}