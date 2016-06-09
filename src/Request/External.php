<?php
namespace Hybrid\Request;

class External {

    private $options = array(
        CURLOPT_FOLLOWLOCATION => 1,
        CURLOPT_RETURNTRANSFER => 1
    );

    public function __construct($url) {

        $this->url = $url;
    }

    public function __toString() {

        return $this->send();
    }

    public function method($method) {

        $this->method = strtoupper($method);

        return $this;
    }

    public function headers($headers) {

        foreach($headers as $name => $value) {

            $header[] = $name . ': ' . $value;
        }

        $this->options[CURLOPT_HTTPHEADER] = $header;

        return $this;
    }

    public function cookies($cookies) {

        $this->options[CURLOPT_COOKIE] = http_build_query($cookies, '', '; ');

        return $this;
    }

    public function params($params) {

        if(is_array($params)) {

            $params = http_build_query($params);
        }

        if($this->method == 'GET') {

            $this->url .= (strpos($this->url, '?') === false ? '?' : ':') . $params;

        } else {

            $this->options[CURLOPT_POSTFIELDS] = $params;
        }

        return $this;
    }

    public function options($options) {

        $this->options += $options;

        return $this;
    }

    public function json() {

        return json_decode($this->send(), 1);
    }

    public function download($path) {

        $fp = fopen($path, 'w+');

        $this->options[CURLOPT_FILE] = $fp;
        $this->send();

        fclose($fp);
    }

    public function send() {

        $ch = curl_init($this->url);

        if(strpos($this->url, 'https') === 0) {

            $this->options[CURLOPT_SSL_VERIFYPEER] = 0;
        }

        curl_setopt_array($ch, $this->options);

        $response = curl_exec($ch);
        curl_close($ch);

        return $response;
    }
}