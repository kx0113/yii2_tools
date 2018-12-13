<?php

namespace backend\controllers;

use Yii;
use common\models\Signal;
use common\models\SignalSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;

/**
 * SignalController implements the CRUD actions for Signal model.
 */
class SignalController extends Controller
{
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
     * Lists all Signal models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new SignalSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Signal model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }
    public function actionTest(){
        $key='';
        $arr= [
            ['id'=>1,'name'=>'url'],
            ['id'=>2,'name'=>'action'],
            ['id'=>3,'name'=>'secret'],
            ['id'=>4,'name'=>'appid'],
        ];
        foreach($arr as $k=>$v){
            if($v['id']==$key){
                return $v['name'];
            }
        }
    }
    public function createBatch(){
        $arr=[
                ['id'=>10001,'name' => 'pad-松鼠课堂-立即试听-预约成功-即将开课', 'info' => '/v2/latestCourse','ext'=>''],
                ['id'=>10001,'name' => 'pad-学习连接跳转', 'info' => '/v2/toStudy','ext'=>''],
                ['id'=>10001,'name' => 'pad-跳转错题本', 'info' => '/v2/toErrorBook','ext'=>''],
                ['id'=>10001,'name' => 'pad-公开课-列表', 'info' => '/v2/OpenClassList','ext'=>''],
                ['id'=>10001,'name' => 'pad-公开课-详情', 'info' => '/v2/OpenClassContent','ext'=>''],
                ['id'=>10001,'name' => 'pad-公开课-预约', 'info' => '/v2/OpenClassMake','ext'=>''],
                ['id'=>10001,'name' => 'pad-我的课程-详情', 'info' => '/v2/studyPage','ext'=>''],
                ['id'=>10001,'name' => 'pad-我的课程-详情-任务卡', 'info' => '/v2/studyPageTask','ext'=>''],
                ['id'=>10001,'name' => 'pad-学习资料', 'info' => '/v2/studentData','ext'=>''],
                ['id'=>10001,'name' => 'pad-我的作业-列表', 'info' => '/v2/myTask','ext'=>''],
                ['id'=>10001,'name' => 'pad-立即试听', 'info' => '/v2/Immediate','ext'=>''],
                ['id'=>10001,'name' => 'pad-课程表－日历', 'info' => '/v2/schedule','ext'=>''],
                ['id'=>10001,'name' => 'pad-课程列表', 'info' => '/v2/courseList','ext'=>''],
                ['id'=>10001,'name' => 'pad-坚果币列表', 'info' => '/v2/RecommList','ext'=>''],
                ['id'=>10001,'name' => 'pad-crm用户同步', 'info' => '/v2/crmRegisterHandler','ext'=>''],
                ['id'=>10001,'name' => 'pad-修改密码', 'info' => '/v2/editPwd','ext'=>''],
                ['id'=>10001,'name' => 'pad-找回密码', 'info' => '/v2/forgetPwd','ext'=>''],
                ['id'=>10001,'name' => 'pad-修改手机号', 'info' => '/v2/editMobile','ext'=>''],
                ['id'=>10001,'name' => 'pad-我的资料-查询', 'info' => '/v2/getProfile','ext'=>''],
                ['id'=>10001,'name' => 'pad-我的资料-修改', 'info' => '/v2/editProfile','ext'=>''],
                ['id'=>10001,'name' => 'pad-上传图片文件', 'info' => '/v2/upImg','ext'=>''],
                ['id'=>10001,'name' => 'pad-上传头像', 'info' => '/v2/upAvatar','ext'=>''],
                ['id'=>10001,'name' => 'pad-文章创建', 'info' => '/v2/articlesAdd','ext'=>''],
                ['id'=>10001,'name' => 'pad-文章列表', 'info' => '/v2/articlesLists','ext'=>''],
        ];
        $aaa=[];
        foreach($arr as $k=>$v){
            $model2 = new Signal();
            $model2->types=2;
            $model2->name=$v['name'];
            $model2->info=$v['info'];
            $model2->create_time=date("Y-m-d H:i:s");
            $aaa[]=$model2->save();
        }

        var_dump(count($aaa));
        exit;
    }
    /**
     * Creates a new Signal model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
//        $this->createBatch();
        $model = new Signal();
        $types = ArrayHelper::map(Yii::$app->params['tools_sign_types'], 'id', 'name');
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
            'types'=>$types,
        ]);
    }

    /**
     * Updates an existing Signal model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $types = ArrayHelper::map(Yii::$app->params['tools_sign_types'], 'id', 'name');
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
            'types'=>$types,
        ]);
    }

    /**
     * Deletes an existing Signal model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Signal model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Signal the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Signal::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
}
