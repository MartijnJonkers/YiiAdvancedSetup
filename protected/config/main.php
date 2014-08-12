<?php


// uncomment the following to define a path alias
// Yii::setPathOfAlias('local','path/to/local-folder');

// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.
return array(
	'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
	'name'=>'My Web Application',

    'theme'=>'jonkersaa',

    'sourceLanguage'=>'--',

	'preload'=>array(
        'log',
        'translate',
        'backjob',
        'efontawesome',
        'language',
        'excel'
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
        'application.modules.user.models.*',
        'application.modules.user.components.*',
        'application.modules.rights.*',
        'application.modules.rights.components.*',
        'application.modules.rights.components.dataproviders.*',
        'application.modules.translate.TranslateModule',
        'ext.Highcharts.highcharts.*',
        'ext.YiiMailer.YiiMailer',
        'ext.YiiPHPExcel.YiiPHPExcel',
        'ext.mbmenu.*',
    ),

	'modules'=>array(
        'translate',
		'gii'=>array(
			'class'=>'system.gii.GiiModule',
			'password'=>'gii',
			'ipFilters'=>array('127.0.0.1','::1'),
		),
        'user'=>array(
            'tableUsers'=>'users',
            'tableProfiles'=>'users_profiles',
            'tableProfileFields'=>'users_profilefields',
            'hash' => 'md5',# encrypting method (php hash function)
            'sendActivationMail' => true,# send activation email
            'loginNotActiv' => false,# allow access for non-activated users
            'activeAfterRegister' => false,# activate user on registration (only sendActivationMail = false)
            'autoLogin' => true,# automatically login from registration
            'registrationUrl' => array('/user/registration'),# registration path
            'recoveryUrl' => array('/user/recovery'),# recovery password path
            'loginUrl' => array('/user/login'),# login form path
            'returnUrl' => array('/user/profile'),# page after login
            'returnLogoutUrl' => array('/site/index'),# page after logout
        ),
        'rights' => array(
            'superuserName'=>'Admin', // Name of the role with super user privileges.
            'authenticatedName'=>'Authenticated',  // Name of the authenticated user role.
            'userIdColumn'=>'id', // Name of the user id column in the database.
            'userNameColumn'=>'username',  // Name of the user name column in the database.
            'enableBizRule'=>true,  // Whether to enable authorization item business rules.
            'enableBizRuleData'=>true,   // Whether to enable data for business rules.
            'displayDescription'=>true,  // Whether to use item description instead of name.
            'flashSuccessKey'=>'RightsSuccess', // Key to use for setting success flash messages.
            'flashErrorKey'=>'RightsError', // Key to use for setting error flash messages.
            'baseUrl'=>'/rights', // Base URL for Rights. Change if module is nested.
            'layout'=>'rights.views.layouts.main',  // Layout to use for displaying Rights.
            'appLayout'=>'application.views.layouts.column1', // Application layout.
            //'cssFile'=>'rights.css', // Style sheet file to use for Rights.
            'install'=>false,  // Whether to enable installer.
            'debug'=>false,
        ),
	),

	// application components
	'components'=>array(
		'user'=>array(
            'class'=>'WUser',
            'allowAutoLogin'=>true,
            'loginUrl'=>array('/user/login'),
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

        'session' => array (
            'autoStart' => true,
            'cookieMode' => 'only',
            'timeout' => 30
        ),

		'urlManager'=>array(
			'urlFormat'=>'path',
            'showScriptName' => false,
			'rules'=>array(
				'<controller:\w+>/<id:\d+>'=>'<controller>/view',
                '<controller:\w+>/<action:\w+>/<id:\d+>'=>'<controller>/<action>',
                '<controller:\w+>/<action:\w+>'=>'<controller>/<action>',
                'admin'=>'user/login',
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
            //'schemaCachingDuration' => 0,
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
                  //'fr'=>'Français',
                  //'de'=>'Deutsch',
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
        'excel' => array(
            'class' => 'ext.YiiPHPExcel.YiiPHPExcel',
            'PHPExcelPath' => dirname(__FILE__) . '/../vendor/PHPExcel-1.8.0/Classes/PHPExcel.php',
        ),
	),

	// application-level parameters that can be accessed
	'params'=>array(

	),
);