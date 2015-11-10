<?php
namespace cmsgears\social\login\frontend\controllers;

// Yii Imports
use Yii;
use yii\filters\VerbFilter;
use yii\web\NotFoundHttpException;

// CMG Imports
use cmsgears\core\common\config\CoreGlobal;
use cmsgears\social\login\common\config\SnsLoginGlobal;
use cmsgears\social\login\common\config\GPlusProperties;

use cmsgears\social\login\common\models\forms\GPlusLogin;

use cmsgears\social\login\common\services\GPlusProfileService;

class GplusController extends \cmsgears\core\frontend\controllers\BaseController {

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

		$gplusProperties	= GPlusProperties::getInstance();

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
    }
}

?>