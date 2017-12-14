<?php

namespace app\controllers;

use Yii;

use yii\web\Controller;


class Citas2Controller extends Controller
{

    public $layout="mainTopBar";

    public function actionIndex(){
        return $this->render('citas2');
    }
}
