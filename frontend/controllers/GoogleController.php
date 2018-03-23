<?php
namespace cmsgears\social\connect\frontend\controllers;

// Yii Imports
use Yii;
use yii\filters\VerbFilter;
use yii\web\NotFoundHttpException;

// CMG Imports
use cmsgears\core\common\config\CoreGlobal;

use cmsgears\social\connect\common\models\forms\GoogleLogin;

use cmsgears\core\frontend\controllers\base\Controller;

class GoogleController extends Controller {

	// Variables ---------------------------------------------------

	// Globals ----------------

	// Public -----------------

	// Protected --------------

	// Private ----------------

	private $googleService;

	// Constructor and Initialisation ------------------------------

 	public function init() {

        parent::init();

		$this->modelService		= Yii::$app->factory->get( 'googleProfileService' );

		$this->googleService	= Yii::$app->factory->get( 'googleService' );
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

	// GoogleController ----------------------

    public function actionAuthorise( $code, $state ) {

		// Get Token
		$accessToken	= $this->googleService->getAccessToken( $code, $state );
		$snsUser		= $this->googleService->getUser( $accessToken );

		if( isset( $snsUser ) ) {

			// Get User
			$user	= $this->modelService->getUser( $snsUser, $accessToken );

			// Login and Redirect to home page
			$login	= new GoogleLogin( $user );

			if( $login->login() ) {

				return $this->redirect( [ '/user/index' ] );
			}
		}

		// Model not found
		throw new NotFoundHttpException( Yii::$app->coreMessage->getMessage( CoreGlobal::ERROR_NOT_FOUND ) );
    }

}
