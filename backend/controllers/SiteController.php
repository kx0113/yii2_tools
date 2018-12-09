<?php
namespace backend\controllers;

use mdm\admin\models\searchs\User;
use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\LoginForm;
use backend\models\Menu;
use common\models\Web;
//use common\common\base;
//use common\components\base;
use backend\components\Helper;

/**
 * Site controller
 */
class SiteController extends Controller
{
    /**
     * 初始化方法
     */

    public function init(){
        parent::init();
    }


    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['login', 'error'],
                        'allow' => true,
                    ],
                    [
                        'actions' => ['logout', 'index'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['get'],
                ],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }


    public function actionIndex()
    {
        $session=Yii::$app->session;
        $user_id=Yii::$app->user->identity->getId();
        $user_info = Yii::$app->authManager->getRolesByUser($user_id);
        $menu = new Menu();
        $User_list=User::find()->where(['id'=>Yii::$app->user->identity->id])->asArray()->one();
        $menu = $menu->getLeftMenuList();
        return $this->render('index',[
            'menu' => $menu,
            'user_info'=>$User_list,
            'web_session_id'=>$session->get('web_id'),
            'user_info' => key($user_info)
        ]);
    }

    public function actionList()
    {
        return $this->render('list');
    }

    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
//            $model->loginLog();
            return $this->goBack();
        } else {
            return $this->render('login', [
                'model' => $model,
            ]);
        }
    }

    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

}
