<?php

namespace backend\controllers;

use Yii;
use common\models\CompanyType;
use common\models\CompanyTypeSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use common\models\Config;
use yii\bootstrap\Alert;

/**
 * CompanyTypeController implements the CRUD actions for CompanyType model.
 */
class CompanyTypeController extends Controller
{
    public $session;
    public function init(){
        parent::init();
        $this->session=Yii::$app->session;
    }
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
     * Lists all CompanyType models.
     * @return mixed
     */
    public function actionIndex()
    {
        $model=new CompanyType();
        $searchModel = new CompanyTypeSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'model'=>$model,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single CompanyType model.
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
     * Creates a new CompanyType model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new CompanyType();
        $web_id=$this->session->get('web_id');
        if ($_POST) {
            //统计全部分类总条数
            $count_news_type=$model->find()->where(['token'=>$web_id])->count();
            //查询配置文件限制条数
            $find_config=Config::find()->select('limit')->where(['params'=>'company-type'])->asArray()->one();
            if($count_news_type < $find_config['limit']){
                $model->load(Yii::$app->request->post());
                $model->token=$web_id;
                $model->create_at=time();
                $model->user_id=yii::$app->user->identity->id;
                if($model->save()){
                    return $this->redirect(['view', 'id' => $model->id]);
                }
            }else{
                echo Alert::widget([
                    'options' => [
                        'class' => 'alert-success', //这里是提示框的class
                    ],
                    'body' => Yii::$app->getSession()->getFlash('error','分类已达上限！'), //消息体
                ]);
                return $this->render('create', [
                    'model' => $model,
                ]);
            }
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing CompanyType model.
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
     * Deletes an existing CompanyType model.
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
     * Finds the CompanyType model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return CompanyType the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = CompanyType::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
