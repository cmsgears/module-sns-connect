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
 * TwitterProperties provide methods to access the properties specific to twitter application for login.
 *
 * @since 1.0.0
 */
class TwitterProperties extends Properties {

	// Variables ---------------------------------------------------

	// Globals ----------------

	const PROP_ACTIVE			= 'active';

	const PROP_CONSUMER_KEY		= 'consumer_key';

	const PROP_CONSUMER_SECRET	= 'consumer_secret';

	const PROP_ACCESS_TOKEN		= 'access_token';

	const PROP_ACCESS_TOKEN_SECRET	= 'access_token_secret';

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

			self::$instance	= new TwitterProperties();

			self::$instance->init( SnsConnectGlobal::CONFIG_SNS_TWITTER );
		}

		return self::$instance;
	}

	// Instance methods --------------------------------------------

	// Yii interfaces ------------------------

	// Yii parent classes --------------------

	// CMG interfaces ------------------------

	// CMG parent classes --------------------

	// TwitterProperties ---------------------

	public function isActive() {

		return $this->properties[ self::PROP_ACTIVE ];
	}

	public function getConsumerKey() {

		return $this->properties[ self::PROP_CONSUMER_KEY ];
	}

	public function getConsumerSecret() {

		return $this->properties[ self::PROP_CONSUMER_SECRET ];
	}

	public function getAccessToken() {

		return $this->properties[ self::PROP_ACCESS_TOKEN ];
	}

	public function getAccessTokenSecret() {

		return $this->properties[ self::PROP_ACCESS_TOKEN_SECRET ];
	}

	public function getRedirectUri() {

		return Url::toRoute( $this->properties[ self::PROP_REDIRECT_URI ], true );
	}

}
