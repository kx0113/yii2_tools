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
//           ['id'=>1,'name' => 'xsk_dev_中间层', 'info' => 'http://odv2.yx.com','ext'=>''],
//           ['id'=>2,'name' => 'xsk_dev_在线2.0', 'info' => 'http://scv2.yx.com','ext'=>''],
//           ['id'=>3,'name' => 'test_中间层', 'info' => 'http://test-api.xplusedu.com/md_online','ext'=>''],
//           ['id'=>4,'name' => 'test_在线2.0', 'info' => 'http://test-api.xplusedu.com/student','ext'=>''],
//           ['id'=>5,'name' => 'prd_中间层', 'info' => ' http://api.xplusedu.com/md_online','ext'=>''],
//           ['id'=>6,'name' => 'prd_在线2.0', 'info' => 'http://api.xplusedu.com/student','ext'=>''],
//           ['id'=>7,'name' => 'test_pad', 'info' => 'http://test-api.xplusedu.com/171api','ext'=>''],
//           ['id'=>8,'name' => 'prd_pad', 'info' => 'http://api-ios.songshuai.com/171api','ext'=>''],
//           ['id'=>8,'name' => 'prd_pad2', 'info' => 'http://api-ios.songshuai.com','ext'=>''],
//           ['id'=>8,'name' => 'xsk_pad', 'info' => 'http://new.online.api.com','ext'=>''],
            ['id'=>1,'name' => '在线2.0', 'info' => '68943105','ext'=>''],
            ['id'=>2,'name' => '中间层', 'info' => '68943105','ext'=>''],
            ['id'=>3,'name' => 'pad', 'info' => '201808010339','ext'=>''],
            ['id'=>4,'name' => '家长端小程序', 'info' => '201809275238','ext'=>''],
            ['id'=>5,'name' => 'crm_user', 'info' => '201812039866','ext'=>''],
//           ['id'=>1,'name' => '在线2.0', 'info' => 'y10$hrsR0W9ytk6Eule','ext'=>''],
//           ['id'=>2,'name' => '中间层', 'info' => 'Q4XEoLs2TSX2xKpKO4P','ext'=>''],
//           ['id'=>3,'name' => 'pad', 'info' => 'n2p3pvkfzg0oo04gwckkcg84ggsck40','ext'=>''],
//           ['id'=>4,'name' => '家长端小程序', 'info' => 'uvAv81TE7gkcmboUHsNzYEQtbKNL3Pmbhic1SoDOdk','ext'=>''],
//           ['id'=>5,'name' => 'crm_user', 'info' => '4gwXpKO44X2xKXEoLPs2TSbKNL83600','ext'=>''],

//                ['id'=>10001,'name' => 'pad-登录', 'info' => '/v2/login','ext'=>''],
//                ['id'=>10002,'name' => 'pad-注册', 'info' => '/v2/register','ext'=>''],
//                ['id'=>10003,'name' => 'pad-crm注册', 'info' => '/v2/crmRegisterHandler','ext'=>''],
//                ['id'=>10004,'name' => 'pad-获取短信验证码', 'info' => '/v2/sms_send','ext'=>''],
//                ['id'=>60001,'name' => '中间层-课程绑定', 'info' => '/course/courseBind','ext'=>''],
//                ['id'=>60002,'name' => '中间层-课程排课', 'info' => '/course/courseSchedule','ext'=>''],
//                ['id'=>60003,'name' => '中间层-我的课时', 'info' => '/lesson/courseSchedule','ext'=>''],
//                ['id'=>60004,'name' => '中间层-购买记录-已完成', 'info' => '/order/getCompletedList','ext'=>''],
//                ['id'=>60005,'name' => '中间层-购买记录-未完成', 'info' => '/order/getUnfinishedList','ext'=>''],
//                ['id'=>60006,'name' => '中间层-获取课程绑定', 'info' => '/course/courseBind','ext'=>''],
//                ['id'=>60007,'name' => '中间层-获取课程排课', 'info' => '/course/courseSchedule','ext'=>''],
//                ['id'=>80001,'name' => '在线2.0-首页菜单栏', 'info' => '/home/menuBar','ext'=>''],
//                ['id'=>80002,'name' => '在线2.0-我的首页信息', 'info' => '/user/userHomeInfo','ext'=>''],
//                ['id'=>80003,'name' => '在线2.0-我的基本信息', 'info' => '/user/userBaseInfo','ext'=>''],
//                ['id'=>80004,'name' => '在线2.0-修改用户头像', 'info' => '/user/updateAvatar','ext'=>''],
//                ['id'=>80005,'name' => '在线2.0-我的课时信息', 'info' => '/user/userTimeInfo','ext'=>''],
//                ['id'=>80006,'name' => '在线2.0-我的科目列表', 'info' => '/user/userSubjectList','ext'=>''],
//                ['id'=>80007,'name' => '在线2.0-首页引导模块课程信息', 'info' => '/course/userHomeCourses','ext'=>''],
//                ['id'=>80008,'name' => '在线2.0-我的课程列表', 'info' => '/course/userCourseList','ext'=>''],
//                ['id'=>80009,'name' => '在线2.0-我的全部课程列表', 'info' => '/course/userAllCourseList','ext'=>''],
//                ['id'=>80010,'name' => '在线2.0-我的课程详情', 'info' => '/course/userCourseInfo','ext'=>''],
//                ['id'=>80011,'name' => '在线2.0-学习卡知识点列表', 'info' => '/course/userKnowledgeList','ext'=>''],
//                ['id'=>80012,'name' => '在线2.0-我的课时明细列表', 'info' => '/course/userCourseTimeList','ext'=>''],
//                ['id'=>80013,'name' => '在线2.0-我的报告列表', 'info' => '/report/userReportList','ext'=>''],
//                ['id'=>80014,'name' => '在线2.0-我的错题本列表', 'info' => '/errorBook/userErrorBookList','ext'=>''],
//                ['id'=>80015,'name' => '在线2.0-我的课后作业列表', 'info' => '/homework/userHomeworkList','ext'=>''],
//                ['id'=>80016,'name' => '在线2.0-我的坚果币明细列表', 'info' => '/user/userNutLogList','ext'=>''],
//                ['id'=>80017,'name' => '在线2.0-我的学习概览信息', 'info' => '/statistic/userStatisticDatas','ext'=>''],
//                ['id'=>80018,'name' => '在线2.0-我的学情分析信息', 'info' => '/statistic/userAnalysisDatas','ext'=>''],
//                ['id'=>80019,'name' => '在线2.0-我的学习历程', 'info' => '/statistic/userHomeDatas','ext'=>''],
//                ['id'=>80031,'name' => '在线2.0-学习资料列表', 'info' => '/course/getUserMaterialList','ext'=>''],
//                ['id'=>80032,'name' => '在线2.0-录像列表', 'info' => '/course/getVideoList','ext'=>''],
//                ['id'=>80033,'name' => '在线2.0-消息列表', 'info' => '/course/getMessageList','ext'=>''],
//                ['id'=>80034,'name' => '在线2.0-我的课表', 'info' => '/course/getStudyData','ext'=>''],
//                ['id'=>80035,'name' => '在线2.0-判断用户名是否可注册', 'info' => '/user/checkUname','ext'=>''],
//                ['id'=>80036,'name' => '在线2.0-注册账号', 'info' => '/user/addUser','ext'=>''],
//                ['id'=>80037,'name' => '在线2.0-更新基本信息', 'info' => '/user/updateUser','ext'=>''],
//                ['id'=>80038,'name' => '在线2.0-账号基本信息', 'info' => '/user/getUserInfo','ext'=>''],
//                ['id'=>80039,'name' => '在线2.0-用户登录', 'info' => '/user/login','ext'=>''],
//                ['id'=>80040,'name' => '在线2.0-用户退出', 'info' => '/user/logout','ext'=>''],
//                ['id'=>80041,'name' => '在线2.0-更新账号密码不带旧密码校验', 'info' => '/user/updateUserPasswd','ext'=>''],
//                ['id'=>80042,'name' => '在线2.0-更新账号密码带旧密码校验', 'info' => '/user/updateUserPasswdCheck','ext'=>''],
//                ['id'=>80043,'name' => '在线2.0-省列表', 'info' => '/currency/province','ext'=>''],
//                ['id'=>80044,'name' => '在线2.0-城市列表', 'info' => '/currency/city','ext'=>''],
//                ['id'=>80045,'name' => '在线2.0-区县列表', 'info' => '/currency/area','ext'=>''],
//                ['id'=>80046,'name' => '在线2.0-获取城市下的合作校', 'info' => '/currency/getAreaSchoolInfo','ext'=>''],
//                ['id'=>80047,'name' => '在线2.0-判断用户名是否可注册', 'info' => '/user/checkUname','ext'=>''],
//                ['id'=>80048,'name' => '在线2.0-进入学习系统', 'info' => '/user/getStudyUrl','ext'=>''],
//                ['id'=>80049,'name' => '在线2.0-购买记录-已完成', 'info' => '/order/getCompletedList','ext'=>''],
//                ['id'=>80050,'name' => '在线2.0-购买记录-未完成', 'info' => '/order/getUnfinishedList','ext'=>''],
//                ['id'=>80051,'name' => '在线2.0-我的课时-查看排课', 'info' => '/lesson/getScheduleClassInfo','ext'=>''],
//                ['id'=>80052,'name' => '在线2.0-保存用户基本信息', 'info' => '/user/saveUserInfo','ext'=>''],
//                ['id'=>80053,'name' => '在线2.0-获取类别列表', 'info' => '/common/getCategoryList','ext'=>''],
        ];
        $aaa=[];
        foreach($arr as $k=>$v){
            $model2 = new Signal();
            $model2->types=4;
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
