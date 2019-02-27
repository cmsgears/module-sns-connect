<?php
/**
 * This file is part of CMSGears Framework. Please view License file distributed
 * with the source code for license details.
 *
 * @link https://www.cmsgears.org/
 * @copyright Copyright (c) 2015 VulpineCode Technologies Pvt. Ltd.
 */

namespace cmsgears\social\connect\common\config;

// Yii Imports
use yii\helpers\Url;

// CMG Imports
use cmsgears\core\common\config\Properties;

/**
 * FacebookProperties provide methods to access the properties specific to Facebook application for login.
 *
 * @since 1.0.0
 */
class FacebookProperties extends Properties {

	// Variables ---------------------------------------------------

	// Globals ----------------

	const PROP_ACTIVE			= 'active';

	const PROP_APP_ID			= 'app_id';

	const PROP_APP_SECRET		= 'app_secret';

	const PROP_REDIRECT_URI		= 'redirect_uri';

	// Public -----------------

	// Protected --------------

	// Private ----------------

	private static $instance;

	// Traits ------------------------------------------------------

	// Constructor and Initialisation ------------------------------

	/**
	 * Return Singleton instance.
	 */
	public static function getInstance() {

		if( !isset( self::$instance ) ) {

			self::$instance	= new FacebookProperties();

			self::$instance->init( SnsConnectGlobal::CONFIG_SNS_FACEBOOK );
		}

		return self::$instance;
	}

	// Instance methods --------------------------------------------

	// Yii interfaces ------------------------

	// Yii parent classes --------------------

	// CMG interfaces ------------------------

	// CMG parent classes --------------------

	// FacebookProperties --------------------

	public function isActive() {

		return $this->properties[ self::PROP_ACTIVE ];
	}

	public function getAppId() {

		return $this->properties[ self::PROP_APP_ID ];
	}

	public function getAppSecret() {

		return $this->properties[ self::PROP_APP_SECRET ];
	}

	public function getRedirectUri() {

		return Url::toRoute( $this->properties[ self::PROP_REDIRECT_URI ], true );
	}

}
