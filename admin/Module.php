<?php
/**
 * This file is part of CMSGears Framework. Please view License file distributed
 * with the source code for license details.
 *
 * @link https://www.cmsgears.org/
 * @copyright Copyright (c) 2015 VulpineCode Technologies Pvt. Ltd.
 */

namespace cmsgears\social\connect\admin;

// Yii Imports
use Yii;

// CMG Imports
use cmsgears\social\connect\common\config\SnsConnectGlobal;

use cmsgears\core\common\base\Module as BaseModule;

/**
 * The Admin Module of Sns Connect Module.
 *
 * @since 1.0.0
 */
class Module extends BaseModule {

	// Variables ---------------------------------------------------

	// Globals ----------------

	// Public -----------------

	public $controllerNamespace = 'cmsgears\social\connect\admin\controllers';

	public $config = [
		SnsConnectGlobal::CONFIG_SNS_FACEBOOK,
		SnsConnectGlobal::CONFIG_SNS_GOOGLE,
		SnsConnectGlobal::CONFIG_SNS_TWITTER,
		SnsConnectGlobal::CONFIG_SNS_LINKEDIN
	];

	// Protected --------------

	// Private ----------------

	// Traits ------------------------------------------------------

	// Constructor and Initialisation ------------------------------

	public function init() {

		parent::init();

		$this->setViewPath( '@cmsgears/module-sns-connect/admin/views' );
	}

	// Instance methods --------------------------------------------

	// Yii interfaces ------------------------

	// Yii parent classes --------------------

	// CMG interfaces ------------------------

	// CMG parent classes --------------------

	// Module --------------------------------

	public function getSidebarHtml() {

		$path = Yii::getAlias( '@cmsgears' ) . '/module-sns-connect/admin/views/sidebar.php';

		return $path;
	}

}
