<?php

namespace backend\controllers;

use Yii;
use yii\filters\AccessControl;
use common\models\Behavior;
use common\models\SearchBehavior;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * BehaviorController implements the CRUD actions for Behavior model.
 */
class BehaviorController extends Controller
{
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
                        'actions' => ['add1','add2','add3'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Behavior models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new SearchBehavior();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Behavior model.
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
     * Creates a new Behavior model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Behavior();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Behavior model.
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
     * Deletes an existing Behavior model.
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
     * Finds the Behavior model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Behavior the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Behavior::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function createRandomStr($length){
        $str = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';//62个字符
        $strlen = 62;
        while($length > $strlen){
            $str .= $str;
            $strlen += 62;
        }
        $str = str_shuffle($str);
        return substr($str,0,$length);
    }

    public function actionAdd1()
    {
//        http://test.xsk.dev/backend/web/index.php?r=behavior/add1&id=2&key=20000
        $count=trim($_GET['id']);
        $key=trim($_GET['key']);
        $arr=[];
        $field = ['uid', 'behavior', 'time', 'url', 'status', 'ip', 'tid'];
        $k=(int)$key;
        for ($i=1;$i<$count;$i++){
            $k++;
            $arr[]=[
                'uid'=>$k,
                'behavior'=>'用户行为-'.$k,
                'time'=>date('Y-m-d H:i:s'),
                'url'=>'www.'.$this->createRandomStr(8).'.com',
                'status'=>rand(1,9),
                'ip'=>$this->createRandomStr(20),
                'tid'=>rand(11111111,99999999),
            ];
        }
        $model = new Behavior();
        foreach($arr as $v)
        {
            $_model = clone $model;
            $_model->setAttributes($v);
            $res[]=$_model->save();
        }
        echo json_encode($res);
    }
    public function actionAdd2()
    {
//        http://test.xsk.dev/backend/web/index.php?r=behavior/add1&id=2&key=20000
        $count=trim($_GET['id']);
        $key=trim($_GET['key']);
        $arr=[];
        $field = ['uid', 'behavior', 'time', 'url', 'status', 'ip', 'tid'];
        $k=(int)$key;
        for ($i=1;$i<$count;$i++){
            $k++;
            $arr[]=[
                'uid'=>$k,
                'behavior'=>'用户行为-'.$k,
                'time'=>date('Y-m-d H:i:s'),
                'url'=>'www.'.$this->createRandomStr(8).'.com',
                'status'=>rand(1,9),
                'ip'=>$this->createRandomStr(20),
                'tid'=>rand(11111111,99999999),
            ];
        }
        $model = new Behavior();
        foreach($arr as $v)
        {
            $_model = clone $model;
            $_model->setAttributes($v);
            $res[]=$_model->save();
        }
        echo json_encode($res);
    }
    public function actionAdd3()
    {
//        http://test.xsk.dev/backend/web/index.php?r=behavior/add1&id=2&key=20000
        $count=trim($_GET['id']);
        $key=trim($_GET['key']);
        $arr=[];
        $field = ['uid', 'behavior', 'time', 'url', 'status', 'ip', 'tid'];
        $k=(int)$key;
        for ($i=1;$i<$count;$i++){
            $k++;
            $arr[]=[
                'uid'=>$k,
                'behavior'=>'用户行为-'.$k,
                'time'=>date('Y-m-d H:i:s'),
                'url'=>'www.'.$this->createRandomStr(8).'.com',
                'status'=>rand(1,9),
                'ip'=>$this->createRandomStr(20),
                'tid'=>rand(11111111,99999999),
            ];
        }
        $model = new Behavior();
        foreach($arr as $v)
        {
            $_model = clone $model;
            $_model->setAttributes($v);
            $res[]=$_model->save();
        }
        echo json_encode($res);
    }
}
