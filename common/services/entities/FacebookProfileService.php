<?php
namespace cmsgears\social\connect\common\services\entities;

// Yii Imports
use Yii;

// CMG Imports
use cmsgears\social\connect\common\config\SnsConnectGlobal;

use cmsgears\core\common\models\entities\User;
use cmsgears\social\connect\common\models\entities\SnsProfile;

use cmsgears\social\connect\common\services\interfaces\entities\IFacebookProfileService;

use cmsgears\social\connect\common\services\base\SnsProfileService;

use cmsgears\core\common\utilities\DateUtil;

class FacebookProfileService extends SnsProfileService implements IFacebookProfileService {

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

	// FacebookProfileService ----------------

	// Data Provider ------

	// Read ---------------

	public function getUser( $model, $accessToken ) {

		$snsProfile		= $this->getByTypeSnsId( SnsConnectGlobal::SNS_TYPE_FACEBOOK, $model->id );

		if( isset( $snsProfile ) ) {

			$snsProfile	= $this->update( $snsProfile, [ 'snsUser' => $model, 'accessToken' => $accessToken ] );
			$user		= $snsProfile->user;

			return $user;
		}
		else {

			$user 		= $this->userService->getByEmail( $model->email );

			if( !isset( $user ) ) {

				// Create User
				$user 		= $this->register( $model );

				// Add User to current Site
				$this->siteMemberService->create( $user );

				// Trigger Mail
				Yii::$app->snsLoginMailer->sendRegisterFacebookMail( $user );
			}

			$snsProfile	= $this->create( $user, [ 'snsUser' => $model, 'accessToken' => $accessToken ] );

			return $user;
		}

		return false;
	}

    // Read - Models ---

    // Read - Lists ----

    // Read - Maps -----

	// Read - Others ---

	// Create -------------

	public function create( $user, $config = [] ) {

		$snsUser		= $config[ 'snsUser' ];
		$accessToken	= $config[ 'accessToken' ];

		$snsProfileToSave = new SnsProfile();

		$snsProfileToSave->userId	= $user->id;
		$snsProfileToSave->type		= SnsConnectGlobal::SNS_TYPE_FACEBOOK;
		$snsProfileToSave->snsId	= $snsUser->id;
		$snsProfileToSave->token	= $accessToken;
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
		$user->firstName	= $model->first_name;
		$user->lastName		= $model->last_name;
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

	// FacebookProfileService ----------------

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
