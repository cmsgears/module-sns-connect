<?php
namespace cmsgears\social\login\common\config;

// Yii Imports
use \Yii;
use yii\helpers\Url;

// CMG Imports
use cmsgears\core\common\config\CoreGlobal;

class GoogleProperties extends \cmsgears\core\common\config\CmgProperties {

	//TODO Add code for caching the properties

	const PROP_ACTIVE			= 'active';

	const PROP_APP_ID			= 'app_id';

	const PROP_APP_SECRET		= 'app_secret';

	const PROP_REDIRECT_URI		= 'redirect_uri';

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

			self::$instance	= new GoogleProperties();

			self::$instance->init( SnsLoginGlobal::CONFIG_SNS_GOOGLE );
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

	// GPlus

	function curl( $url, $count = 0, $postString = false ) {

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
		$state		= Yii::$app->security->generateRandomString();

		$session->set( 'gplus_state', $state );

		$redirectUri	= $this->getRedirectUri();

		$loginUrl = "https://accounts.google.com/o/oauth2/auth?"
					. "client_id=" . $this->getAppId()
					. "&redirect_uri=" . urlencode( $redirectUri )
					. "&state=" . $state
					. "&response_type=code"
					. "&scope=email%20profile";

	     return $loginUrl;
	}

	function getAccessToken( $code, $state ) {

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