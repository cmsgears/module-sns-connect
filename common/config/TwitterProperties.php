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
use Yii;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;

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

	const PROP_API_KEY			= 'api_key';

	const PROP_API_SECRET		= 'api_secret';

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

	public function getApiKey() {

		return $this->properties[ self::PROP_API_KEY ];
	}

	public function getApiSecret() {

		return $this->properties[ self::PROP_API_SECRET ];
	}

	public function getRedirectUri() {

		return Url::toRoute( $this->properties[ self::PROP_REDIRECT_URI ], true );
	}

	// Twitter

	function curl( $url, $headerParams, $post = true ) {

		$authHeader		= $this->generateAuthHeader( $headerParams );
		$authHeader		= [ $authHeader, 'Expect:' ];

		$ch		= curl_init();

		curl_setopt( $ch, CURLOPT_HTTPHEADER, $authHeader );
		curl_setopt( $ch, CURLOPT_HEADER, false );
		curl_setopt( $ch, CURLOPT_URL, $url );
		curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );

		if( $post ) {

			curl_setopt( $ch, CURLOPT_POST, true );
		}

		curl_setopt( $ch, CURLOPT_SSL_VERIFYPEER, false );

		$data 	= curl_exec( $ch );

		curl_close( $ch );

		return $data;
	}

	public function generateBaseString( $tokenUrl, $headerParams, $post = true ) {

		$tempArr	= [];

		ksort( $headerParams );

		foreach( $headerParams as $key => $value ) {

		        $tempArr[] = "$key=" . rawurlencode( $value );
		}

		if( $post ) {

			return 'POST&' . rawurlencode( $tokenUrl ) . '&' . rawurlencode( implode( '&', $tempArr ) );
		}
		else {

			return 'GET&' . rawurlencode( $tokenUrl ) . '&' . rawurlencode( implode( '&', $tempArr ) );
		}
	}

	function generateCompositeKey( $apiSecret, $requestToken ) {

	    return rawurlencode( $apiSecret ) . '&' . rawurlencode( $requestToken );
	}

	function generateAuthHeader( $headerParams ) {

	    $header		= 'Authorization: OAuth ';
	    $tempArr 	= array();

		ksort( $headerParams );

	    foreach( $headerParams as $key => $value ) {

	        $tempArr[] = "$key=\"" . rawurlencode( $value ) . "\"";
		}

	    $header 	.= implode( ', ', $tempArr );

	    return $header;
	}

	public function getLoginUrl() {

		$loginUrl = Url::toRoute( '/sns/twitter/login', true );

	     return $loginUrl;
	}

	function requestToken() {

		$apiKey			= $this->getApiKey();
		$apiSecret		= $this->getApiSecret();
		$redirectUri	= $this->getRedirectUri();

		$nonce 			= Yii::$app->security->generateRandomString();
		$timestamp 		= time();

		$tokenUrl 		= "https://api.twitter.com/oauth/request_token";

		$headerParams	= [ 'oauth_callback' => $redirectUri,
							'oauth_consumer_key' => $apiKey,
							'oauth_nonce' => $nonce,
						    'oauth_signature_method' => 'HMAC-SHA1',
						    'oauth_timestamp' => "$timestamp",
						    'oauth_version' => '1.0' ];

		$baseString		= $this->generateBaseString( $tokenUrl, $headerParams );
		$compositeKey	= $this->generateCompositeKey( $apiSecret, null );

		$oauthSignature = base64_encode( hash_hmac( 'sha1', $baseString, $compositeKey, true ) );

		$headerParams['oauth_signature'] = $oauthSignature;

		$response 		= $this->curl( $tokenUrl, $headerParams );

		$params 		= null;

		parse_str( $response, $params );

		$session 		= Yii::$app->session;

		$session->set( 'tw_oauth_token', $params[ 'oauth_token' ] );
		$session->set( 'tw_oauth_token_secret', $params[ 'oauth_token_secret' ] );
	}

	function setAuthToken( $oauth_token, $oauth_verifier ) {

		$session 		= Yii::$app->session;

		$session->set( 'tw_oauth_token', $oauth_token );
		$session->set( 'tw_oauth_verifier', $oauth_verifier );
	}

	function getAccessToken() {

		$session 		= Yii::$app->session;
		$apiKey			= $this->getApiKey();
		$apiSecret		= $this->getApiSecret();
		$redirectUri	= $this->getRedirectUri();

		$nonce 			= Yii::$app->security->generateRandomString();
		$timestamp 		= time();

		$tokenUrl 		= "https://api.twitter.com/oauth/access_token";

		$headerParams	= [ 'oauth_token' => $session->get( 'tw_oauth_token' ),
							'oauth_verifier' => $session->get( 'tw_oauth_verifier' ),
							'oauth_consumer_key' => $apiKey,
							'oauth_nonce' => $nonce,
						    'oauth_signature_method' => 'HMAC-SHA1',
						    'oauth_timestamp' => "$timestamp",
						    'oauth_version' => '1.0' ];

		$baseString		= $this->generateBaseString( $tokenUrl, $headerParams );
		$compositeKey	= $this->generateCompositeKey( $apiSecret, $session->get( 'tw_oauth_token_secret' ) );

		$oauthSignature = base64_encode( hash_hmac( 'sha1', $baseString, $compositeKey, true ) );

		$headerParams['oauth_signature'] = $oauthSignature;

		$response 		= $this->curl( $tokenUrl, $headerParams );

		$params 		= null;

		parse_str( $response, $params );

		$session 		= Yii::$app->session;

		$session->set( 'tw_oauth_token', $params[ 'oauth_token' ] );
		$session->set( 'tw_oauth_token_secret', $params[ 'oauth_token_secret' ] );
		$session->set( 'tw_user_id', $params[ 'user_id' ] );
		$session->set( 'tw_screen_name', $params[ 'screen_name' ] );
	}

	function getUser() {

		$session 		= Yii::$app->session;
		$apiKey			= $this->getApiKey();
		$apiSecret		= $this->getApiSecret();
		$redirectUri	= $this->getRedirectUri();

		$nonce 			= Yii::$app->security->generateRandomString();
		$timestamp 		= time();

		$tokenUrl 		= "https://api.twitter.com/1.1/users/show.json";

		$headerParams	= [ 'oauth_token' => $session->get( 'tw_oauth_token' ),
							'oauth_consumer_key' => $apiKey,
							'oauth_nonce' => $nonce,
						    'oauth_signature_method' => 'HMAC-SHA1',
						    'oauth_timestamp' => "$timestamp",
						    'oauth_version' => '1.0' ];

		$baseArr		= ArrayHelper::merge( $headerParams, [ 'screen_name' => $session->get( 'tw_screen_name' ) ] );
		$baseString		= $this->generateBaseString( $tokenUrl, $baseArr, false );
		$compositeKey	= $this->generateCompositeKey( $apiSecret, $session->get( 'tw_oauth_token_secret' ) );

		$oauthSignature = base64_encode( hash_hmac( 'sha1', $baseString, $compositeKey, true ) );

		$headerParams['oauth_signature'] = $oauthSignature;

		$response 		= $this->curl( $tokenUrl . "?screen_name=" . $session->get( 'tw_screen_name' ), $headerParams, false );

		$user 			= json_decode( $response );

		if( isset( $user->id ) ) {

			$userUpd		= new \stdClass;
			$userUpd->id	= $user->id;

			$name			= $user->name;
			$name			= preg_split( "/ /", $name );

			if( count( $name ) > 1 ) {

				$userUpd->firstName	= $name[ 0 ];
				$userUpd->lastName	= $name[ 1 ];
			}
			else {

				$userUpd->firstName	= $name[ 0 ];
				$userUpd->lastName	= null;
			}

			$userUpd->secret	= $session->get( 'tw_oauth_token_secret' );

			$session->set( 'tw_user', json_encode( $userUpd ) );

			return $userUpd;
		}

     	return false;
	}

}
