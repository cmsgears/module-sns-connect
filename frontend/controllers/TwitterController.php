<?php
namespace cmsgears\social\login\frontend\controllers;

// Yii Imports
use Yii;
use yii\filters\VerbFilter;
use yii\web\NotFoundHttpException;

// CMG Imports
use cmsgears\core\common\config\CoreGlobal;
use cmsgears\social\login\common\config\SnsLoginGlobal;
use cmsgears\social\login\common\config\TwitterProperties;

use cmsgears\social\login\common\models\forms\TwitterLogin;

use cmsgears\social\login\common\services\TwitterProfileService;

class TwitterController extends \cmsgears\core\frontend\controllers\BaseController {

	// Constructor and Initialisation ------------------------------

    /**
     * @inheritdoc
     */
 	public function __construct( $id, $module, $config = [] ) {

        parent::__construct( $id, $module, $config );
	}

	// Instance Methods --------------------------------------------

	// yii\base\Component ----------------

    public function behaviors() {

        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'authorise' => [ 'get' ]
                ]
            ]
        ];
    }

	// SiteController --------------------
	
	public function actionLogin() {
		
		$twitterProperties	= TwitterProperties::getInstance();
 
		$twitterProperties->requestToken();
		
		$authToken			= Yii::$app->session->get( 'tw_oauth_token' );

		$this->redirect( "https://api.twitter.com/oauth/authorize?oauth_token=$authToken" );
	}

    public function actionAuthorise( $oauth_token, $oauth_token_secret, $screen_name, $user_id ) {
    	
		echo $oauth_token . " " . $oauth_token_secret;

		/*
		$twitterProperties	= TwitterProperties::getInstance();

		// Get Token
		$accessToken		= $gplusProperties->getAccessToken( $code, $state );
		$snsUser			= $gplusProperties->getUser( $accessToken );

		if( isset( $snsUser ) ) {

			// Get User
			$user	= GPlusProfileService::getUser( $snsUser, $accessToken );

			// Login and Redirect to home page
			$login	= new GPlusLogin( $user );

			if( $login->login() ) {

				$this->checkHome();
			}
		}

		// Model not found
		throw new NotFoundHttpException( Yii::$app->cmgCoreMessage->getMessage( CoreGlobal::ERROR_NOT_FOUND ) ); 
		 */
    }
}

?>