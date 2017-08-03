<?php
namespace cmsgears\social\login\common\services\entities;

// Yii Imports
use Yii;

// CMG Imports
use cmsgears\social\login\common\config\SnsLoginGlobal;

use cmsgears\core\common\models\entities\User;
use cmsgears\social\login\common\models\entities\SnsProfile;

use cmsgears\social\login\common\services\interfaces\entities\ITwitterProfileService;

use cmsgears\core\common\utilities\DateUtil;

class TwitterProfileService extends \cmsgears\social\login\common\services\base\SnsProfileService implements ITwitterProfileService {

	// Variables ---------------------------------------------------

	// Globals -------------------------------

	// Constants --------------

	// Public -----------------

	// Protected --------------

	// Variables -----------------------------

	// Public -----------------

	// Protected --------------

	// Private ----------------

	// Traits ------------------------------------------------------

	// Constructor and Initialisation ------------------------------

	// Instance methods --------------------------------------------

	// Yii parent classes --------------------

	// yii\base\Component -----

	// CMG interfaces ------------------------

	// CMG parent classes --------------------

	// TwitterProfileService -----------------

	// Data Provider ------

	// Read ---------------

    // Read - Models ---

	public function getUser( $model, $accessToken ) {

		$snsProfile		= $this->getByTypeSnsId( SnsLoginGlobal::SNS_TYPE_TWITTER, $model->id );

		if( isset( $snsProfile ) ) {

			$snsProfile	= $this->update( $snsProfile, [ 'snsUser' => $model, 'accessToken' => $accessToken ] );
			$user		= $snsProfile->user;

			return $user;
		}
		else if( isset( $model->email ) ) {

			$user 		= $this->userService->getByEmail( $model->email );

			if( !isset( $user ) ) {

				// Create User
				$user 		= $this->register( $model );

				// Add User to current Site
				$this->siteMemberService->create( $user );

				// Trigger Mail
				Yii::$app->snsLoginMailer->sendRegisterTwitterMail( $user );
			}

			$snsProfile	= $this->create( $user, [ 'snsUser' => $model, 'accessToken' => $accessToken ] );

			return $user;
		}

		return false;
	}

    // Read - Lists ----

    // Read - Maps -----

	// Read - Others ---

	// Create -------------

	public function create( $user, $config = [] ) {

		$snsUser		= $config[ 'snsUser' ];
		$accessToken	= $config[ 'accessToken' ];

		$snsProfileToSave = new SnsProfile();

		$snsProfileToSave->userId	= $user->id;
		$snsProfileToSave->type		= SnsLoginGlobal::SNS_TYPE_TWITTER;
		$snsProfileToSave->snsId	= $snsUser->id;
		$snsProfileToSave->token	= $accessToken;
		$snsProfileToSave->secret	= $snsUser->secret;
		$snsProfileToSave->data		= json_encode( $snsUser );

		// Create SnsProfile
		$snsProfileToSave->save();

		// Return SnsProfile
		return $snsProfileToSave;
	}

	function register( $model, $config = [] ) {

		$user 	= new User();
		$date	= DateUtil::getDateTime();

		$user->email 		= $model->email;
		$user->firstName	= $model->firstName;
		$user->lastName		= $model->lastName;
		$user->registeredAt	= $date;
		$user->status		= User::STATUS_ACTIVE;

		$user->generateVerifyToken();
		$user->generateAuthKey();

		$user->save();

		return $user;
	}

	// Update -------------

	// Delete -------------

	// Static Methods ----------------------------------------------

	// CMG parent classes --------------------

	// TwitterProfileService -----------------

	// Data Provider ------

	// Read ---------------

    // Read - Models ---

    // Read - Lists ----

    // Read - Maps -----

	// Read - Others ---

	// Create -------------

	// Update -------------

	// Delete -------------
}
