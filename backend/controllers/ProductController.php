<?php

namespace backend\controllers;

use common\models\ProductType;
use Yii;
use common\models\Product;
use common\models\ProductSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\Json;

/**
 * ProductController implements the CRUD actions for Product model.
 */
class ProductController extends Controller
{
    public $session;
    public $product_type_model;
    public function init(){
        parent::init();
        $this->product_type_model=new ProductType();
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
     * Lists all Product models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ProductSearch();
        $model=new Product();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'model'=>$model,
        ]);
    }

    /**
     * Displays a single Product model.
     * @param string $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * 上传照片
     */
    public function actionImg(){
        $path=Yii::getAlias('@data/upload/');
//        var_dump($path);exit;
        $model=new Product();
        $id=$_REQUEST['id'];
        $par=$_REQUEST['par'];
        $mf = Product::findOne($id);
            //单张上传
        if($par =='1'){
            $img = Yii::$app->upload->UploadImg('home_img');
//            $img = Yii::$app->imgload->UploadPhoto($model,'uploads/','home_img');
            $mf->home_img=$img;
        }elseif($par=='2'){
            //多张上传
            $img = Yii::$app->upload->UploadImg('img_list');
//            $img = Yii::$app->imgload->UploadPhoto($model,'uploads/','img_list');
            $mf1=$model->find()->where(['id'=>$id])->asArray()->one();
            if(!empty($mf1['img_list'])){
                $mf->img_list=$mf1['img_list'].','.$img;
            }else{
                $mf->img_list=$img;
            }
        }else{
            echo json::encode(array('msg'=>'0'));
            exit;
        }
        $res=$mf->save();
//        var_dump($mf);
//        exit;
        if($res){
            echo json::encode(array('msg'=>'1'));exit;
//            echo json_encode(array('msg'=>'1'));
        }else{
//            echo json_encode(array('msg'=>'0'));
            echo json::encode(array('msg'=>'0'));exit;
        }
    }

    /**
     * 删除产品列表单张照片
     */
    public function actionProductDelImg(){
        $model=new Product();
        $id=Yii::$app->request->get('id');
        $key=Yii::$app->request->get('key');
        $mf1=$model->find()->where(['id'=>$id])->asArray()->one();
        $img_list=explode(',',$mf1['img_list']);
        unset($img_list[$key]);
        $new_str=implode(',',$img_list);
        $mf=$model->findOne($id);
        $mf->img_list=$new_str;
        $res=$mf->save();
        if($res){
            echo json_encode(array('msg'=>'success'));
        }else{
            echo json_encode(array('msg'=>'error'));
        }
    }
    public function actionUpload(){
            $id=Yii::$app->request->get('id');
            $model = $this->findModel($id);
            return $this->render('upload', [
                'model' => $model,
            ]);

    }
    /**
     * Creates a new Product model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Product();
        if (Yii::$app->request->isPost) {
            $model->load(Yii::$app->request->post());
            $model->add_user=yii::$app->user->identity->id;
            $model->add_time=time();
//            $model->type=
            $model->token=$this->session->get('web_id');
            if($model->save()){
                return $this->redirect(['view', 'id' => $model->id]);
            }
        } else {
            return $this->render('create', [
                'model' => $model,
                'type_list'=>$this->product_type_model->get_type_list(),
            ]);
        }
    }

    /**
     * Updates an existing Product model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        if (Yii::$app->request->isPost) {
            $model->load(Yii::$app->request->post());
            $model->update_time=time();
            if($model->save()){
                return $this->redirect(['view', 'id' => $model->id]);
            }
        } else {
            return $this->render('update', [
                'model' => $model,
                'type_list'=>$this->product_type_model->get_type_list(),
            ]);
        }
    }

    /**
     * Deletes an existing Product model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Product model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return Product the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Product::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
