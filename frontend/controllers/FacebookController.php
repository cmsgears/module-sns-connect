<?php
namespace cmsgears\social\connect\frontend\controllers;

// Yii Imports
use Yii;
use yii\filters\VerbFilter;
use yii\web\NotFoundHttpException;

// CMG Imports
use cmsgears\core\common\config\CoreGlobal;

use cmsgears\social\connect\common\models\forms\FacebookLogin;
use cmsgears\social\connect\frontend\models\forms\FacebookInfoForm;

use cmsgears\core\frontend\controllers\base\Controller;

class FacebookController extends Controller {

	// Variables ---------------------------------------------------

	// Globals ----------------

	// Public -----------------

	// Protected --------------

	// Private ----------------

	private $facebookService;

	// Constructor and Initialisation ------------------------------

 	public function init() {

        parent::init();

		$this->modelService		= Yii::$app->factory->get( 'facebookProfileService' );

		$this->facebookService	= Yii::$app->factory->get( 'facebookService' );
	}

	// Instance methods --------------------------------------------

	// Yii interfaces ------------------------

	// Yii parent classes --------------------

	// yii\base\Component -----

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

	// yii\base\Controller ----

	// CMG interfaces ------------------------

	// CMG parent classes --------------------

	// FacebookController --------------------

    public function actionAuthorise( $code, $state ) {

		// Get Token
		$accessToken	= $this->facebookService->getAccessToken( $code, $state );
		$snsUser		= $this->facebookService->getUser( $accessToken );

		if( isset( $snsUser ) ) {

			// Get User
			$user	= $this->modelService->getUser( $snsUser, $accessToken );

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
		throw new NotFoundHttpException( Yii::$app->coreMessage->getMessage( CoreGlobal::ERROR_NOT_FOUND ) );
    }

	public function actionUserInfo() {

		$this->layout	= WebGlobalCore::LAYOUT_PUBLIC;

		$model			= new FacebookInfoForm();

		if( $model->load( Yii::$app->request->post() ) && $model->validate() ) {

			// Get User
			$snsUser		= Yii::$app->session->get( 'fb_user' );
			$snsUser		= json_decode( $snsUser );
            $snsUser->email	= $model->email;

			$user			= $this->modelService->getUser( $snsUser, Yii::$app->session->get( 'fb_access_token' ) );

			// Login and Redirect to home page
			$login	= new TwitterLogin( $user );

			if( $login->login() ) {

				return $this->redirect( [ '/user/index' ] );
			}
		}

		return $this->render( 'user-info', [ 'model' => $model ] );
	}

}
