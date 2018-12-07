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
//        var_dump($this->get_web_array());
        $session=Yii::$app->session;
        $web_id=$session->get('web_id');
        if(!empty($web_id)){

        }else{
            $session->set('web_id',$this->get_web_array());
        }
    }

    /**
     * 获取第一个web_id
     */
    private function get_web_array(){
        $web_list=Web::find()->where(['status'=>'1'])->orderBy('id ASC')->asArray()->all();
        foreach($web_list as $ke=>$ve){
            $web_list[$ke]=$ve['id'];
        }
        if(!empty($web_list)){
            return $web_list[0];
        }else{
            return '';
        }
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
//        var_dump($User_list);exit;
        $web_list=Web::find()->where(['status'=>1])->all();
        $menu = $menu->getLeftMenuList();
        //var_dump(array_key_exists('_child',$menu[0]));exit;
        return $this->render('index',[
            'menu' => $menu,
            'user_info'=>$User_list,
            'web_list'=>$web_list,
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
            $model->loginLog();
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
