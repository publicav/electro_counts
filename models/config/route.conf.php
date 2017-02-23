<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 25.01.2017
 * Time: 18:44
 */
return [
    'model'              => 'models',
    'view'               => 'views/template',
    'layout'             => 'views/layout',
    'layoutExtension'    => 'php',
    'jsonExtension'      => 'json',
    'json'               => 'models/json',
    'modelFileLatest'    => '_d',
    'viewFileLatest'     => '_v',
    'viewBlank'          => 'blank',
    'modelExtension'     => 'php',
    'viewExtension'      => 'php',
    'headFile'           => 'head.tpl',
    'menuFileReg'        => 'menu_registration',
    'menuFileUnReg'      => 'menu',
    'menuPath'           => 'models/json',
    'menuRegExtension'   => 'json',
    'LANG'               => 1,
    'menuUnRegExtension' => 'json',
    'controllers'        => [
        'default'    => [
            'controllerName' => 'controllers\ControllerMain',
            'actions'        => [
                'auth'    => 'actionIndex',
                'nonAuth' => 'actionBlank'
            ]
        ],
        'index'      => [
            'controllerName' => 'controllers\ControllerMain',
            'actions'        => [
                'auth'    => 'actionIndex',
                'nonAuth' => 'actionBlank'
            ]
        ],
        'help'       => [
            'controllerName' => 'controllers\ControllerMain',
            'actions'        => [
                'auth'    => 'actionIndex',
                'nonAuth' => 'actionHelp'
            ]
        ],
        'view_count' => [
            'controllerName' => 'controllers\ControllerMain',
            'actions'        => [
                'auth'    => 'actionView_count',
                'nonAuth' => 'actionBlank'
            ]
        ],
        'edit_count' => [
            'controllerName' => 'controllers\ControllerMain',
            'actions'        => [
                'auth'    => 'actionEdit_count',
                'nonAuth' => 'actionBlank'
            ]
        ],
        'load_forms' => [
            'controllerName' => 'controllers\ControllerMain',
            'actions'        => [
                'auth'    => 'actionLoad_forms',
                'nonAuth' => 'actionBlank'
            ]
        ],
        'calc_count' => [
            'controllerName' => 'controllers\ControllerMain',
            'actions'        => [
                'auth'    => 'actionCalc_count',
                'nonAuth' => 'actionBlank'
            ]
        ],
        'calcgroup'  => [
            'controllerName' => 'controllers\ControllerView',
            'actions'        => [
                'default' => 'actionCalcGroup',
            ]
        ],
        'chartgroup' => [
            'controllerName' => 'controllers\ControllerView',
            'actions'        => [
                'default' => 'actionChartGroup',
            ]
        ],
        'ajax'       => [
            'controllerName' => 'controllers\ControllerAjax',
            'actions'        => [
                'default'              => 'ajaxBlank',
                'subst_filter'         => 'ajaxSubstationFilter',           // Возвращает массив значений подстанций для фильтра
                'subst'                => 'ajaxSubstation',                 // Возвращает массив значений подстанций для формы
                'counter_filter'       => 'ajaxCounterFilter',              // Возвращает массив значений счётчиков для фильтра
                'counter'              => 'ajaxCounter',                    // Возвращает массив значений счётчиков для формы
                'getuser_all'          => 'ajaxGetUserAll',                 // Возвращает всех пользоватлей проекта
                'loadform_user'        => 'ajaxLoadFormUser',               // Загрузка данных в форму user
                'loadform_privelege'   => 'ajaxLoadFormPrivelege',          // Загрузка данных в форму привелегии
                'loadform_value'       => 'ajaxLoadFormValueCounter',       // Загрузка данных в форму редактирование счётчика
                'actionform_user'      => 'ajaxActionFormUser',             // Запись формы  редактирования пользователя
                'actionform_privelege' => 'ajaxActionFormPrivelege',        // Запись данных в формы привелегии
                'actionform_value'     => 'ajaxActionFormValueCounter',     // Запись данных в формы счётчика
                'actionform_user_add'  => 'ajaxActionFormUserAdd'           // Запись формы добавления пользоваталея
            ]
        ],

    ]

];