<?php
namespace Hybrid;

class Request {

    private static $instance = null;

    public function __construct($uri = null) {

        if($uri === null) {

            $uri = $_SERVER['REQUEST_URI'];
        }

        $this->url = 'http://' . $_SERVER['HTTP_HOST'] . $uri;

        $base_path = dirname($_SERVER['SCRIPT_NAME']);

        if($base_path != '/') {

            $this->base_path = $base_path;
        }

        $this->path = preg_replace('/' . preg_quote($this->base_path, '/') . '/', '', strtok($uri, '?'), 1);
        $this->method = $_SERVER['REQUEST_METHOD'];
        $this->is_ajax = strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest';
        $this->ip = $_SERVER['REMOTE_ADDR'];
        $this->user_agent = $_SERVER['HTTP_USER_AGENT'];

        if($referer = $_SERVER['HTTP_REFERER']) {

            $this->referer = $referer;
        }
    }

    public static function factory($url = null) {

        if($url === null) {

            $url = $_SERVER['REQUEST_URI'];
        }

        if(strpos($url, '://') === false) {

            return new Request\Internal($url);

        } else {

            return new Request\External($url);
        }
    }

    public static function current() {

        if(self::$instance === null) self::$instance = new self();

        return self::$instance;
    }

    public static function get($key = null, $default = null) {

        return $key === null ? $_GET : (isset($_GET[$key]) ? $_GET[$key] : $default);
    }

    public static function post($key = null, $default = null) {

        return $key === null ? $_POST : (isset($_POST[$key]) ? $_POST[$key] : $default);
    }

    public static function files($key = null, $default = null) {

        return $key === null ? $_FILES : (isset($_FILES[$key]) ? $_FILES[$key] : $default);
    }
}