<?php
return [
    'timeZone' => 'Asia/Shanghai',
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'components' => [
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'upload'=>[
            'class'=>'common\components\Upload'
        ],
        'CommonClass'=>[
            'class'=>'common\components\BaseModel'
        ],
        'Common'=>[
            'class'=>'common\components\Common'
        ],
    ],
];
