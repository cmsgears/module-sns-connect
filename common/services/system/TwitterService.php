<?php
/**
 * This file is part of CMSGears Framework. Please view License file distributed
 * with the source code for license details.
 *
 * @link https://www.cmsgears.org/
 * @copyright Copyright (c) 2015 VulpineCode Technologies Pvt. Ltd.
 */

namespace cmsgears\social\connect\common\services\system;

// Yii Imports
use Yii;
use yii\helpers\Url;

// CMG Imports
use cmsgears\social\connect\common\config\TwitterProperties;

use cmsgears\core\common\services\base\SystemService;

/**
 * TwitterService provide methods to login using Twitter.
 *
 * @since 1.0.0
 */
class TwitterService extends SystemService {

	// Variables ---------------------------------------------------

	// Globals ----------------

	// Public -----------------

	// Protected --------------

	// Private ----------------

	// Traits ------------------------------------------------------

	// Constructor and Initialisation ------------------------------

	// Instance methods --------------------------------------------

	// Yii interfaces ------------------------

	// Yii parent classes --------------------

	// CMG interfaces ------------------------

	// CMG parent classes --------------------

	// TwitterService ------------------------

	private function curl( $url, $headerParams, $post = true ) {

		$authHeader	= $this->generateAuthHeader( $headerParams );
		$authHeader	= [ $authHeader, 'Expect:' ];

		$ch = curl_init();

		curl_setopt( $ch, CURLOPT_HTTPHEADER, $authHeader );
		curl_setopt( $ch, CURLOPT_HEADER, false );
		curl_setopt( $ch, CURLOPT_URL, $url );
		curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );

		if( $post ) {

			curl_setopt( $ch, CURLOPT_POST, true );
		}

		curl_setopt( $ch, CURLOPT_SSL_VERIFYPEER, false );

		$data = curl_exec( $ch );

		curl_close( $ch );

		return $data;
	}

	public function generateBaseString( $tokenUrl, $headerParams, $post = true ) {

		$tempArr = [];

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

	public function generateCompositeKey( $apiSecret, $requestToken ) {

	    return rawurlencode( $apiSecret ) . '&' . rawurlencode( $requestToken );
	}

	public function generateAuthHeader( $headerParams ) {

	    $header		= 'Authorization: OAuth ';
	    $tempArr 	= [];

		ksort( $headerParams );

	    foreach( $headerParams as $key => $value ) {

	        $tempArr[] = "$key=\"" . rawurlencode( $value ) . "\"";
		}

	    $header .= implode( ', ', $tempArr );

	    return $header;
	}

	public function getLoginUrl() {

		$loginUrl = Url::toRoute( '/sns/twitter/login', true );

	     return $loginUrl;
	}

	public function requestToken() {

		$properties = TwitterProperties::getInstance();

		$apiKey			= $properties->getApiKey();
		$apiSecret		= $properties->getApiSecret();
		$redirectUri	= $properties->getRedirectUri();

		$nonce 		= Yii::$app->security->generateRandomString();
		$timestamp 	= time();

		$tokenUrl = "https://api.twitter.com/oauth/request_token";

		$headerParams = [
			'oauth_callback' => $redirectUri,
			'oauth_consumer_key' => $apiKey,
			'oauth_nonce' => $nonce,
			'oauth_signature_method' => 'HMAC-SHA1',
			'oauth_timestamp' => "$timestamp",
			'oauth_version' => '1.0'
		];

		$baseString		= $this->generateBaseString( $tokenUrl, $headerParams );
		$compositeKey	= $this->generateCompositeKey( $apiSecret, null );

		$oauthSignature = base64_encode( hash_hmac( 'sha1', $baseString, $compositeKey, true ) );

		$headerParams[ 'oauth_signature' ] = $oauthSignature;

		$response = $this->curl( $tokenUrl, $headerParams );

		$params = null;

		parse_str( $response, $params );

		$session = Yii::$app->session;

		$session->set( 'tw_oauth_token', $params[ 'oauth_token' ] );
		$session->set( 'tw_oauth_token_secret', $params[ 'oauth_token_secret' ] );
	}

	public function setAuthToken( $oauth_token, $oauth_verifier ) {

		$session = Yii::$app->session;

		$session->set( 'tw_oauth_token', $oauth_token );
		$session->set( 'tw_oauth_verifier', $oauth_verifier );
	}

	public function getAccessToken() {

		$session 	= Yii::$app->session;
		$properties = TwitterProperties::getInstance();

		$apiKey			= $properties->getApiKey();
		$apiSecret		= $properties->getApiSecret();
		$redirectUri	= $properties->getRedirectUri();

		$nonce 		= Yii::$app->security->generateRandomString();
		$timestamp 	= time();

		$tokenUrl = "https://api.twitter.com/oauth/access_token";

		$headerParams = [
			'oauth_token' => $session->get( 'tw_oauth_token' ),
			'oauth_verifier' => $session->get( 'tw_oauth_verifier' ),
			'oauth_consumer_key' => $apiKey,
			'oauth_nonce' => $nonce,
			'oauth_signature_method' => 'HMAC-SHA1',
			'oauth_timestamp' => "$timestamp",
			'oauth_version' => '1.0'
		];

		$baseString		= $this->generateBaseString( $tokenUrl, $headerParams );
		$compositeKey	= $this->generateCompositeKey( $apiSecret, $session->get( 'tw_oauth_token_secret' ) );

		$oauthSignature = base64_encode( hash_hmac( 'sha1', $baseString, $compositeKey, true ) );

		$headerParams[ 'oauth_signature' ] = $oauthSignature;

		$response = $this->curl( $tokenUrl, $headerParams );

		$params = null;

		parse_str( $response, $params );

		$session = Yii::$app->session;

		$session->set( 'tw_oauth_token', $params[ 'oauth_token' ] );
		$session->set( 'tw_oauth_token_secret', $params[ 'oauth_token_secret' ] );
		$session->set( 'tw_user_id', $params[ 'user_id' ] );
		$session->set( 'tw_screen_name', $params[ 'screen_name' ] );
	}

	public function getUser() {

		$session 	= Yii::$app->session;
		$properties = TwitterProperties::getInstance();

		$apiKey			= $properties->getApiKey();
		$apiSecret		= $properties->getApiSecret();
		$redirectUri	= $properties->getRedirectUri();

		$nonce 		= Yii::$app->security->generateRandomString();
		$timestamp 	= time();

		$tokenUrl = "https://api.twitter.com/1.1/users/show.json";

		$headerParams = [
			'oauth_token' => $session->get( 'tw_oauth_token' ),
			'oauth_consumer_key' => $apiKey,
			'oauth_nonce' => $nonce,
			'oauth_signature_method' => 'HMAC-SHA1',
			'oauth_timestamp' => "$timestamp",
			'oauth_version' => '1.0'
		];

		$baseArr		= ArrayHelper::merge( $headerParams, [ 'screen_name' => $session->get( 'tw_screen_name' ) ] );
		$baseString		= $this->generateBaseString( $tokenUrl, $baseArr, false );
		$compositeKey	= $this->generateCompositeKey( $apiSecret, $session->get( 'tw_oauth_token_secret' ) );

		$oauthSignature = base64_encode( hash_hmac( 'sha1', $baseString, $compositeKey, true ) );

		$headerParams[ 'oauth_signature' ] = $oauthSignature;

		$response = $this->curl( $tokenUrl . "?screen_name=" . $session->get( 'tw_screen_name' ), $headerParams, false );

		$user = json_decode( $response );

		if( isset( $user->id ) ) {

			$userUpd		= new \stdClass;
			$userUpd->id	= $user->id;

			$name = $user->name;
			$name = preg_split( "/ /", $name );

			if( count( $name ) > 1 ) {

				$userUpd->firstName	= $name[ 0 ];
				$userUpd->lastName	= $name[ 1 ];
			}
			else {

				$userUpd->firstName	= $name[ 0 ];
				$userUpd->lastName	= null;
			}

			$userUpd->secret = $session->get( 'tw_oauth_token_secret' );

			$session->set( 'tw_user', json_encode( $userUpd ) );

			return $userUpd;
		}

     	return false;
	}

	// Static Methods ----------------------------------------------

	// Yii parent classes --------------------

	// CMG parent classes --------------------

	// TwitterService ------------------------

}
