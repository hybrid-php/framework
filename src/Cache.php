<?php
namespace Hybrid;

class Cache {

    public static function set($key, $data, $expires = 0) {

        return file_put_contents(TMP_PATH . '/cache/' . md5($key), gzcompress(serialize(array(time() + ($expires == 0 ? 157680000 : $expires), $data)), 9));
    }

    public static function get($key) {

        $data = unserialize(gzuncompress(file_get_contents(TMP_PATH . '/cache/' . md5($key))));

        if(time() > $data[0]) {

            self::remove($key);

            return false;
        }

        return $data[1];
    }

    public static function remove($key) {

        return unlink(TMP_PATH . '/cache/' . md5($key));
    }
}