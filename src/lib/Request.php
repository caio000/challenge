<?php

namespace app\lib;

abstract class Request {

    public static function post() {
        $data = file_get_contents('php://input');
        return json_decode($data, true) ?? [];
    }

    public static function get() {
        return $_GET;
    }
}