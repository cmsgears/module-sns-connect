<?php
namespace cmsgears\social\login\common\config;

// Yii Imports
use \Yii;
use yii\helpers\Url;

// CMG Imports
use cmsgears\core\common\config\CoreGlobal;

class TwitterProperties extends \cmsgears\core\common\config\CmgProperties {

	//TODO Add code for caching the properties
	
	const PROP_ACTIVE			= 'active';

	const PROP_API_KEY			= 'api key';

	const PROP_API_SECRET		= 'api secret';

	const PROP_REDIRECT_URI		= 'redirect uri';

	// Singleton instance
	private static $instance;

	// Constructor and Initialisation ------------------------------

 	private function __construct() {

	}

	/**
	 * Return Singleton instance.
	 */
	public static function getInstance() {

		if( !isset( self::$instance ) ) {

			self::$instance	= new TwitterProperties();

			self::$instance->init( SnsLoginGlobal::CONFIG_SNS_TWITTER );
		}

		return self::$instance;
	}
	
	// Properties

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

	function curl( $url, $headerParams ) {

		$authHeader		= $this->generateAuthHeader( $headerParams );
		$authHeader		= [ $authHeader, 'Expect:' ];

		$ch		= curl_init();
		
		curl_setopt( $ch, CURLOPT_HTTPHEADER, $authHeader );
		curl_setopt( $ch, CURLOPT_HEADER, false );
		curl_setopt( $ch, CURLOPT_URL, $url );
		curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
		curl_setopt( $ch, CURLOPT_POST, true );
		curl_setopt( $ch, CURLOPT_SSL_VERIFYPEER, false );

		$data 	= curl_exec( $ch );

		curl_close( $ch );

		return $data;
	}

	public function generateBaseString( $tokenUrl, $headerParams ) {

		$tempArr	= [];

		ksort( $headerParams );

		foreach( $headerParams as $key => $value ) {

		        $tempArr[] = "$key=" . rawurlencode( $value );
		}

		return 'POST&' . rawurlencode( $tokenUrl ) . '&' . rawurlencode( implode( '&', $tempArr ) );
	}

	function generateCompositeKey( $apiSecret, $requestToken ) {

	    return rawurlencode( $apiSecret ) . '&' . rawurlencode( $requestToken );
	}

	function generateAuthHeader( $headerParams ) {

	    $header		= 'Authorization: OAuth ';
	    $tempArr 	= array();
		
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

	function getUser( $accessToken ) {

		$graphUrl 		= 'https://www.googleapis.com/oauth2/v1/userinfo?access_token=' . $accessToken;
		$graphData		= $this->curl( $graphUrl );
     	$user 			= json_decode( $graphData );

     	if( isset( $user ) ) {

			return $user;
		}

		return false;
	}
}

?>