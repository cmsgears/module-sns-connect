<?php
namespace cmsgears\core\common\services\entities;

// Yii Imports
use \Yii;

// CMG Imports
use cmsgears\core\common\config\CoreGlobal;
use cmsgears\social\login\common\config\SnsLoginGlobal;

use cmsgears\social\login\common\models\base\SnsTables;
use cmsgears\social\login\common\models\entities\SnsProfile;

use cmsgears\social\login\common\services\interfaces\entities\IFacebookProfileService;

class FacebookProfileService extends \cmsgears\social\login\common\services\base\SnsProfileService implements IFacebookProfileService {

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

	public function getUser( $fbUser, $accessToken ) {

		$snsProfile		= $this->getByTypeSnsId( SnsLoginGlobal::SNS_TYPE_FACEBOOK, $fbUser->id );

		if( isset( $snsProfile ) ) {

			$snsProfile	= $this->update( $snsProfile, [ 'snsUser' => $fbUser, 'accessToken' => $accessToken ] );
			$user		= $snsProfile->user;

			return $user;
		}
		else {

			$user 		= $this->userService->getByEmail( $fbUser->email );

			if( !isset( $user ) ) {

				// Create User
				$user 		= $this->register( $fbUser );

				// Add User to current Site
				$this->siteMemberService->create( $user );

				// Trigger Mail
				Yii::$app->snsLoginMailer->sendRegisterFacebookMail( $user );
			}

			$snsProfile	= $this->create( $user, [ 'snsUser' => $fbUser, 'accessToken' => $accessToken ] );

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
		$snsProfileToSave->type		= SnsLoginGlobal::SNS_TYPE_FACEBOOK;
		$snsProfileToSave->snsId	= $snsUser->id;
		$snsProfileToSave->token	= $accessToken;
		$snsProfileToSave->data		= json_encode( $snsUser );

		// Create SnsProfile
		$snsProfileToSave->save();

		// Return SnsProfile
		return $snsProfileToSave;
	}

	public function register( $fbUser ) {

		$user 	= new User();
		$date	= DateUtil::getDateTime();

		$user->email 		= $fbUser->email;
		$user->firstName	= $fbUser->first_name;
		$user->lastName		= $fbUser->last_name;
		$user->newsletter	= false;
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
