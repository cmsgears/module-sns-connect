<?php
/**
 * This file is part of CMSGears Framework. Please view License file distributed
 * with the source code for license details.
 *
 * @link https://www.cmsgears.org/
 * @copyright Copyright (c) 2015 VulpineCode Technologies Pvt. Ltd.
 */

namespace cmsgears\social\connect\common\components;

// Yii Imports
use Yii;

// CMG Imports
use cmsgears\core\common\base\Component;

/**
 * The SnsConnect Factory component initialise the services available in SnsConnect Module.
 *
 * @since 1.0.0
 */
class Factory extends Component {

	// Global -----------------

	// Public -----------------

	// Protected --------------

	// Private ----------------

	// Constructor and Initialisation ------------------------------

	public function init() {

		parent::init();

		// Register services
		$this->registerServices();

		// Register service alias
		$this->registerServiceAlias();
	}

	// Instance methods --------------------------------------------

	// Yii parent classes --------------------

	// CMG parent classes --------------------

	// Factory -------------------------------

	public function registerServices() {

		$this->registerSystemServices();
		$this->registerEntityServices();
	}

	public function registerServiceAlias() {

		$this->registerSystemAliases();
		$this->registerEntityAliases();
	}

	/**
	 * Registers system services.
	 */
	public function registerSystemServices() {

		$factory = Yii::$app->factory->getContainer();

		$factory->set( 'cmsgears\social\connect\common\services\interfaces\system\IFacebookService', 'cmsgears\social\connect\common\services\system\FacebookService' );
		$factory->set( 'cmsgears\social\connect\common\services\interfaces\system\IGoogleService', 'cmsgears\social\connect\common\services\system\GoogleService' );
		$factory->set( 'cmsgears\social\connect\common\services\interfaces\system\ITwitterService', 'cmsgears\social\connect\common\services\system\TwitterService' );
		$factory->set( 'cmsgears\social\connect\common\services\interfaces\system\ILinkedinService', 'cmsgears\social\connect\common\services\system\LinkedinService' );
	}

	/**
	 * Registers entity services.
	 */
	public function registerEntityServices() {

		$factory = Yii::$app->factory->getContainer();

		$factory->set( 'cmsgears\social\connect\common\services\interfaces\entities\IFacebookProfileService', 'cmsgears\social\connect\common\services\entities\FacebookProfileService' );
		$factory->set( 'cmsgears\social\connect\common\services\interfaces\entities\IGoogleProfileService', 'cmsgears\social\connect\common\services\entities\GoogleProfileService' );
		$factory->set( 'cmsgears\social\connect\common\services\interfaces\entities\ITwitterProfileService', 'cmsgears\social\connect\common\services\entities\TwitterProfileService' );
		$factory->set( 'cmsgears\social\connect\common\services\interfaces\entities\ILinkedinProfileService', 'cmsgears\social\connect\common\services\entities\LinkedinProfileService' );
	}

	/**
	 * Registers system aliases.
	 */
	public function registerSystemAliases() {

		$factory = Yii::$app->factory->getContainer();

		$factory->set( 'facebookService', 'cmsgears\social\connect\common\services\system\FacebookService' );
		$factory->set( 'googleService', 'cmsgears\social\connect\common\services\system\GoogleService' );
		$factory->set( 'twitterService', 'cmsgears\social\connect\common\services\system\TwitterService' );
		$factory->set( 'linkedinService', 'cmsgears\social\connect\common\services\system\LinkedinService' );
	}

	/**
	 * Registers entity aliases.
	 */
	public function registerEntityAliases() {

		$factory = Yii::$app->factory->getContainer();

		$factory->set( 'facebookProfileService', 'cmsgears\social\connect\common\services\entities\FacebookProfileService' );
		$factory->set( 'googleProfileService', 'cmsgears\social\connect\common\services\entities\GoogleProfileService' );
		$factory->set( 'twitterProfileService', 'cmsgears\social\connect\common\services\entities\TwitterProfileService' );
		$factory->set( 'linkedinProfileService', 'cmsgears\social\connect\common\services\entities\LinkedinProfileService' );
	}

}
