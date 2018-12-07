<?php

namespace backend\controllers;

use Yii;
use common\models\Web;
use common\models\WebSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use common\models\WebCommon;
use yii\helpers\Json;
use common\models\User;

/**
 * WebController implements the CRUD actions for Web model.
 */
class WebController extends Controller
{


    public $enableCsrfValidation = false;

    /**
     * @inheritdoc
     */
    public function behaviors()
    {

        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],

        ];
    }

    /**
     * @return array|int|null|\yii\db\ActiveRecord
     * 判断当前站点是否在webcommon表中已创建数据
     */
    public function get_web_common_info($web_id='')
    {
        if(!empty($web_id)){
            $web_id1 =  $web_id;
        }else{
            $web_id1 = Yii::$app->session->get('web_id');
        }
        $model = new Web();

        $web_info = $model->find()->where(['id' => $web_id1])->asArray()->one();
        if (!empty($web_info)) {
            return $web_info;
        } else {
            return 0;
        }
    }

    public function actionTest1()
    {
        echo Yii::$app->test1->test(123222);
    }

    /**
     * 上传logo跟banner
     */
    public function actionImg()
    {
        $model = new Web();
        $id = Yii::$app->session->get('web_id');
        $mf = Web::findOne($id);
        //单张上传
        if (Yii::$app->request->get('par') == '1') {
            $img = Yii::$app->upload->UploadImg('logo');
//            var_dump($id);exit;
            $mf->logo = $img;
        } elseif (Yii::$app->request->get('par') == '2') {
            //多张上传
            $mf1 = $model->find()->where(['id' => $id])->asArray()->one();
//            var_dump($mf);exit;
            $img = Yii::$app->upload->UploadImg('banner');
            if (!empty($mf1['banner'])) {
                $mf->banner = $mf1['banner'] . ',' . $img;
            } else {
                $mf->banner = $img;
            }
        } else {
            echo json::encode(array('msg' => '0'));
        }
        $res = $mf->save();
        if ($res) {
            echo json::encode(array('msg' => '1'));
        } else {
            echo json::encode(array('msg' => '0'));
        }
    }

    /**
     * 删除产品列表单张照片
     */
    public function actionProductDelImg()
    {
        $model = new Web();
        $id = Yii::$app->request->get('id');
        $key = Yii::$app->request->get('key');
        $mf1 = $model->find()->where(['id' => $id])->asArray()->one();
        $img_list = explode(',', $mf1['banner']);
        unset($img_list[$key]);
        $new_str = implode(',', $img_list);
        $mf = $model->findOne($id);
        $mf->banner = $new_str;
        $res = $mf->save();
        if ($res) {
            echo json::encode(array('msg' => '1'));
        } else {
            echo json::encode(array('msg' => '0'));
        }
    }

    /**
     * logo and banner upload
     */
    public function actionLogoBanner()
    {
        $model = new Web();
        $wi = $this->get_web_common_info();
        $wi['logo'] = Yii::$app->upload->imgread($wi['logo'], 1);
        $wi['banner'] = Yii::$app->upload->imgread($wi['banner'], 2);
        return $this->render('img', [
            'data' => $wi,
            'name' => $this->web_name(),
        ]);
    }

    /**
     * 保存网站底部信息
     */
    public function actionSaveFoot()
    {
        $id = Yii::$app->session->get('web_id');
        $_POST['create_at'] = time();
        $_POST['user_add'] = yii::$app->user->identity->id;
        $_POST['ip'] = $_SERVER["REMOTE_ADDR"];
        $post = $_POST;
        unset($post['start']);
        unset($post['description']);
        unset($post['weburl']);
        unset($post['version_soft']);
        $str = json_encode($post);
        $models = Web::findOne($id);
        $models->weburl = Yii::$app->request->post('weburl', '0');
        $models->text = $str;
        $models->version = $_POST['version_soft'];
        $models->status = (int)$_POST['start'];
        $models->intro = $_POST['description'];
        $res = $models->save();
        if ($res) {
            echo json_encode(array('msg' => '1'));
        } else {
            echo json_encode(array('msg' => '2'));
        }
    }
    /**
     * 保存网站底部信息
     */
    public function actionSaveConfig()
    {
        $id = $_POST['id'];
//        $id=20;
        $_POST['create_at'] = date('Y-m-d H:i:s',time());
        $_POST['user_add'] = yii::$app->user->identity->id;
        $_POST['ip'] = $_SERVER["REMOTE_ADDR"];
        $post = $_POST;
        $str = json_encode($post);
        $models = Web::findOne($id);
        $models->config = $str;
        $res = $models->save();
        if ($res) {
            echo json_encode(array('msg' => '1'));
        } else {
            echo json_encode(array('msg' => '2'));
        }
    }

    /**
     * 网站基础信息
     */
    public function actionWebFooter()
    {
        $model = new Web();
        $web_id = Yii::$app->session->get('web_id');
        $wi = $this->get_web_common_info();
        $info = json_decode($wi['text'], true);
        $info['id'] = $wi['id'];
        $info['start'] = $wi['status'];
        $info['weburl'] = $wi['weburl'];
        $info['version_soft'] = $wi['version'];
        $info['description'] = $wi['intro'];
        $data = $info;
        return $this->render('footer', [
            'data' => $data,
            'name' => $this->web_name(),
        ]);
    }
    public function actionConfig()
    {
         echo '<script>location.href="index.php?r=web/web-config&id='.Yii::$app->session->get('web_id').'";</script>';
    }


    /**
     * 网站配置
     */
    public function actionWebConfig()
    {
        if(empty($_REQUEST['id'])){
            echo '非法操作！';exit;
        }
        $web_id = Yii::$app->session->get('web_id');
        $wi = $this->get_web_common_info($_REQUEST['id']);
        if($wi['config_status'] !=='1'){
            Yii::$app->CommonClass->BaseConfig($_REQUEST['id']);
        }
        $wi2 = $this->get_web_common_info($_REQUEST['id']);
        if(empty($wi2['config'])){
            $info1 = [];
        }else{
            $info1 = json_decode($wi2['config'], true);
        }

        $info['id'] = $wi2['id'];
        $data = array_merge($info,$info1);
        return $this->render('config', [
            'data' => $data,
            'name' => $this->web_name(),
        ]);
    }

    /**
     * @return mixed
     * 获取当前站点名称
     */
    public function web_name()
    {
        $web_id = Yii::$app->session->get('web_id');
        $res = Web::find()->where(['id' => $web_id])->asArray()->one();
        return $res['name'];
    }

    /**
     * 网站电话
     */
    public function actionWebTel()
    {
        return $this->render('tel', [
            'name' => $this->web_name(),
        ]);
    }

    /**
     * Lists all Web models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new WebSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Web model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Web model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Web();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * post提交web id
     */
    public function actionAjaxWebSession()
    {
        $session = Yii::$app->session;
        $web_id = $session->get('web_id');
        if (!empty($web_id)) {
            $session->set('web_id', $_POST['id']);
            echo json_encode(array('msg' => 1));
        }
    }

    /**
     * Updates an existing Web model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Web model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Web model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Web the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Web::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    /**
     * @desc 用户头像上传
     * @return string
     */
    public function actionUserimg()
    {
       $data= User::find()->where(['id' => Yii::$app->user->identity->id])->asArray()->one();
        return $this->render('userimg', [
             'data'=> Yii::$app->upload->imgread($data['head_img'], 1),
            'name' => $this->web_name(),
        ]);

    }

    /**
     * @desc 用户头像上传执行入库
     */
    public function actionUploaduserimg()
    {
        $img = Yii::$app->upload->UploadImg('logo');
        $id = Yii::$app->session->get('web_id');
        $uid = Yii::$app->user->identity->id;
        $User = User::findOne($uid);
        $User->head_img = $img;
        $res = $User->save();
        //单张上传
        if ($res) {
            echo json::encode(array('msg' => '1'));
        } else {
            echo json::encode(array('msg' => '0'));
        }
    }




}
