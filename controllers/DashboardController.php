<?php

namespace app\controllers;

use Yii;

use yii\web\Controller;


class DashboardController extends Controller
{

    public $layout="mainTopBar";

    public function actionIndex(){
        return $this->render('dashboard');
    }
}
