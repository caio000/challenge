<?php

namespace app\controllers;

use app\lib\web\Controller;

class WebController extends Controller
{
    public function actionIndex () : void
    {
        $welcomeMessage = 'Olá mundo web!';

        $this->render('web/index', compact('welcomeMessage'));
    }
}