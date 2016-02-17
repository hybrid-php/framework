<?php
namespace Hybrid;

class Cookie {

	public static function set($name, $value = null, $minutes = 0, $path = '/', $domain = null) {

		setcookie($name, $value, $minutes == 0 ? 0 : time() + ($minutes * 60), $path, $domain);
	}

	public static function get($key = null, $default = null) {

		return $key === null ? $_COOKIE : (isset($_COOKIE[$key]) ? $_COOKIE[$key] : $default);
	}

	public static function remove($name, $path = null, $domain = null) {

		self::set($name, null, null, $path, $domain);
	}
}