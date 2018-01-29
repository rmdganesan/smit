<?php
$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/../../common/config/params-local.php'),
    //require_once(__DIR__ . '/params.php'),
    require_once(__DIR__ . '/params-local.php')
);

return [
    'id' => 'app-api',
    'basePath' => dirname(__DIR__),    
    'bootstrap' => ['log'],
    'modules' => [
        'api' => [
            'basePath' => 'app/modules/v1',
            'class' => 'api\modules\v1\Module'
        ]
    ],
    'components' => [        
        'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => false,
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'urlManager' => [
            'enablePrettyUrl' => true,
            'enableStrictParsing' => true,
            'showScriptName' => false,
            'rules' => [

                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => 'api/users',
                    'extraPatterns' => [
                            'PUT,POST  register' => 'register',
                            'PUT,POST  login' => 'login',
                            'GET  index' => 'index',
                            'GET  logout_other_sessions' => 'logout-other-sessions',
                        ],
                ],
              
            ],        
        ],
        'request' => [
    'parsers' => [
        'application/json' => 'yii\web\JsonParser',
    ]
]
    ],
    'params' => $params,
];



