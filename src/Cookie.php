<?php
namespace Hybrid;

class Cookie {

    public static function set($name, $value = null, $expires = 0, $path = '/', $domain = null, $secure = null, $httpOnly = null) {

        return setcookie($name, $value, $expires == 0 ? 0 : time() + $expires, $path, $domain, $secure, $httpOnly);
    }

    public static function get($key = null, $default = null) {

        return $key === null ? $_COOKIE : (isset($_COOKIE[$key]) ? $_COOKIE[$key] : $default);
    }

    public static function remove($name, $path = null, $domain = null, $secure = null, $httpOnly = null) {

        return self::set($name, null, -86400, $path, $domain, $secure, $httpOnly);
    }
}