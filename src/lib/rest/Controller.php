<?php

namespace app\lib\rest;

use app\lib\Identity;

class Controller {

    public function isAuthenticated() {
        $user = Identity::getIdentity();
        if (!$user) {
            Response::sendResponse(Response::UNAUTHORIZED, Response::UNAUTHORIZED);
        }
    }
}