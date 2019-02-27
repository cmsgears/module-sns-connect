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
use cmsgears\social\connect\common\config\LinkedinProperties;

use cmsgears\core\common\services\base\SystemService;

/**
 * LinkedinService provide methods to login using LinkedIn.
 *
 * @since 1.0.0
 */
class LinkedinService extends SystemService {

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

	// LinkedinService -----------------------

	private function curl( $url ) {

		$ch	= curl_init();

		curl_setopt( $ch, CURLOPT_URL, $url );
		curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1 );

		$data = curl_exec( $ch );

		curl_close( $ch );

		return $data;
	}

	public function getLoginUrl() {

		$session	= Yii::$app->session;
        $state		= $session->get( 'lkdn_state' );

      	if( !isset( $state ) ) {

			$state = Yii::$app->security->generateRandomString();

			$session->set( 'lkdn_state', $state );
        }

		$properties = LinkedinProperties::getInstance();

		$redirectUri	= $properties->getRedirectUri();
		$clientId		= $properties->getClientId();

		$loginUrl = "https://www.linkedin.com/oauth/v2/authorization?"
					. "client_id=" . $clientId
					. "&redirect_uri=" . urlencode( $redirectUri )
					. "&state=" . $state
					. "&response_type=code"
					. "&scope=r_fullprofile,r_emailaddress,w_share";

	     return $loginUrl;
	}

	public function getAccessToken( $code, $state ) {

		$session 	= Yii::$app->session;
		$sState		= $session->get( 'fb_state' );

		if( isset( $state ) && strcmp( $sState, $state ) == 0 ) {

			$properties = LinkedinProperties::getInstance();

			$redirectUri	= $properties->getRedirectUri();
			$clientId		= $properties->getClientId();
			$clientSecret	= $properties->getClientSecret();

			$tokenUrl = "https://www.linkedin.com/oauth/v2/accessToken?"
						. 'client_id=' . $clientId
						. '&redirect_uri=' . urlencode( $redirectUri )
						. '&client_secret=' . $clientSecret
						. '&grant_type=authorization_code'
						. '&code=' . $code;

			$response = $this->curl( $tokenUrl );

			$params = json_decode( $response );

			//parse_str( $response, $params );

			if( isset( $params->access_token ) ) {

              	$accessToken = $params->access_token;

				$session->set( 'lkdn_access_token', $accessToken );

				return $accessToken;
			}
		}

		return false;
	}

	public function getUser( $accessToken ) {

		$session 	= Yii::$app->session;
		$graphUrl 	= "https://api.linkedin.com/v1/people/~:(id,first-name,last-name,email-address,picture-url)?format=json&access_token=" . $accessToken;
		$graphData	= $this->curl( $graphUrl );
     	$user 		= json_decode( $graphData );

     	if( isset( $user ) ) {

			$session->set( 'lkdn_user', json_encode( $user ) );

			return $user;
		}

		return false;
	}

	// Static Methods ----------------------------------------------

	// Yii parent classes --------------------

	// CMG parent classes --------------------

	// FacebookService -----------------------

}
