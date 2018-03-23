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

// CMG Imports
use cmsgears\core\common\services\base\SystemService;

/**
 * GoogleService provide methods to login using Google.
 *
 * @since 1.0.0
 */
class GoogleService extends SystemService {

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

	// GoogleService -------------------------

	private function curl( $url, $count = 0, $postString = false ) {

		$ch		= curl_init();

		curl_setopt( $ch, CURLOPT_URL, $url );
		curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1 );

		if( $postString ) {

			curl_setopt( $ch,CURLOPT_POST, $count );
			curl_setopt( $ch,CURLOPT_POSTFIELDS, $postString );
		}

		$data 	= curl_exec( $ch );

		curl_close( $ch );

		return $data;
	}

	public function getLoginUrl() {

		$session 	= Yii::$app->session;
        $state		= $session->get( 'gplus_state' );

      	if( !isset( $state ) ) {

			$state		= Yii::$app->security->generateRandomString();

			$session->set( 'gplus_state', $state );
        }

		$redirectUri	= $this->getRedirectUri();

		$loginUrl = "https://accounts.google.com/o/oauth2/auth?"
					. "client_id=" . $this->getAppId()
					. "&redirect_uri=" . urlencode( $redirectUri )
					. "&state=" . $state
					. "&response_type=code"
					. "&scope=email%20profile";

	     return $loginUrl;
	}

	public function getAccessToken( $code, $state ) {

		$sState			= Yii::$app->session->get( 'gplus_state' );

		if( isset( $state ) && strcmp( $sState, $state ) == 0 ) {

			$redirectUri	= $this->getRedirectUri();

			$tokenUrl 		= "https://www.googleapis.com/oauth2/v3/token";
			$tokenParams	= 'client_id=' . $this->getAppId()
								. '&redirect_uri=' . urlencode( $redirectUri )
								. '&client_secret=' . $this->getAppSecret()
								. '&code=' . $code
								. '&grant_type=authorization_code';

			$response 		= $this->curl( $tokenUrl, 5, $tokenParams );
			$response 		= json_decode( $response, true );
			$accessToken 	= $response[ 'access_token' ];

			if( isset( $accessToken ) ) {

				return $accessToken;
			}
		}

		return false;
	}

	public function getUser( $accessToken ) {

		$graphUrl 		= 'https://www.googleapis.com/oauth2/v1/userinfo?access_token=' . $accessToken;
		$graphData		= $this->curl( $graphUrl );
     	$user 			= json_decode( $graphData );

     	if( isset( $user ) ) {

			return $user;
		}

		return false;
	}

}
