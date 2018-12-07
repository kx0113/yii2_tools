<?php
namespace common\components;

use common\models\CompanyType;
use mdm\admin\models\searchs\Menu;
use Yii;
use common\models\LoginForm;
use frontend\models\PasswordResetRequestForm;
use frontend\models\ResetPasswordForm;
use frontend\models\SignupForm;
use frontend\models\ContactForm;
use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\FrontMenu;
use common\models\WebCommon;
use common\models\Product;
use common\models\News;
use common\models\NewType;
use common\models\ProductType;
use yii\data\ActiveDataProvider;
use yii\data\Pagination;
use common\models\Company;
use common\models\Web;
use common\models\FrontLog;
use common\models\Logs;
use common\models\Message;

class BaseModel {


    /**
     * 初始化函数
     * CommonSel constructor.
     */
    public function __construct() {

    }
    public function delFrontlog(){
        FrontLog::deleteAll(['like','url','.js']);
        FrontLog::deleteAll(['like','url','.png']);
        FrontLog::deleteAll(['like','url','.jpg']);
        FrontLog::deleteAll(['like','url','.gif']);
        FrontLog::deleteAll(['like','ip','127.0.0.1']);
    }
    public function AddLogsInfo($action,$message,$data,$module='1'){
        $m=new Logs();
        $m->user_id=1;
        $m->module=$module;
        $m->action=$action;
        $m->message=$message;
        $m->data=json_encode($data);
        $m->ip=Yii::$app->request->userIP;
        $m->created_at=date("Y-m-d H:i:s");
        $m->level='1';
        $m->save();
    }

    /**
     * @desc 留言
     */
    public function addMessage($data){
        $date=date('Y-m-d H:i:s',time());
        $m=new Message();
        $ip=Yii::$app->request->userIP;
        $getIpArea=$this->getIpArea($ip);
        $m->company=$data['company'];
        $m->username=$data['username'];
        $m->mobile=$data['mobile'];
        $m->qq=$data['qq'];
        $m->content=$data['content'];
        $m->ip=$ip;
        $m->create_at=$date;
        $m->area=$getIpArea['area'].'-'.$getIpArea['area2'];
        $html='公司名称：'.$data['company'].'<br>'
            .'姓名：'.$data['username'].'<br>'
            .'电话：'.$data['mobile'].'<br>'
            .'qq：'.$data['qq'].'<br>'
            .'内容：'.$data['content'].'<br>'
            .'ip：'.$ip.'<br>'
            .'ip地址：'.$getIpArea['area2'].'，'.$getIpArea['area'].'<br>'
            .'时间：'.$date;
        $res= $m->save();
        if($res){
            $mail= Yii::$app->mailer->compose();
            $mail->setTo('xushenkai99@126.com'); //要发送给那个人的邮箱
            $mail->setSubject("用户留言-".$date); //邮件主题
            $mail->setHtmlBody($html); //发送的消息内容
            $r_mail=$mail->send();
            if($r_mail){
                $s=Message::findOne($m->id);
                $s->is_email=1;
                $s->save();
            }
        }
        return $res;
    }
    /**
     * @param string $url
     * @return mixed
     */
    public function doGet($url)
    {
        //初始化
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL,$url);
        // 执行后不直接打印出来
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HEADER, false);
        // 跳过证书检查
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        // 不从证书中检查SSL加密算法是否存在
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);

        //执行并获取HTML文档内容
        $output = curl_exec($ch);

        //释放curl句柄
        curl_close($ch);

        return $output;
    }
    public function ip_sync(){
        $this->delFrontlog();
        FrontLog::deleteAll(['like','ip','127.0.0.1']);
        FrontLog::deleteAll(['like','ip','59.110.215.21']);
        FrontLog::deleteAll(['like','ip','144.52.46.76']);
        $add_log=[];
        $m=FrontLog::find()->where(['sync'=>0])->limit(100)->asArray()->all();
        foreach($m as $k=>$v){
            if(!empty($v['ip'])){
                $getIpArea=$this->getIpArea($v['ip']);
                $f_m= FrontLog::findOne($v['id']);
                #地址1
                $f_m->area=$getIpArea['area'];
                #地址2
                $f_m->area2=$getIpArea['area2'];
                #data1
                $f_m->res=$getIpArea['res'];
                #data2
                $f_m->res2=$getIpArea['res2'];
                $f_m->sync=1;
                $add_log['add_res'][]= $f_m->save();
                $add_log['add_id'][]= $v['id'];

            }
        }
//        $add_log['count']= count($add_log['add_res']);
        $this->create_log(0,'','ip_sync','ip脚本执行',$add_log);
        return $add_log;
    }
    /**
     * 写入访问日志
     */
    public function create_log($token,$form='',$action='create_log',$msg='访问日志',$data=[]){
        $ip=Yii::$app->request->userIP;
        $getIpArea=$this->getIpArea($ip);
        $m=new FrontLog();
        $m->url='http://'.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'].'?'.$_SERVER['QUERY_STRING'];
        $m->time=time();
        $m->token=$token;
        $m->form=$form;
        $m->action=$action;
        $m->msg=$msg;
		$m->date=date("Y-m-d H:i:s");
		$m->data=json_encode($data);
        #地址1
        $m->area=$getIpArea['area'];
        #地址2
        $m->area2=$getIpArea['area2'];
        $m->ip=$ip;
        #data1
        $m->res=$getIpArea['res'];
        #data2
        $m->res2=$getIpArea['res2'];
        $m->save();

    }
    public function getIpArea($ip){
        $ak = '30E10D133105cd00bf66524c4fdeb24e';
        #百度
        $res1=$this->curl('http://api.map.baidu.com/location/ip',
            ['ip' => $ip, 'ak' => $ak]
        );
        #淘宝
        $res2=$this->doGet('http://ip.taobao.com/service/getIpInfo.php?ip='.$ip);
        $res2_data=json_decode($res2,true);
        $area2=@$res2_data['data']['country']
            .'-'.@$res2_data['data']['region']
            .'-'.@$res2_data['data']['city']
            .'-' .@$res2_data['data']['isp'];

        return [
            'res'=>json_encode($res1),
            'res2'=>$res2,
            'area'=>@$res1['content']['address'].'',
            'area2'=>$area2,
        ];
    }
    /**
     * 首页产品中心
     * @param $parent 一级分类id
     * @param $token 站点id
     * @param $limit 几条数据
     */
    public function index_product_limit($parent,$token,$limit){
        #通过一级分类查询二级分类
        $ProductType=ProductType::find()->select('id')
            ->where(['parent'=>$parent,'token'=>$token])->asArray()->all();
        foreach($ProductType as $k=>$v){
            $ProductType_id[]=$v['id'];
        }
        if(!empty($ProductType_id)){
            $Product= Product::find()->where(['token'=>$token])->andWhere(['in', 'type',$ProductType_id ])
                ->orderBy(['id' => SORT_DESC])->limit($limit)->asArray()->all();
        }else{
            $Product= Product::find()->where(['token'=>$token])->andWhere(['in', 'type',0 ])
                ->orderBy(['id' => SORT_DESC])->limit($limit)->asArray()->all();
        }

        return $this->product_img_read($Product,'list');
    }

    /**
     * 处理产品图片路径
     * @param $Product 产品数组
     * @return array
     */
    function product_img_read($Product,$par=''){
        $nearr=[];
        if(!empty($Product)){
            if($par=='list'){
                #完善产品图片路径
                foreach($Product as $k=>$v){
                    $nearr[$k]=$v;
                    if(!empty($v['home_img']) or !empty($v['img_list'])){
                        $nearr[$k]['home_img']= Yii::$app->upload->imgread($v['home_img']);
                        $nearr[$k]['img_list']= Yii::$app->upload->imgread($v['img_list']);
                    }
                }
            }else{
                $nearr=$Product;
                if(!empty($nearr['home_img']) or !empty($nearr['img_list'])){
                    $nearr['home_img']=Yii::$app->upload->imgread($nearr['home_img']);
                    $nearr['img_list']= Yii::$app->upload->imgread($nearr['img_list']);
                }
            }
        }
        return $nearr;
    }
  
    public function curl($url, $post_data)
    {
        //初始化
        $curl = curl_init();
        //设置抓取的url
        curl_setopt($curl, CURLOPT_URL, $url);
        //设置头文件的信息作为数据流输出
        curl_setopt($curl, CURLOPT_HEADER, 1);
        //设置获取的信息以文件流的形式返回，而不是直接输出。
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        //设置post方式提交
        curl_setopt($curl, CURLOPT_POST, 1);//设置post数据

        curl_setopt($curl, CURLOPT_POSTFIELDS, $post_data);
        //执行命令
        $data = curl_exec($curl);
        //关闭URL请求
        curl_close($curl);
        //显示获得的数据
        $a=explode('=',$data);
        $a=substr($a[18],1);
        return json_decode($a,true);
    }
    /**
     * 首页新闻查询
     */
    public function index_news_limit($type,$token,$limit){
        return News::find()->where(['type'=>$type,'token'=>$token])->asArray()
            ->orderBy(['id' => SORT_DESC])->limit($limit)->all();
    }
    /**
     * 产品列表
     * @param $type_id 二级分类id
     * @param $token 网站id
     * @param $limit 每页多少条记录
     * @param $parent 一级分类id
     */
    public function product_list($type_id,$token,$limit,$parent){
        $data = Product::find()->andWhere(['token'=>$token]);
        $ProductType_id=[];
        $ProductType=ProductType::find()->select('id')->where(['parent'=>$parent,'token'=>$token])->asArray()->all();
        foreach($ProductType as $k=>$v){
            $ProductType_id[]=$v['id'];
        }
        #如果二级分类不为空 否则使用一级分类
        if(!empty($type_id)){
            $data->andWhere(['type'=>$type_id]);
        }else{
            $data->andWhere(['in', 'type',$ProductType_id ]);
        }
        $pages = new Pagination(['totalCount' =>$data->count(), 'pageSize' => $limit]);
        $pro_list = $data->offset($pages->offset)->limit($pages->limit)
            ->orderBy(['add_time' => SORT_DESC])->all();

        return array('res'=>$this->product_img_read($pro_list,'list'),'page'=>$pages);
    }
    /**
     * 项目
     */
    public function project($id,$token){
        return Company::find()->where(['id'=>$id,'token'=>$token])->asArray()->one();
    }
    /**
     * 新闻列表
     */
    public function news_list($type,$token,$limit){
        $data = News::find()->andWhere(['type'=>$type,'token'=>$token]);
        $pages = new Pagination(['totalCount' =>$data->count(), 'pageSize' => $limit]);
        $news = $data->offset($pages->offset)->limit($pages->limit)
            ->orderBy(['create_time' => SORT_DESC])->all();
        return array('res'=>$news,'page'=>$pages);
    }
    /**
     * 新闻单条数据
     * @param $id
     * @param $web_id
     * @return array
     */
    public function new_one_find($id,$web_id){
        return News::find()->where(['id'=>$id,'token'=>$web_id])->one();
    }
    /**
     * 前台菜单
     * @param $web_id
     * @return array
     */
    public function menu($web_id){
        $menu_list=FrontMenu::find()->where(['is_index'=>0,'token'=>$web_id])
            ->orderBy(['sort' => SORT_DESC])->asArray()->all();
        return $menu_list;
    }
    public function getWebConfig($id){
        return Web::find()->where(['id'=>$id])->asArray()->all();
    }
    /**
     * 页面公共数据组装
     * @param $token
     * @return array
     */
    public function common_data_assemble($token,$parent_id){
        $ProductType_where=' token='.$token.' AND parent = '.$parent_id;
        $ProductType= ProductType::find()->select('id,name')->where($ProductType_where)->asArray()->all();
        $web_info=Web::find()->where(['id'=>$token])->asArray()->one();
        $web_base_info=json_decode($web_info['text'],true);
        $web_base_info['description']=$web_info['intro'];
        $web_info['logo']=Yii::$app->upload->imgread($web_info['logo'],1);
        $web_info['banner']=Yii::$app->upload->imgread($web_info['banner'],2);
        $news_type= FrontMenu::find()->where(['is_main'=>1,'token'=>$token])->orderBy(['sort' => SORT_DESC])->asArray()->all();
        return array(
            'news_type'=>$news_type,
            'pro_type'=>$ProductType,
            'web_base_info'=>$web_base_info,
            'web_info'=>$web_info,
            'banner'=>explode(',',$web_info['banner']),
            'menu'=> $this->menu($token),
        );
    }
    /**
     * 查询单个产品
     * @param $id
     * @param $token
     * @return $array
     */
    public function one_product_find($id,$token){
        $pro=new Product();
        $pro_one=$pro->find()->where(['id'=>$id,'token'=>$token])->one();
        if(!empty($pro_one)){
            return $this->product_img_read($pro_one);
        }else{
            return '';
        }
    }
    /**
     * @desc 生成配置文件参数
     * @date 2018-05-19
     */

    public function BaseConfig($web_id){
        #新建产品 一级分类
        $product_parent1 =  ProductType::addProductType($web_id,$web_id.'产品1_一级分类',0);
        $product_parent_1 =  ProductType::addProductType($web_id,$web_id.'产品1_二级分类',$product_parent1);
        $product_parent2 =  ProductType::addProductType($web_id,$web_id.'产品2_一级分类',0);
        $product_parent_2 =  ProductType::addProductType($web_id,$web_id.'产品2_二级分类',$product_parent2);
        #新建产品
        Product::addProduct($web_id,$web_id.'产品1',$product_parent_1);
        Product::addProduct($web_id,$web_id.'产品2',$product_parent_2);
        #新建新闻分类
        $news_type1 =  NewType::addNewsType($web_id,$web_id.'新闻分类1');
        $news_type2 =  NewType::addNewsType($web_id,$web_id.'新闻分类2');
        #新建新闻
         News::addNews($web_id,$web_id.'新闻1',$news_type1);
         News::addNews($web_id,$web_id.'新闻2',$news_type2);
        #新建文章分类
       $article_type= CompanyType::addCompanyType($web_id,$web_id.'文章分类');
        #新闻文章1
        $article_1= Company::addCompany($web_id,$web_id.'文章1',$article_type);
        $article_2= Company::addCompany($web_id,$web_id.'文章2',$article_type);
        $article_3= Company::addCompany($web_id,$web_id.'文章3',$article_type);
        $article_4= Company::addCompany($web_id,$web_id.'文章4',$article_type);
        #其他分类
        $classs1=ProductType::addProductType($web_id,$web_id.'classs1_一级分类',0);
        ProductType::addProductType($web_id,$web_id.'classs1_二级分类',$classs1);
        $classs2=ProductType::addProductType($web_id,$web_id.'classs2_一级分类',0);
        ProductType::addProductType($web_id,$web_id.'classs2_二级分类',$classs2);
        $classs3=ProductType::addProductType($web_id,$web_id.'classs3_一级分类',0);
        ProductType::addProductType($web_id,$web_id.'classs3_二级分类',$classs3);
        $classs4=ProductType::addProductType($web_id,$web_id.'classs4_一级分类',0);
        ProductType::addProductType($web_id,$web_id.'classs4_二级分类',$classs4);
        $arr=['web_id'=>$web_id,
            'web_url'=>'index.php?r=site/',
            #产品1
            'product_title'=>'产品1',
            'product_title_eng'=>'PRODUCT',
            #产品1父级分类
            'product_parent'=>$product_parent1,
            #产品1首页显示条数
            'index_product_limit'=>'10',
            #产品1列表每页显示条数
            'product_limit'=>'12',
            #新闻1分类
            'news_type'=>$news_type1,
            #新闻标题
            'news_title'=>'新闻中心',
            'news_title_eng'=>'NEWS',
            #新闻列表每页显示条数
            'news_limit'=>'10',
            #产品2
            'product2_title'=>'产品2',
            'product2_parent'=>$product_parent2,
            #新闻首页显示条数
            'news_index_limit'=>'4',
            #文章分类
            'article_type'=>$article_type,
            #文章1
            'article_1'=>$article_1,
            'article_title_1'=>'文章1',
            'article_title_eng_1'=>'ABOUT US1',
            #文章2
            'article_2'=>$article_2,
            'article_title_2'=>'文章2',
            'article_title_eng_2'=>'ABOUT US2',
            #文章3
            'article_3'=>$article_3,
            'article_title_3'=>'文章3',
            'article_title_eng_3'=>'ABOUT US3',
            #文章4
            'article_4'=>$article_4,
            'article_title_4'=>'文章4',
            'article_title_eng_4'=>'ABOUT US4',
            #新闻2
            'news2_type'=>$news_type2,
            'news2_title'=>'新闻2',
            #其他分类1
            'classs1'=>$classs1,
            #其他分类2
            'classs2'=>$classs2,
            #其他分类3
            'classs3'=>$classs3,
            #其他分类4
            'classs4'=>$classs4,
        ];
        $models = Web::findOne($web_id);
        $models->config = json_encode($arr);
        $models->config_status = 1;
         return  $models->save();
//        var_dump($res);
    }
}
