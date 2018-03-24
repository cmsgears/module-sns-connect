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
use yii\base\Component;

/**
 * SnsConnect component register the services provided by SNS Connect Module.
 *
 * @since 1.0.0
 */
class SnsConnect extends Component {

	// Global -----------------

	// Public -----------------

	// Protected --------------

	// Private ----------------

	// Constructor and Initialisation ------------------------------

    /**
     * Initialise the CMG Core Component.
     */
    public function init() {

        parent::init();

		// Register application components and objects i.e. CMG and Project
		$this->registerComponents();
    }

	// Instance methods --------------------------------------------

	// Yii parent classes --------------------

	// CMG parent classes --------------------

	// SnsLogin ------------------------------

	// Properties ----------------

	// Components and Objects ----

	/**
	 * Register the services.
	 */
	public function registerComponents() {

		// Register services
		$this->registerSystemServices();
		$this->registerEntityServices();

		// Init services
		$this->initSystemServices();
		$this->initEntityServices();
	}

	/**
	 * Registers system services.
	 */
	public function registerSystemServices() {

		$factory = Yii::$app->factory->getContainer();

		$factory->set( 'cmsgears\social\connect\common\services\interfaces\system\IFacebookService', 'cmsgears\social\connect\common\services\system\FacebookService' );
		$factory->set( 'cmsgears\social\connect\common\services\interfaces\system\IGoogleService', 'cmsgears\social\connect\common\services\system\GoogleService' );
		$factory->set( 'cmsgears\social\connect\common\services\interfaces\system\ITwitterService', 'cmsgears\social\connect\common\services\system\TwitterService' );
	}

	/**
	 * Registers entity services.
	 */
	public function registerEntityServices() {

		$factory = Yii::$app->factory->getContainer();

		$factory->set( 'cmsgears\social\connect\common\services\interfaces\entities\IFacebookProfileService', 'cmsgears\social\connect\common\services\entities\FacebookProfileService' );
		$factory->set( 'cmsgears\social\connect\common\services\interfaces\entities\IGoogleProfileService', 'cmsgears\social\connect\common\services\entities\GoogleProfileService' );
		$factory->set( 'cmsgears\social\connect\common\services\interfaces\entities\ITwitterProfileService', 'cmsgears\social\connect\common\services\entities\TwitterProfileService' );
	}

	/**
	 * Initialize system services.
	 */
	public function initSystemServices() {

		$factory = Yii::$app->factory->getContainer();

		$factory->set( 'facebookService', 'cmsgears\social\connect\common\services\system\FacebookService' );
		$factory->set( 'googleService', 'cmsgears\social\connect\common\services\system\GoogleService' );
		$factory->set( 'twitterService', 'cmsgears\social\connect\common\services\system\TwitterService' );
	}

	/**
	 * Initialize entity services.
	 */
	public function initEntityServices() {

		$factory = Yii::$app->factory->getContainer();

		$factory->set( 'facebookProfileService', 'cmsgears\social\connect\common\services\entities\FacebookProfileService' );
		$factory->set( 'googleProfileService', 'cmsgears\social\connect\common\services\entities\GoogleProfileService' );
		$factory->set( 'twitterProfileService', 'cmsgears\social\connect\common\services\entities\TwitterProfileService' );
	}

}
