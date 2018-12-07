<?php
return [
    'components' => [
        'db' => [
            'class' => 'yii\db\Connection',
  //          'dsn' => 'mysql:host=rm-2ze5j61837k299wd3o.mysql.rds.aliyuncs.com;dbname=yii2plus',
            'dsn' => 'mysql:host=59.110.215.21;dbname=test_shouji',
            'username' => 'root',
            'password' => '1q2w3e4r5t6y',
//            'password' => 'root',
            'charset' => 'utf8',
            'tablePrefix' => 'kx_',
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            'useFileTransport' =>false,
            'transport' => [
                'class' => 'Swift_SmtpTransport',
                'host' => 'smtp.126.com',
                'username' => 'kaixuans@126.com',
                'password' => 'xsk098',
                'port' => '465',
                'encryption' => 'ssl',
            ],
            'messageConfig'=>[
                'charset'=>'UTF-8',
                'from'=>['kaixuans@126.com'=>'凯旋科技']
            ],
        ],
        /*'authManager' => [
            'class' => 'yii\rbac\DbManager',
            'itemTable' => 'auth_item',
            'assignmentTable' => 'auth_assignment',
            'itemChildTable' => 'auth_item_child',
        ],*/
    ],

];
