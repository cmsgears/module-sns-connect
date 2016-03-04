<?php
namespace cmsgears\social\login\frontend\controllers;

// Yii Imports
use Yii;
use yii\filters\VerbFilter;
use yii\web\NotFoundHttpException;

// CMG Imports
use cmsgears\core\common\config\CoreGlobal;
use cmsgears\core\frontend\config\WebGlobalCore;
use cmsgears\social\login\common\config\SnsLoginGlobal;
use cmsgears\social\login\common\config\TwitterProperties;

use cmsgears\social\login\common\models\forms\TwitterLogin;
use cmsgears\social\login\frontend\models\forms\TwitterInfoForm;

use cmsgears\social\login\common\services\TwitterProfileService;

class TwitterController extends \cmsgears\core\frontend\controllers\base\Controller {

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
                    'login' => [ 'get' ],
                    'authorise' => [ 'get' ],
                    'userInfo' => [ 'get', 'post' ]
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

    public function actionAuthorise( $oauth_token, $oauth_verifier ) {

		$twitterProperties	= TwitterProperties::getInstance();
 
		$twitterProperties->setAuthToken( $oauth_token, $oauth_verifier );

		$twitterProperties->getAccessToken();

		$snsUser = $twitterProperties->getUser();

		if( $snsUser ) {

			// Get User
			$user	= TwitterProfileService::getUser( $snsUser, Yii::$app->session->get( 'tw_oauth_token' ) );

			if( $user ) {

				// Login and Redirect to home page
				$login	= new TwitterLogin( $user );

				if( $login->login() ) {
		
					return $this->redirect( [ '/user/index' ] );
				}
			}
			else {

				return $this->redirect( [ 'user-info' ] );
			}
		}

		// Model not found
		throw new NotFoundHttpException( Yii::$app->cmgCoreMessage->getMessage( CoreGlobal::ERROR_NOT_FOUND ) );
    }

	public function actionUserInfo() {

		$this->layout	= WebGlobalCore::LAYOUT_PUBLIC;

		$model			= new TwitterInfoForm();

		if( $model->load( Yii::$app->request->post() ) && $model->validate() ) {

			// Get User
			$snsUser		= Yii::$app->session->get( 'tw_user' );
			$snsUser		= json_decode( $snsUser ); 
            $snsUser->email	= $model->email;

			$user			= TwitterProfileService::getUser( $snsUser, Yii::$app->session->get( 'tw_oauth_token' ) );

			// Login and Redirect to home page
			$login	= new TwitterLogin( $user );

			if( $login->login() ) {

				return $this->redirect( [ '/user/index' ] );
			}
		}

		return $this->render( 'user-info', [ 'model' => $model ] );
	}
}

?>