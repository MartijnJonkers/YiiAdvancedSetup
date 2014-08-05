<?php

// uncomment the following to define a path alias
// Yii::setPathOfAlias('local','path/to/local-folder');

// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.
return array(
	'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
	'name'=>'My Web Application',

    'sourceLanguage'=>'--',

	'preload'=>array(
        'log',
        'translate',
        'backjob',
        'efontawesome',
        'language'
    ),

    'aliases' => array(
        'vendor' => dirname(__FILE__) . '/../../../vendor',
    ),

    'import'=>array(
        'application.models.*',
        'application.models.forms.*',
        'application.models.tables.*',
        'application.models.data.*',
        'application.components.*',
        'application.components.core.*',
        'application.components.dataproviders.*',
        'application.modules.rights.*',
        'application.modules.rights.components.*',
        'application.modules.rights.components.dataproviders.*',
        'application.modules.translate.TranslateModule',
        'ext.YiiMailer.YiiMailer',
    ),

	'modules'=>array(
        'translate',
		'gii'=>array(
			'class'=>'system.gii.GiiModule',
			'password'=>'gii',
			'ipFilters'=>array('127.0.0.1','::1'),
		),
        'rights' => array(
            'superuserName'=>'Admin',
            'enableBizRule'=>true,
            'userIdColumn'=>'ID',
            'userNameColumn'=>'Email',
            'flashSuccessKey'=>'succes',
            'flashErrorKey'=>'error',
            'appLayout'=>'application.views.layouts.column2',
        ),
	),

	// application components
	'components'=>array(
		'user'=>array(
            'class'=>'WebUser',
            'allowAutoLogin'=>true,
            'autoUpdateFlash'=>false,
		),

        'session' => array (
            'autoStart' => true,
            'cookieMode' => 'only',
            'timeout' => 30
        ),

        'authManager'=>array(
            'class'=>'RDbAuthManager',
            'connectionID'=>'db',
            'itemTable'=>'rights_authitem',
            'itemChildTable'=>'rights_authitemchild',
            'assignmentTable'=>'rights_authassignment',
            'rightsTable'=>'rights',
            'defaultRoles'=>array('Guest'),
        ),

		'urlManager'=>array(
			'urlFormat'=>'path',
            'showScriptName' => false,
			'rules'=>array(
				'<controller:\w+>/<id:\d+>'=>'<controller>/view',
                '<controller:\w+>/<action:\w+>/<id:\d+>'=>'<controller>/<action>',
                '<controller:\w+>/<action:\w+>'=>'<controller>/<action>',
			),
		),

        'backjob'=>array(
            'class'=>'ext.Backjob.EBackJob',
            'checkAndCreateTable'=>true,
            'tableName'=>'Backjob',
            'useDb'=>true,
            'useCache'=>false,
            'errorTimeout' => 60,
        ),

        'cache'=> array(
            'class'=>'system.caching.CFileCache'
        ),

		'db'=>array(
			'connectionString' => 'mysql:host=localhost;dbname=jonkersaa',
			'emulatePrepare' => true,
			'username' => 'root',
			'password' => '',
			'charset' => 'utf8',
		),

		'errorHandler'=>array(
			'errorAction'=>'site/error',
		),

		'log'=>array(
			'class'=>'CLogRouter',
			'routes'=>array(
				array(
					'class'=>'CFileLogRoute',
					'levels'=>'error, warning',
				),
			),
		),

        'messages'=>array(
            'class'=>'CDbMessageSource',
            'sourceMessageTable' => 'text',
            'translatedMessageTable' => 'text_translation',
            'cachingDuration' => 0,
            'onMissingTranslation' => array('Ei18n', 'missingTranslation'),
        ),

        'translate'=>array(
            'class'=>'translate.components.Ei18n',
            'createTranslationTables' => true,
            'connectionID' => 'db',
            'defaultLanguage' => 'en',
            'languages' => array(
                  'nl'=>'Nederlands',
                  'en'=>'English',
                  'fr'=>'Français',
                  'de'=>'Deutsch',
            ),
        ),

        'efontawesome' => array(
            'class' => 'ext.EFontAwesome.components.EFontAwesome',
        ),
        'sass' => array(
            'class' => 'ext.Sass.SassHandler',
            'compilerPath' => dirname(__FILE__) . '/../vendor/scssphp/scss.inc.php',
            'importPaths' => array(
                dirname(__FILE__).'/../css/',
            ),
        ),
	),

	// application-level parameters that can be accessed
	'params'=>array(

	),
);