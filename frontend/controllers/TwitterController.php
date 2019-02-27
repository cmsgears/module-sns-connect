<?php
/**
 * This file is part of CMSGears Framework. Please view License file distributed
 * with the source code for license details.
 *
 * @link https://www.cmsgears.org/
 * @copyright Copyright (c) 2015 VulpineCode Technologies Pvt. Ltd.
 */

namespace cmsgears\social\connect\frontend\controllers;

// Yii Imports
use Yii;
use yii\filters\VerbFilter;
use yii\web\NotFoundHttpException;

// CMG Imports
use cmsgears\core\common\config\CoreGlobal;
use cmsgears\core\frontend\config\WebGlobalCore;

use cmsgears\social\connect\common\models\forms\TwitterLogin;
use cmsgears\social\connect\frontend\models\forms\TwitterInfoForm;

use cmsgears\core\frontend\controllers\base\Controller;

/**
 * It provides actions specific to Twitter Login.
 *
 * @since 1.0.0
 */
class TwitterController extends Controller {

	// Variables ---------------------------------------------------

	// Globals ----------------

	// Public -----------------

	// Protected --------------

	// Private ----------------

	private $twitterService;

	// Constructor and Initialisation ------------------------------

 	public function init() {

        parent::init();

		$this->modelService		= Yii::$app->factory->get( 'twitterProfileService' );

		$this->twitterService	= Yii::$app->factory->get( 'twitterService' );
	}

	// Instance methods --------------------------------------------

	// Yii interfaces ------------------------

	// Yii parent classes --------------------

	// yii\base\Component -----

    public function behaviors() {

        return [
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'login' => [ 'get' ],
                    'authorise' => [ 'get' ],
                    'userInfo' => [ 'get', 'post' ]
                ]
            ]
        ];
    }

	// yii\base\Controller ----

	// CMG interfaces ------------------------

	// CMG parent classes --------------------

	// TwitterController ---------------------

	public function actionLogin() {

		$this->twitterService->requestToken();

		$authToken = Yii::$app->session->get( 'tw_oauth_token' );

		$this->redirect( "https://api.twitter.com/oauth/authorize?oauth_token=$authToken" );
	}

    public function actionAuthorise( $oauth_token, $oauth_verifier ) {

		$this->twitterService->setAuthToken( $oauth_token, $oauth_verifier );

		$this->twitterService->getAccessToken();

		$snsUser = $this->twitterService->getUser();

		if( $snsUser ) {

			// Get User
			$user = $this->modelService->getUser( $snsUser, Yii::$app->session->get( 'tw_oauth_token' ) );

			if( $user ) {

				// Login and Redirect to home page
				$login = new TwitterLogin( $user );

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

		$this->layout = WebGlobalCore::LAYOUT_PUBLIC;

		$model = new TwitterInfoForm();

		$snsUser = Yii::$app->session->get( 'tw_user' );
		$snsUser = json_decode( $snsUser );

		$user = $this->modelService->getUser( $snsUser, Yii::$app->session->get( 'tw_oauth_token' ) );

		$model->email = $user->email ?? null;

		if( $model->load( Yii::$app->request->post() ) && $model->validate() ) {

			// Get User
			$snsUser	= Yii::$app->session->get( 'tw_user' );
			$snsUser	= json_decode( $snsUser );

			$snsUser->email	= $model->email;

			$user = $this->modelService->getUser( $snsUser, Yii::$app->session->get( 'tw_oauth_token' ) );

			// Login and Redirect to home page
			$login = new TwitterLogin( $user );

			if( $login->login() ) {

				return $this->redirect( [ '/user/index' ] );
			}
		}

		return $this->render( 'user-info', [ 'model' => $model ] );
	}

}
