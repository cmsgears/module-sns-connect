<?php
namespace cmsgears\social\connect\admin;

// Yii Imports
use \Yii;

// CMG Imports
use cmsgears\social\connect\common\config\SnsConnectGlobal;

class Module extends \cmsgears\core\common\base\Module {

    public $controllerNamespace = 'cmsgears\social\connect\admin\controllers';

	public $config 				= [ SnsConnectGlobal::CONFIG_SNS_FACEBOOK, SnsConnectGlobal::CONFIG_SNS_GOOGLE, SnsConnectGlobal::CONFIG_SNS_TWITTER ];

    public function init() {

        parent::init();

        $this->setViewPath( '@cmsgears/module-sns-connect/admin/views' );
    }

	public function getSidebarHtml() {

		$path	= Yii::getAlias( "@cmsgears" ) . "/module-sns-connect/admin/views/sidebar.php";

		return $path;
	}
}
