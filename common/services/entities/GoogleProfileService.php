<?php
namespace cmsgears\core\common\services\entities;

// Yii Imports
use \Yii;

// CMG Imports
use cmsgears\core\common\config\CoreGlobal;
use cmsgears\social\login\common\config\SnsLoginGlobal;

use cmsgears\social\login\common\models\base\SnsTables;
use cmsgears\social\login\common\models\entities\SnsProfile;

use cmsgears\social\login\common\services\interfaces\entities\IGoogleProfileService;

class GoogleProfileService extends \cmsgears\social\login\common\services\base\SnsProfileService implements IGoogleProfileService {

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

	// GoogleProfileService ------------------

	// Data Provider ------

	// Read ---------------

    // Read - Models ---

	public function getUser( $googleUser, $accessToken ) {

		$snsProfile		= $this->getByTypeSnsId( SnsLoginGlobal::SNS_TYPE_GOOGLE, $googleUser->id );
		$user			= null;

		if( isset( $snsProfile ) ) {

			$snsProfile	= $this->update( $snsProfile, [ 'snsUser' => $googleUser, 'accessToken' => $accessToken ] );
			$user		= $snsProfile->user;
		}
		else {

			$user 		= $this->userService->getByEmail( $googleUser->email );

			if( !isset( $user ) ) {

				// Create User
				$user 		= $this->register( $googleUser );

				// Add User to current Site
				$this->siteMemberService->create( $user );

				// Trigger Mail
				Yii::$app->snsLoginMailer->sendRegisterFacebookMail( $user );
			}

			$snsProfile	= $this->create( $user, [ 'snsUser' => $googleUser, 'accessToken' => $accessToken ] );
		}

		return $user;
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
		$snsProfileToSave->type		= SnsLoginGlobal::SNS_TYPE_GOOGLE;
		$snsProfileToSave->snsId	= $snsUser->id;
		$snsProfileToSave->token	= $accessToken;
		$snsProfileToSave->data		= json_encode( $snsUser );

		// Create SnsProfile
		$snsProfileToSave->save();

		// Return SnsProfile
		return $snsProfileToSave;
	}

	function register( $googleUser ) {

		$user 	= new User();
		$date	= DateUtil::getDateTime();

		$user->email 		= $googleUser->email;
		$user->firstName	= $googleUser->given_name;
		$user->lastName		= $googleUser->family_name;
		$user->newsletter	= 0;
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

	// GoogleProfileService ------------------

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
