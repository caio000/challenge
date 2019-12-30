<?php

namespace app\controllers;

use app\lib\exception\ValidateException;
use app\lib\Request;
use app\lib\rest\Controller;
use app\lib\rest\Response;
use app\lib\Security;
use app\models\Drinks;
use app\models\Users;
use Exception;

class HomeController extends Controller {

    public function actionLogin ()
    {

        try {
            $data = Request::post();
    
            // validate
            if (empty($data['email'])) throw new ValidateException('Email is required', 400);
            if (empty($data['password'])) throw new ValidateException('Password is required', 400);
    
            $user = Users::getUserByEmail($data['email']);
            if (!$user) throw new ValidateException("email or password is incorrect", 400);
            $isPasswordValid = Security::verifyPasswordHash($data['password'], $user->password);
            if (!$isPasswordValid) throw new ValidateException("email or password is incorrect", 400);
            
            $user->drink_counter = count($user->getDrinks());

            $response = Response::OK;
            $dataReturn = [
                'token' => $user->token,
                'id' => $user->id,
                'email' => $user->email,
                'name' => $user->name,
                'drink_counter' => count($user->getDrinks())

            ];
        } catch (ValidateException $e) {
            $dataReturn = $response = Response::BAD_REQUEST;
            $dataReturn['message'] = $e->getMessage();

        } catch (Exception $e) {

        } finally {
            Response::sendResponse($response, $dataReturn);
        }
    }

    public function actionRanking ()
    {
        Response::sendResponse(Response::OK, Drinks::getRanking());
    }
}