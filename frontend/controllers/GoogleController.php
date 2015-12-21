<?php
namespace cmsgears\social\login\frontend\controllers;

// Yii Imports
use Yii;
use yii\filters\VerbFilter;
use yii\web\NotFoundHttpException;

// CMG Imports
use cmsgears\core\common\config\CoreGlobal;
use cmsgears\social\login\common\config\GoogleProperties;

use cmsgears\social\login\common\models\forms\GoogleLogin;

use cmsgears\social\login\common\services\GoogleProfileService;

class GoogleController extends \cmsgears\core\frontend\controllers\base\Controller {

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

		$googleProperties	= GoogleProperties::getInstance();

		// Get Token
		$accessToken		= $googleProperties->getAccessToken( $code, $state );
		$snsUser			= $googleProperties->getUser( $accessToken );

		if( isset( $snsUser ) ) {

			// Get User
			$user	= GoogleProfileService::getUser( $snsUser, $accessToken );

			// Login and Redirect to home page
			$login	= new GoogleLogin( $user );

			if( $login->login() ) {

				$this->checkHome();
			}
		}

		// Model not found
		throw new NotFoundHttpException( Yii::$app->cmgCoreMessage->getMessage( CoreGlobal::ERROR_NOT_FOUND ) );
    }
}

?>