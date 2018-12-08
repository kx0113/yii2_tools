<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: yunwuxin <448901948@qq.com>
// +----------------------------------------------------------------------

return [
    'curl_host' => [
        ['id'=>1,'name' => 'xsk_dev_中间层', 'info' => 'http://odv2.yx.com','ext'=>''],
        ['id'=>2,'name' => 'xsk_dev_在线2.0', 'info' => 'http://scv2.yx.com','ext'=>''],
        ['id'=>3,'name' => 'test_中间层', 'info' => 'http://test-api.xplusedu.com/md_online','ext'=>''],
        ['id'=>4,'name' => 'test_在线2.0', 'info' => 'http://test-api.xplusedu.com/student','ext'=>''],
        ['id'=>5,'name' => 'prd_中间层', 'info' => ' http://api.xplusedu.com/md_online','ext'=>''],
        ['id'=>6,'name' => 'prd_在线2.0', 'info' => 'http://api.xplusedu.com/student','ext'=>''],
        ['id'=>7,'name' => 'test_pad', 'info' => 'http://test-api.xplusedu.com/171api','ext'=>''],
        ['id'=>8,'name' => 'prd_pad', 'info' => 'http://api-ios.songshuai.com/171api','ext'=>''],
        ['id'=>8,'name' => 'prd_pad2', 'info' => 'http://api-ios.songshuai.com','ext'=>''],
        ['id'=>8,'name' => 'xsk_pad', 'info' => 'http://new.online.api.com','ext'=>''],
    ],
    'curl_appid' => [
        ['id'=>1,'name' => '在线2.0', 'info' => '68943105','ext'=>''],
        ['id'=>2,'name' => '中间层', 'info' => '68943105','ext'=>''],
        ['id'=>3,'name' => 'pad', 'info' => '201808010339','ext'=>''],
        ['id'=>4,'name' => '家长端小程序', 'info' => '201809275238','ext'=>''],
        ['id'=>5,'name' => 'crm_user', 'info' => '201812039866','ext'=>''],
    ],
    'curl_secret' => [
        ['id'=>1,'name' => '在线2.0', 'info' => 'y10$hrsR0W9ytk6Eule','ext'=>''],
        ['id'=>2,'name' => '中间层', 'info' => 'Q4XEoLs2TSX2xKpKO4P','ext'=>''],
        ['id'=>3,'name' => 'pad', 'info' => 'n2p3pvkfzg0oo04gwckkcg84ggsck40','ext'=>''],
        ['id'=>4,'name' => '家长端小程序', 'info' => 'uvAv81TE7gkcmboUHsNzYEQtbKNL3Pmbhic1SoDOdk','ext'=>''],
        ['id'=>5,'name' => 'crm_user', 'info' => '4gwXpKO44X2xKXEoLPs2TSbKNL83600','ext'=>''],
    ],
    'curl_action'=>[
        [
            'text'=>'pad',
            'children'=>[
                ['id'=>10001,'name' => 'pad-登录', 'info' => '/v2/login','ext'=>''],
                ['id'=>10002,'name' => 'pad-注册', 'info' => '/v2/register','ext'=>''],
                ['id'=>10003,'name' => 'pad-crm注册', 'info' => '/v2/crmRegisterHandler','ext'=>''],
                ['id'=>10004,'name' => 'pad-获取短信验证码', 'info' => '/v2/sms_send','ext'=>''],
            ]
        ],
        [
            'text'=>'中间层',
            'children'=>[
                ['id'=>60001,'name' => '中间层-课程绑定', 'info' => '/course/courseBind','ext'=>''],
                ['id'=>60002,'name' => '中间层-课程排课', 'info' => '/course/courseSchedule','ext'=>''],
                ['id'=>60003,'name' => '中间层-我的课时', 'info' => '/lesson/courseSchedule','ext'=>''],
                ['id'=>60004,'name' => '中间层-购买记录-已完成', 'info' => '/order/getCompletedList','ext'=>''],
                ['id'=>60005,'name' => '中间层-购买记录-未完成', 'info' => '/order/getUnfinishedList','ext'=>''],
                ['id'=>60006,'name' => '中间层-获取课程绑定', 'info' => '/course/courseBind','ext'=>''],
                ['id'=>60007,'name' => '中间层-获取课程排课', 'info' => '/course/courseSchedule','ext'=>''],
            ]
        ],
        [
            'text'=>'在线2.0',
            'children'=>[
                ['id'=>80001,'name' => '在线2.0-首页菜单栏', 'info' => '/home/menuBar','ext'=>''],
                ['id'=>80002,'name' => '在线2.0-我的首页信息', 'info' => '/user/userHomeInfo','ext'=>''],
                ['id'=>80003,'name' => '在线2.0-我的基本信息', 'info' => '/user/userBaseInfo','ext'=>''],
                ['id'=>80004,'name' => '在线2.0-修改用户头像', 'info' => '/user/updateAvatar','ext'=>''],
                ['id'=>80005,'name' => '在线2.0-我的课时信息', 'info' => '/user/userTimeInfo','ext'=>''],
                ['id'=>80006,'name' => '在线2.0-我的科目列表', 'info' => '/user/userSubjectList','ext'=>''],
                ['id'=>80007,'name' => '在线2.0-首页引导模块课程信息', 'info' => '/course/userHomeCourses','ext'=>''],
                ['id'=>80008,'name' => '在线2.0-我的课程列表', 'info' => '/course/userCourseList','ext'=>''],
                ['id'=>80009,'name' => '在线2.0-我的全部课程列表', 'info' => '/course/userAllCourseList','ext'=>''],
                ['id'=>80010,'name' => '在线2.0-我的课程详情', 'info' => '/course/userCourseInfo','ext'=>''],
                ['id'=>80011,'name' => '在线2.0-学习卡知识点列表', 'info' => '/course/userKnowledgeList','ext'=>''],
                ['id'=>80012,'name' => '在线2.0-我的课时明细列表', 'info' => '/course/userCourseTimeList','ext'=>''],
                ['id'=>80013,'name' => '在线2.0-我的报告列表', 'info' => '/report/userReportList','ext'=>''],
                ['id'=>80014,'name' => '在线2.0-我的错题本列表', 'info' => '/errorBook/userErrorBookList','ext'=>''],
                ['id'=>80015,'name' => '在线2.0-我的课后作业列表', 'info' => '/homework/userHomeworkList','ext'=>''],
                ['id'=>80016,'name' => '在线2.0-我的坚果币明细列表', 'info' => '/user/userNutLogList','ext'=>''],
                ['id'=>80017,'name' => '在线2.0-我的学习概览信息', 'info' => '/statistic/userStatisticDatas','ext'=>''],
                ['id'=>80018,'name' => '在线2.0-我的学情分析信息', 'info' => '/statistic/userAnalysisDatas','ext'=>''],
                ['id'=>80019,'name' => '在线2.0-我的学习历程', 'info' => '/statistic/userHomeDatas','ext'=>''],
                ['id'=>80031,'name' => '在线2.0-学习资料列表', 'info' => '/course/getUserMaterialList','ext'=>''],
                ['id'=>80032,'name' => '在线2.0-录像列表', 'info' => '/course/getVideoList','ext'=>''],
                ['id'=>80033,'name' => '在线2.0-消息列表', 'info' => '/course/getMessageList','ext'=>''],
                ['id'=>80034,'name' => '在线2.0-我的课表', 'info' => '/course/getStudyData','ext'=>''],
                ['id'=>80035,'name' => '在线2.0-判断用户名是否可注册', 'info' => '/user/checkUname','ext'=>''],
                ['id'=>80036,'name' => '在线2.0-注册账号', 'info' => '/user/addUser','ext'=>''],
                ['id'=>80037,'name' => '在线2.0-更新基本信息', 'info' => '/user/updateUser','ext'=>''],
                ['id'=>80038,'name' => '在线2.0-账号基本信息', 'info' => '/user/getUserInfo','ext'=>''],
                ['id'=>80039,'name' => '在线2.0-用户登录', 'info' => '/user/login','ext'=>''],
                ['id'=>80040,'name' => '在线2.0-用户退出', 'info' => '/user/logout','ext'=>''],
                ['id'=>80041,'name' => '在线2.0-更新账号密码不带旧密码校验', 'info' => '/user/updateUserPasswd','ext'=>''],
                ['id'=>80042,'name' => '在线2.0-更新账号密码带旧密码校验', 'info' => '/user/updateUserPasswdCheck','ext'=>''],
                ['id'=>80043,'name' => '在线2.0-省列表', 'info' => '/currency/province','ext'=>''],
                ['id'=>80044,'name' => '在线2.0-城市列表', 'info' => '/currency/city','ext'=>''],
                ['id'=>80045,'name' => '在线2.0-区县列表', 'info' => '/currency/area','ext'=>''],
                ['id'=>80046,'name' => '在线2.0-获取城市下的合作校', 'info' => '/currency/getAreaSchoolInfo','ext'=>''],
                ['id'=>80047,'name' => '在线2.0-判断用户名是否可注册', 'info' => '/user/checkUname','ext'=>''],
                ['id'=>80048,'name' => '在线2.0-进入学习系统', 'info' => '/user/getStudyUrl','ext'=>''],
                ['id'=>80049,'name' => '在线2.0-购买记录-已完成', 'info' => '/order/getCompletedList','ext'=>''],
                ['id'=>80050,'name' => '在线2.0-购买记录-未完成', 'info' => '/order/getUnfinishedList','ext'=>''],
                ['id'=>80051,'name' => '在线2.0-我的课时-查看排课', 'info' => '/lesson/getScheduleClassInfo','ext'=>''],
                ['id'=>80052,'name' => '在线2.0-保存用户基本信息', 'info' => '/user/saveUserInfo','ext'=>''],
                ['id'=>80053,'name' => '在线2.0-获取类别列表', 'info' => '/common/getCategoryList','ext'=>''],
            ]
        ],





    ],



];



//
//1.首页菜单栏 - /home/menuBar
//2.我的首页信息 - /user/userHomeInfo
//3.我的基本信息 - /user/userBaseInfo
//4.修改用户头像 - /user/updateAvatar
//5.我的课时信息 - /user/userTimeInfo
//
//6.我的科目列表 - /user/userSubjectList
//7.首页引导模块课程信息 - /course/userHomeCourses
//8.我的课程列表 - /course/userCourseList
//9.我的全部课程列表 - /course/userAllCourseList
//10.我的课程详情 - /course/userCourseInfo
//
//11.学习卡知识点列表 - /course/userKnowledgeList
//12.我的课时明细列表 - /course/userCourseTimeList
//13.我的报告列表 - /report/userReportList
//14.我的错题本列表 - /errorBook/userErrorBookList
//15.我的课后作业列表 - /homework/userHomeworkList
//
//16.我的坚果币明细列表 - /user/userNutLogList
//17.我的学习概览信息 - /statistic/userStatisticDatas
//18.我的学情分析信息 - /statistic/userAnalysisDatas
//19.我的学习历程 - /statistic/userHomeDatas
//
//31.学习资料列表 - /course/getUserMaterialList
//32.录像列表 - /course/getVideoList
//33.消息列表 - /course/getMessageList
//34.我的课表 - /course/getStudyData
//35.判断用户名是否可注册 - /user/checkUname
//
//36.注册账号 - /user/addUser
//37.更新基本信息 - /user/updateUser
//38.账号基本信息 - /user/getUserInfo
//39.用户登录 - /user/login
//40.用户退出 - /user/logout
//
//41.更新账号密码不带旧密码校验 - /user/updateUserPasswd
//42.更新账号密码带旧密码校验 - /user/updateUserPasswdCheck
//43.省列表 - /currency/province
//44.城市列表 -  /currency/city
//45.区县列表 - /currency/area
//
//46.获取城市下的合作校 - /currency/getAreaSchoolInfo
//47.判断用户名是否可注册 - /user/checkUname
//48.进入学习系统 - /user/getStudyUrl
//49.购买记录-已完成 - /order/getCompletedList
//50.购买记录-未完成 - /order/getUnfinishedList
//
//51.我的课时-查看排课 - /lesson/getScheduleClassInfo
//52.保存用户基本信息 - /user/saveUserInfo
//53.获取类别列表 - /common/getCategoryList
