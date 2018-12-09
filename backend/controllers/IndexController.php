<?php

namespace backend\controllers;
use backend\models\Log;
use common\models\Web;
use backend\models\Menu;
use backend\models\PasswordForm;
use yii\data\Pagination;

use Yii;

class IndexController extends \yii\web\Controller
{
    public $enableCsrfValidation = false;

    public function init(){
        parent::init();

    }
    public function actionIndex()
    {
        return $this->render('index');
    }


    public function actionWelcome()
    {
        $session=Yii::$app->session;
        //最近登录记录
        $web_list=Web::find()->where(['status'=>1])->all();
//        $log = Log::find()->limit(30)->orderBy('id desc')->asArray()->all();
        return $this->render('welcome',[
//            'log' => $log,
            'web_session_id'=>$session->get('web_id'),
            'web_list'=>$web_list,
        ]);
    }
}

