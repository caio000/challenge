<?php

namespace app\controllers;

use Exception;
use app\lib\Request;
use app\lib\Security;
use app\models\Users;
use app\models\Drinks;
use app\lib\db\Connection;
use app\lib\rest\Response;
use app\lib\rest\Controller;
use app\lib\exception\ValidateException;
use app\lib\Identity;

class UserController extends Controller {

    public function actionHistory()
    {
        $id = Request::get()['id'];

        try {
            $user = Users::findOne($id);
            if (!$user) throw new ValidateException('User not exist', 400);

            $drinks = $user->getDrinks();

            $response = Response::OK;
            $dataReturn = array_map(function ($drink) {
                return [
                    'datetime' => $drink->date_insert,
                    'drink_ml' => $drink->drink_ml,
                ];
            }, $drinks);
        } catch (ValidateException $e) {
            $response = Response::BAD_REQUEST;
            $dataReturn = $response;
            $dataReturn['message'] = $e->getMessage();
        } catch (Exception $e) {
            $response = Response::INTERNAL_SERVER_ERROR;
            $dataReturn = $response;
            $dataReturn['message'] = $e->getMessage();
        } finally {
            Response::sendResponse($response, $dataReturn);
        }
    }

    public function actionUpdate()
    {
        try {
            $data['id'] = Request::get()['id'];
            $data = array_merge($data, Request::post());

            if (!empty($data['password'])) {
                $data['password'] = Security::generateHash($data['password']);
            }

            $user = Users::findOne($data['id']);
            if ($user->token !== Identity::getToken()) throw new Exception("can not execute this action", 500);
            $user->load($data);
            $user->save();

            $response = Response::OK;
            $dataReturn = $response;
        } catch (Exception $e) {
            $response = Response::INTERNAL_SERVER_ERROR;
            $dataReturn = $response;
            $dataReturn['message'] = $e->getMessage();
        } finally {
            Response::sendResponse($response, $dataReturn);
        }
    }

    public function actionIndex()
    {
        $users = Users::findAll();

        Response::sendResponse(Response::OK, $users);
    }

    public function actionDelete(){
        try {
            Connection::getInstance()->beginTransaction();
            $data = Request::get();
    
            // validate
            if (empty($data['id'])) throw new ValidateException("id_user is required", 400);
            
            $user = Users::findOne($data['id']);
            if (!$user) throw new Exception('User not exist', 500);
            if ($user->token !== Identity::getToken()) throw new Exception("can not execute this action", 500);
            $user->delete();

            $response = Response::OK;
            $dataReturn = $response;

            Connection::getInstance()->commit();

        } catch (ValidateException $e ) {
            Connection::getInstance()->rollBack();
            $response = Response::BAD_REQUEST;
            $dataReturn = [
                'name' => 'Bad Request',
                'status' => $e->getCode(),
                'message' => $e->getMessage(),
            ];
        } catch (Exception $e) {
            Connection::getInstance()->rollBack();
            $response = Response::INTERNAL_SERVER_ERROR;
            $dataReturn = [
                'name' => 'Internal Server Error',
                'status' => $e->getCode(),
                'message' => $e->getMessage(),
            ];
        } finally {
            Response::sendResponse($response, $dataReturn);
        }
        
    }

    public function actionDrink () {

        $data['id_user'] = Request::get()['id'];
        $data['drink_ml'] = Request::post()['drink_ml'] ?? null;

        try {
            $drink = new Drinks;
            $drink->load($data);
            $user = Users::findOne($drink->id_user);
    
            // validate
            if (empty($drink->id_user)) throw new ValidateException("id_user is required", 400);
            if (empty($drink->drink_ml)) throw new ValidateException("drink_ml is required", 400);
            if (!$user) throw new ValidateException("Invalid user", 400);

            $drink->save();
            

            $response = Response::CREATED;
            $dataReturn = [
                'id' => $user->id,
                'email' => $user->email,
                'name' => $user->name,
                'drink_counter' => count($user->getDrinks())
            ];

        } catch (ValidateException $e) {
            $response = Response::BAD_REQUEST;
            $dataReturn = [
                'name' => 'Bad Request',
                'status' => $e->getCode(),
                'message' => $e->getMessage(),
            ];
        } catch (Exception $e) {
            $response = Response::INTERNAL_SERVER_ERROR;
            $dataReturn = [
                'name' => 'Internal Server Error',
                'status' => $e->getCode(),
                'message' => $e->getMessage(),
            ];
        } finally {
            Response::sendResponse($response, $dataReturn);
        }
    }

    public function actionGetOne() {
        $data = Request::get();

        $user = Users::findOne($data['id']);
        if ($user) {
            $response = [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'drink_counter' => count($user->getDrinks()),
            ];
        } else {
            $response = [];
        }

        Response::sendResponse(Response::OK, $response);
    }

    public function actionCreate(){
        try {
            
            $data = Request::post();
            if (!$data) throw new ValidateException("Error Processing Request", 400);

            $user = new Users;
            $user->load($data);

            // validate
            if (empty($user->email)) throw new ValidateException("Email is required", 400);
            if (empty($user->name)) throw new ValidateException("Name is required", 400);
            if (empty($user->password)) throw new ValidateException("Password is required", 400);

            $user->password = Security::generateHash($user->password);
            $user->token = Security::generateToken();
            $user->save();


            $response = Response::CREATED;
            $dataReturn = $response;
        } catch(ValidateException $e) {
            $response = Response::BAD_REQUEST;
            $dataReturn = [
                'name' => 'Bad Request',
                'status' => $e->getCode(),
                'message' => $e->getMessage(),
            ];
        } catch (Exception $e) {
            $response = Response::INTERNAL_SERVER_ERROR;
            $dataReturn = [
                'name' => 'Internal Server Error',
                'status' => $e->getCode(),
                'message' => $e->getMessage(),
            ];
        } finally {
            Response::sendResponse($response, $dataReturn);
        }
    }
}