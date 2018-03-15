<?php
namespace cmsgears\social\connect\admin;

// Yii Imports
use \Yii;

// CMG Imports
use cmsgears\social\connect\common\config\SnsLoginGlobal;

class Module extends \cmsgears\core\common\base\Module {

    public $controllerNamespace = 'cmsgears\social\connect\admin\controllers';

	public $config 				= [ SnsLoginGlobal::CONFIG_SNS_FACEBOOK, SnsLoginGlobal::CONFIG_SNS_GOOGLE, SnsLoginGlobal::CONFIG_SNS_TWITTER ];

    public function init() {

        parent::init();

        $this->setViewPath( '@cmsgears/module-sns-login/admin/views' );
    }

	public function getSidebarHtml() {

		$path	= Yii::getAlias( "@cmsgears" ) . "/module-sns-login/admin/views/sidebar.php";

		return $path;
	}
}
