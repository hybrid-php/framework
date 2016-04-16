<?php
namespace Hybrid;

class View {

    public static function render($view, $data = array()) {

        extract($data);
        ob_start();

        include APP_PATH . '/views/' . $view . '.php';

        return ob_get_clean();
    }
}