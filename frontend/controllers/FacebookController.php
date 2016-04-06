<?php
namespace cmsgears\social\login\frontend\controllers;

// Yii Imports
use Yii;
use yii\filters\VerbFilter;
use yii\web\NotFoundHttpException;

// CMG Imports
use cmsgears\core\common\config\CoreGlobal;
use cmsgears\social\login\common\config\FacebookProperties;

use cmsgears\social\login\common\models\forms\FacebookLogin;
use cmsgears\social\login\frontend\models\forms\FacebookInfoForm;

use cmsgears\social\login\common\services\entities\FacebookProfileService;

class FacebookController extends \cmsgears\core\frontend\controllers\base\Controller {

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

    public function actionAuthorise( $code, $state ) {

		$fbProperties	= FacebookProperties::getInstance();

		// Get Token
		$accessToken	= $fbProperties->getAccessToken( $code, $state );
		$snsUser		= $fbProperties->getUser( $accessToken );

		if( isset( $snsUser ) ) {

			// Get User
			$user	= FacebookProfileService::getUser( $snsUser, $accessToken );

			if( $user ) {

				// Login and Redirect to home page
				$login	= new FacebookLogin( $user );

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

		$model			= new FacebookInfoForm();

		if( $model->load( Yii::$app->request->post() ) && $model->validate() ) {

			// Get User
			$snsUser		= Yii::$app->session->get( 'fb_user' );
			$snsUser		= json_decode( $snsUser );
            $snsUser->email	= $model->email;

			$user			= FacebookProfileService::getUser( $snsUser, Yii::$app->session->get( 'fb_access_token' ) );

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