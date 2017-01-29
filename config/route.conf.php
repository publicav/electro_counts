<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 25.01.2017
 * Time: 18:44
 */
return [
    'model' => 'models',
    'view' => 'views/template',
    'layout' => 'views/layout',
    'layoutExtension' => 'php',
    'jsonExtension' => 'json',
    'json' => 'models/json',
    'modelFileLatest' => '_d',
    'viewFileLatest' => '_v',
    'viewBlank' => 'blank',
    'modelExtension' => 'php',
    'viewExtension' => 'php',
    'headFile' => 'head.tpl',
    'menuFileReg' => 'menu_registration',
    'menuFileUnReg' => 'menu',
    'menuPath' => 'models/json',
    'menuRegExtension' => 'json',
    'LANG' => 1,
    'menuUnRegExtension' => 'json',
    'controllers' => [
        'default'   =>    [ 'controllerName' => 'controllers\ControllerMain',
                            'actions' => [
                                'auth' => 'actionIndex',
                                'nonAuth' => 'actionBlank'
                            ]
        ],
        'index'   =>      [ 'controllerName' => 'controllers\ControllerMain',
                            'actions' => [
                            'auth' => 'actionIndex',
                            'nonAuth' => 'actionBlank'
                          ]
        ],
        'help'   =>       [ 'controllerName' => 'controllers\ControllerMain',
                            'actions' => [
                                'auth' => 'actionIndex',
                                'nonAuth' => 'actionHelp'
                          ]
        ],
        'view_count'   => [ 'controllerName' => 'controllers\ControllerMain',
                            'actions' => [
                                'auth' => 'actionIndex',
                                'nonAuth' => 'actionBlank'
                            ]
        ]




    ]

];