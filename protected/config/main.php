<?php

// uncomment the following to define a path alias
// Yii::setPathOfAlias('local','path/to/local-folder');

return array(
  'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
  'name'=>'RMS: Representative Management System',

  // preloading 'log' component
  'preload'=>array('log', 'user'),

  // autoloading model and component classes
  'import'=>array(
    'application.models.db.*',
    'application.models.*',
    'application.components.*',
  ),

  'modules'=>array(
    'admin',
    'frontend',
  ),
  // application components
  'components'=>array(
    'authManager' => array(
      'class' => 'PhpAuthManager',
      'defaultRoles' => array('guest'),
    ),
    'user'=>array(
      // enable cookie-based authentication
      'allowAutoLogin'=>true,
      'loginUrl' => array('/users/signin'),
      'class' => 'WebUser',
    ),
    'urlManager'=>array(
      'urlFormat'=>'path',
      'rules'=>array(
        '/' => 'frontend/index',
        'users/signin' => 'frontend/users/signin',
        'users/signout' => 'frontend/users/signout',
        'users/list' => 'frontend/users/list',
        'users/roles' => 'frontend/users/roles',
        'users/add' => 'frontend/users/add',
        'users/delete/<id:\d+>' => 'frontend/users/delete',
        'users/edit/<id:\d+>' => 'frontend/users/edit',
        'users/admin' => 'frontend/users/admin',
        'distributors/delete/<id:\d+>' => 'frontend/distributors/delete',
        'distributors/edit/<id:\d+>' => 'frontend/distributors/edit',
        'distributors/view/<id:\d+>' => 'frontend/distributors/view',
        'distributors/add' => 'frontend/distributors/add',
        'distributors/list' => 'frontend/distributors/list',
        'distributors/map' => 'frontend/distributors/map',
        'distributors/ajax' => 'frontend/distributors/ajax',
        'distributors/professional/list' => 'frontend/distributors/professionallist',
        'distributors/professional/add' => 'frontend/distributors/professionaladd',
        'distributors/professional/edit/<id:\d+>' => 'frontend/distributors/professionaledit',
        'distributors/professional/delete/<id:\d+>' => 'frontend/distributors/professionaldelete',
        'distributors/suppliers/list' => 'frontend/distributors/supplierslist',
        'distributors/suppliers/add' => 'frontend/distributors/suppliersadd',
        'distributors/suppliers/edit/<id:\d+>' => 'frontend/distributors/suppliersedit',
        'distributors/suppliers/delete/<id:\d+>' => 'frontend/distributors/suppliersdelete',
        'distributors/groups/list' => 'frontend/distributors/groupslist',
        'distributors/groups/add' => 'frontend/distributors/groupsadd',
        'distributors/groups/edit/<id:\d+>' => 'frontend/distributors/groupsedit',
        'distributors/groups/delete/<id:\d+>' => 'frontend/distributors/groupsdelete',
        'distributors/regions' => 'frontend/distributors/regions',
        'contact/create/<id:\d+>' => 'frontend/contact/create',
        'contact/list' => 'frontend/contact/list',
        'contact/upload' => 'frontend/contact/upload',
        'contact/photos/<id:\d+>' => 'frontend/contact/photos',
        'contact/view/<id:\d+>' => 'frontend/contact/view',
        'contact/edit/<id:\d+>' => 'frontend/contact/edit',
        'contact/delete/<id:\d+>' => 'frontend/contact/delete',
        'routes/ajax' => 'frontend/routes/ajax',
        'routes/add' => 'frontend/routes/add',
        'routes/edit/<id:\d+>' => 'frontend/routes/edit',
        'routes/delete/<id:\d+>' => 'frontend/routes/delete',
        'routes/list' => 'frontend/routes/list',
        'routes/map/<id:\d+>' => 'frontend/routes/map',
        'routes/global' => 'frontend/routes/global',
        'routes/start/<id:\d+>' => 'frontend/routes/start',
        'routes/complete/<id:\d+>' => 'frontend/routes/complete',
        'routes/active/<id:\d+>' => 'frontend/routes/active',
        'routes/create' => 'frontend/routes/create',
        'reports/list' => 'frontend/reports/list',
        'reports/view/<id:\d+>' => 'frontend/reports/view',
        'reports/add' => 'frontend/reports/add',
        'reports/edit/<id:\d+>' => 'frontend/reports/edit',
        'reports/delete/<id:\d+>' => 'frontend/reports/delete',
        'products/list' => 'frontend/products/list',
        'products/add' => 'frontend/products/add',
        'products/edit/<id:\d+>' => 'frontend/products/edit',
        'products/photo' => 'frontend/products/photo',
        'products/delete/<id:\d+>' => 'frontend/products/delete',
        'category/list' => 'frontend/category/list',
        'category/add' => 'frontend/category/add',
        'category/edit/<id:\d+>' => 'frontend/category/edit',
        'orders/list' => 'frontend/orders/list',
        'orders/add/<id:\d+>' => 'frontend/orders/add',
        'orders/ajax' => 'frontend/orders/ajax',
        'orders/edit/<id:\d+>' => 'frontend/orders/edit',
        'orders/view/<id:\d+>' => 'frontend/orders/view',
        'orders/submit/<id:\d+>' => 'frontend/orders/submit',
        'templates/list' => 'frontend/templates/list',
        'templates/add' => 'frontend/templates/add',
        'templates/ajax' => 'frontend/templates/ajax',
        'templates/edit/<id:\d+>' => 'frontend/templates/edit',
        '<module:\w+>/<controller:\w+>/<id:\d+>'=>'<module>/<controller>/show',
        '<module:\w+>/<controller:\w+>/<action:\w+>/<id:\d+>'=>'<module>/<controller>/<action>',
        '<module:\w+>/<controller:\w+>/<action:\w+>'=>'<module>/<controller>/<action>',
      ),
    ),
    // uncomment the following to use a MySQL database
    'db'=>array(
      'connectionString' => 'mysql:host=localhost;dbname=medicalv_reps',
      'emulatePrepare' => true,
      'username' => 'root',
      'password' => 'Br82Za22z',
      'charset' => 'utf8',
      'schemaCachingDuration'  => 3600,
      'queryCacheID'           => 'cache',
    ),
    'errorHandler'=>array(
      'errorAction'=>'frontend/error/error',
    ),
    'log'=>array(
      'class'=>'CLogRouter',
      'routes'=>array(
        array(
          'class'=>'CFileLogRoute',
          'levels'=>'error, warning',
        ),
        // uncomment the following to show log messages on web pages
        /*
        array(
          'class'=>'CWebLogRoute',
        ),
        */
      ),
    ),
    'viewRenderer'=>array(
      'class'=>'ext.phamlp.Haml',
      // delete options below in production
      'ugly' => false,
      'style' => 'nested',
      'debug' => 0,
      'cache' => false,
      ),
      'email'=>array(
        'class'=>'application.extensions.email.Email',
        'delivery'=>'php', //Will use the php mailing function.  
        //May also be set to 'debug' to instead dump the contents of the email into the view
      ),
  ),

  'defaultController' => 'frontend/index',

  // application-level parameters that can be accessed
  // using Yii::app()->params['paramName']
  'params' => array(
    // this is used in contact page
    'adminEmail'      => 'charles@medicalvitadiet.com.au',
    'appName'         => 'RMS',
    'host'            => 'http://medicalvitadiet.com.au/rms/',
  ),
  'sourceLanguage' => 'en',
);