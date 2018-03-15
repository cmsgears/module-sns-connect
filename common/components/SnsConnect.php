<?php
namespace cmsgears\social\connect\common\components;

// Yii Imports
use Yii;
use yii\base\Component;

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

		$factory->set( 'cmsgears\social\connect\common\services\interfaces\entities\IFacebookProfileService', 'cmsgears\social\connect\common\services\entities\FacebookProfileService' );
		$factory->set( 'cmsgears\social\connect\common\services\interfaces\entities\IGoogleProfileService', 'cmsgears\social\connect\common\services\entities\GoogleProfileService' );
		$factory->set( 'cmsgears\social\connect\common\services\interfaces\entities\ITwitterProfileService', 'cmsgears\social\connect\common\services\entities\TwitterProfileService' );
	}

	public function initEntityServices() {

		$factory = Yii::$app->factory->getContainer();

		$factory->set( 'facebookProfileService', 'cmsgears\social\connect\common\services\entities\FacebookProfileService' );
		$factory->set( 'googleProfileService', 'cmsgears\social\connect\common\services\entities\GoogleProfileService' );
		$factory->set( 'twitterProfileService', 'cmsgears\social\connect\common\services\entities\TwitterProfileService' );
	}
}
