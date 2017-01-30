<?php

namespace App;

use Controllers\BaseController;

/**
 * A class for handling page rendering.
 */
class Renderer {
    /**
     * Takes a controller instance and a view location, and renders the full page, including
     * the layout set in the controller.
     * @param BaseController $controller A controller instance.
     * @param string $view Path to the view.
     */
    public function render($controller, $view) {
        $controller->parameters['content'] = $this->renderHelper($view, $controller->parameters);
        print $this->renderHelper('views/layouts/' . $controller->layout . '.php', $controller->parameters);
    }

    private function renderHelper($view, $parameters) {
        ob_start();
        //extract everything in param into the current scope
        extract($parameters);
        include($view);

        $output = ob_get_contents();
        ob_end_clean();
        return $output;
    }
}
