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
 * LinkedinProperties provide methods to access the properties specific to LinkedIn application for login.
 *
 * @since 1.0.0
 */
class LinkedinProperties extends Properties {

	// Variables ---------------------------------------------------

	// Globals ----------------

	const PROP_ACTIVE			= 'active';

	const PROP_CLIENT_ID		= 'client_id';

	const PROP_CLIENT_SECRET	= 'client_secret';

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

			self::$instance	= new LinkedinProperties();

			self::$instance->init( SnsConnectGlobal::CONFIG_SNS_LINKEDIN );
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

	public function getClientId() {

		return $this->properties[ self::PROP_CLIENT_ID ];
	}

	public function getClientSecret() {

		return $this->properties[ self::PROP_CLIENT_SECRET ];
	}

	public function getRedirectUri() {

		return Url::toRoute( $this->properties[ self::PROP_REDIRECT_URI ], true );
	}

}
