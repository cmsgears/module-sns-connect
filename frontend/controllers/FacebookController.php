<?php
namespace cmsgears\social\login\frontend\controllers;

// Yii Imports
use Yii;
use yii\filters\VerbFilter;
use yii\web\NotFoundHttpException;

// CMG Imports
use cmsgears\core\common\config\CoreGlobal;
use cmsgears\social\login\common\config\SnsLoginGlobal;
use cmsgears\social\login\common\config\FacebookProperties;

use cmsgears\social\login\common\models\forms\FbLogin;

use cmsgears\social\login\common\services\FacebookProfileService;

class FacebookController extends \cmsgears\core\frontend\controllers\BaseController {

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

			if( !isset( $snsUser->email ) ) {

				// TODO: Store SNS User in session and ask user for email
			}
			else {

				// Get User
				$user	= FacebookProfileService::getUser( $snsUser, $accessToken );

				// Login and Redirect to home page
				$login	= new FbLogin( $user );

				if( $login->login() ) {

					$this->checkHome();
				}
			}
		}

		// Model not found
		throw new NotFoundHttpException( Yii::$app->cmgCoreMessage->getMessage( CoreGlobal::ERROR_NOT_FOUND ) );
    }
}

?>