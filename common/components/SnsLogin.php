<?php
namespace cmsgears\social\login\common\components;

// Yii Imports
use \Yii;
use yii\di\Container;

// CMG Imports
use cmsgears\core\common\config\CoreGlobal;

class SnsLogin extends \yii\base\Component {

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

	// Properties

	// Components and Objects

	public function registerComponents() {

		// Register services
		$this->registerEntityServices();

		// Init services
		$this->initEntityServices();
	}

	public function registerEntityServices() {

		$factory = Yii::$app->factory->getContainer();

		$factory->set( 'cmsgears\social\login\common\services\interfaces\entities\IFacebookProfileService', 'cmsgears\social\login\common\services\entities\IFacebookProfileService' );
		$factory->set( 'cmsgears\social\login\common\services\interfaces\entities\IGoogleProfileService', 'cmsgears\social\login\common\services\entities\IGoogleProfileService' );
		$factory->set( 'cmsgears\social\login\common\services\interfaces\entities\ITwitterProfileService', 'cmsgears\social\login\common\services\entities\ITwitterProfileService' );
	}

	public function initEntityServices() {

		$factory = Yii::$app->factory->getContainer();

		$factory->set( 'facebookProfileService', 'cmsgears\social\login\common\services\entities\IFacebookProfileService' );
		$factory->set( 'googleProfileService', 'cmsgears\social\login\common\services\entities\IGoogleProfileService' );
		$factory->set( 'twitterProfileService', 'cmsgears\social\login\common\services\entities\ITwitterProfileService' );
	}
}
