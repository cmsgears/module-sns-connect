<?php
/**
 * This file is part of CMSGears Framework. Please view License file distributed
 * with the source code for license details.
 *
 * @link https://www.cmsgears.org/
 * @copyright Copyright (c) 2015 VulpineCode Technologies Pvt. Ltd.
 */

namespace cmsgears\social\connect\common\services\entities;

// Yii Imports
use Yii;

// CMG Imports
use cmsgears\social\connect\common\config\SnsConnectGlobal;

use cmsgears\core\common\models\entities\User;

use cmsgears\social\connect\common\services\interfaces\entities\ITwitterProfileService;

use cmsgears\social\connect\common\services\base\SnsProfileService;

use cmsgears\core\common\utilities\DateUtil;

/**
 * TwitterProfileService provide service methods of twitter profile.
 *
 * @since 1.0.0
 */
class TwitterProfileService extends SnsProfileService implements ITwitterProfileService {

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

	public function getUser( $snsUser, $accessToken ) {

		$snsProfile = $this->getByTypeSnsId( SnsConnectGlobal::SNS_TYPE_TWITTER, $snsUser->id );

		$user = null;

		if( isset( $snsProfile ) ) {

			// TODO: Check the update method
			//$snsProfile = $this->update( $snsProfile, [ 'snsUser' => $snsUser, 'accessToken' => $accessToken ] );

			$user = $snsProfile->user;

			return $user;
		}
		else if( isset( $snsUser->email ) ) {

			$user = $this->userService->getByEmail( $snsUser->email );

			if( !isset( $user ) ) {

				// Create User
				$user = $this->register( $snsUser );

				// Add User to current Site
				$this->siteMemberService->create( $user );

				// Trigger Mail
				Yii::$app->snsLoginMailer->sendRegisterTwitterMail( $user );
			}

			$snsProfile	= $this->create( $user, [ 'snsUser' => $snsUser, 'accessToken' => $accessToken ] );

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

		$snsProfileToSave = $this->getModelObject();

		$snsProfileToSave->userId	= $user->id;
		$snsProfileToSave->type		= SnsConnectGlobal::SNS_TYPE_TWITTER;
		$snsProfileToSave->snsId	= strval( $snsUser->id );
		$snsProfileToSave->token	= $accessToken;
		$snsProfileToSave->secret	= $snsUser->secret;
		$snsProfileToSave->data		= json_encode( $snsUser );

		// Create SnsProfile
		$snsProfileToSave->save();

		// Return SnsProfile
		return $snsProfileToSave;
	}

	function register( $model, $config = [] ) {

		$user 	= Yii::$app->get( 'userService' )->getModelObject();
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

	// Bulk ---------------

	// Notifications ------

	// Cache --------------

	// Additional ---------

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
