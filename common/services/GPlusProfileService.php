<?php
namespace cmsgears\social\login\common\services;

// Yii Imports
use \Yii;

// CMG Imports
use cmsgears\social\login\common\config\SnsLoginGlobal;

use cmsgears\core\common\models\entities\User;
use cmsgears\social\login\common\models\entities\SnsProfile;

use cmsgears\core\common\services\UserService;
use cmsgears\core\common\services\SiteMemberService;

use cmsgears\core\common\utilities\DateUtil;

class GPlusProfileService extends SnsProfileService {

	// Static Methods ----------------------------------------------

	public static function getUser( $gplusUser, $accessToken ) {

		$snsProfile		= self::findByTypeSnsId( SnsLoginGlobal::SNS_TYPE_GPLUS, $gplusUser->id );
		$user			= null;

		if( isset( $snsProfile ) ) {

			$snsProfile	= self::update( $snsProfile, $gplusUser, $accessToken );
			$user		= $snsProfile->user;
		}
		else {

			$user 		= UserService::findByEmail( $gplusUser->email );
			
			if( !isset( $user ) ) {
				
				// Create User
				$user 		= self::register( $gplusUser );

				// Add User to current Site
				SiteMemberService::create( $user );
	
				// Trigger Mail
				Yii::$app->cmgSnsLoginMailer->sendRegisterFacebookMail( $user );
			}

			$snsProfile	= self::create( $user, $gplusUser, $accessToken );
		}

		return $user;
	}

	// Create -----------

	function register( $gplusUser ) {

		$user 	= new User();
		$date	= DateUtil::getDateTime();

		$user->email 		= $gplusUser->email;
		$user->firstName	= $gplusUser->given_name;
		$user->lastName		= $gplusUser->family_name;
		$user->newsletter	= 0;
		$user->registeredAt	= $date;
		$user->status		= User::STATUS_ACTIVE;

		$user->generateVerifyToken();
		$user->generateAuthKey();

		$user->save();

		return $user;
	}

	public static function create( $user, $gplusUser, $accessToken ) {

		$snsProfileToSave = new SnsProfile();

		$snsProfileToSave->userId	= $user->id;
		$snsProfileToSave->type		= SnsLoginGlobal::SNS_TYPE_GPLUS;
		$snsProfileToSave->snsId	= $gplusUser->id;
		$snsProfileToSave->token	= $accessToken;
		$snsProfileToSave->data		= json_encode( $gplusUser );

		// Create SnsProfile
		$snsProfileToSave->save();

		// Return SnsProfile
		return $snsProfileToSave;
	}
}

?>