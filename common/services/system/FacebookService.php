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
 * FacebookService provide methods to login using FaceBook.
 *
 * @since 1.0.0
 */
class FacebookService extends SystemService {

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

	// FacebookService -----------------------

	private function curl( $url ) {

		$ch	= curl_init();

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

	public function getAccessToken( $code, $state ) {

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

	public function getUser( $accessToken ) {

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
