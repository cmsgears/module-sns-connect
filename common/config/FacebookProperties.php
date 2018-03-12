<?php
/**
 * This file is part of CMSGears Framework. Please view License file distributed
 * with the source code for license details.
 *
 * @link https://www.cmsgears.org/
 * @copyright Copyright (c) 2015 VulpineCode Technologies Pvt. Ltd.
 */

namespace cmsgears\social\login\common\config;

// Yii Imports
use Yii;
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

	// Instance methods --------------------------------------------

	// Yii interfaces ------------------------

	// Yii parent classes --------------------

	// CMG interfaces ------------------------

	// CMG parent classes --------------------

	// FacebookProperties --------------------

	/**
	 * Return Singleton instance.
	 */
	public static function getInstance() {

		if( !isset( self::$instance ) ) {

			self::$instance	= new FacebookProperties();

			self::$instance->init( SnsLoginGlobal::CONFIG_SNS_FACEBOOK );
		}

		return self::$instance;
	}

	// Properties

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

	// FB

	function curl( $url ) {

		$ch		= curl_init();

		curl_setopt( $ch, CURLOPT_URL, $url );
		curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1 );

		$data 	= curl_exec( $ch );

		curl_close( $ch );

		return $data;
	}

	public function getLoginUrl() {

		$session 	= Yii::$app->session;
        $state		= $session->get( 'fb_state' );

      	if( !isset( $state ) ) {

			$state		= Yii::$app->security->generateRandomString();

			$session->set( 'fb_state', $state );
        }

		$redirectUri	= $this->getRedirectUri();

		$loginUrl = "https://www.facebook.com/v2.8/dialog/oauth?"
					. "client_id=" . $this->getAppId()
					. "&redirect_uri=" . urlencode( $redirectUri )
					. "&state=" . $state
					. "&response_type=code"
					. "&scope=user_about_me,email";

	     return $loginUrl;
	}

	function getAccessToken( $code, $state ) {

		$session 	= Yii::$app->session;
		$sState		= $session->get( 'fb_state' );

		if( isset( $state ) && strcmp( $sState, $state ) == 0 ) {

			$redirectUri	= $this->getRedirectUri();

			$tokenUrl 	= "https://graph.facebook.com/v2.8/oauth/access_token?"
							. 'client_id=' . $this->getAppId()
							. '&redirect_uri=' . urlencode( $redirectUri )
							. '&client_secret=' . $this->getAppSecret()
							. '&code=' . $code;

			$response 	= $this->curl( $tokenUrl );

			$params 	= json_decode( $response );

			//parse_str( $response, $params );

			if( isset( $params->access_token ) ) {

              	$accessToken 	= $params->access_token;

				$session->set( 'fb_access_token', $accessToken );

				return $accessToken;
			}
		}

		return false;
	}

	function getUser( $accessToken ) {

		$session 	= Yii::$app->session;
		$graphUrl 	= "https://graph.facebook.com/v2.8/me?fields=id,first_name,last_name,email,picture&access_token=". $accessToken;
		$graphData	= $this->curl( $graphUrl );
     	$user 		= json_decode( $graphData );

     	if( isset( $user ) ) {

			$session->set( 'fb_user', json_encode( $user ) );

			return $user;
		}

		return false;
	}

}
