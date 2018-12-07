<?php

namespace backend\controllers;

use Yii;
use common\models\KeyWord;
use common\models\KeyWordSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\bootstrap\Alert;

/**
 * KeyWordController implements the CRUD actions for KeyWord model.
 */
class KeyWordController extends Controller
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
     * Lists all KeyWord models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new KeyWordSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single KeyWord model.
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
     * Creates a new KeyWord model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new KeyWord();
        if ($_POST) {
            $web_id=$this->session->get('web_id');
            $find_one=$model->find()->where(['token'=>$web_id])->asArray()->all();
            if(!empty($find_one)){
               echo Alert::widget([
                    'options' => [
                        'class' => 'alert-success', //这里是提示框的class
                    ],
                    'body' => Yii::$app->getSession()->getFlash('error','每个站点只能创建一条关键词数据！'), //消息体
                ]);
                return $this->render('create', [
                    'model' => $model,
                ]);
//                return $this->redirect(['key-word/index']);
            }else{
                $model->load(Yii::$app->request->post());
                $model->add_time=time();
                $model->add_user=yii::$app->user->identity->id;
                $model->token=$web_id;
                if($model->save()){
                    return $this->redirect(['view', 'id' => $model->id]);
                }
            }
//            var_dump($find_one);exit;

        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing KeyWord model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        if ($_POST) {
            $model->load(Yii::$app->request->post());
            $model->update_time=time();
            if($model->save()){
                return $this->redirect(['view', 'id' => $model->id]);
            }
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing KeyWord model.
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
     * Finds the KeyWord model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return KeyWord the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = KeyWord::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
