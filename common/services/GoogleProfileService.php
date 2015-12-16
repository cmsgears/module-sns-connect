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

class GoogleProfileService extends SnsProfileService {

	// Static Methods ----------------------------------------------

	public static function getUser( $googleUser, $accessToken ) {

		$snsProfile		= self::findByTypeSnsId( SnsLoginGlobal::SNS_TYPE_GOOGLE, $googleUser->id );
		$user			= null;

		if( isset( $snsProfile ) ) {

			$snsProfile	= self::update( $snsProfile, $googleUser, $accessToken );
			$user		= $snsProfile->user;
		}
		else {

			$user 		= UserService::findByEmail( $googleUser->email );
			
			if( !isset( $user ) ) {
				
				// Create User
				$user 		= self::register( $googleUser );

				// Add User to current Site
				SiteMemberService::create( $user );
	
				// Trigger Mail
				Yii::$app->cmgSnsLoginMailer->sendRegisterFacebookMail( $user );
			}

			$snsProfile	= self::create( $user, $googleUser, $accessToken );
		}

		return $user;
	}

	// Create -----------

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

	public static function create( $user, $googleUser, $accessToken ) {

		$snsProfileToSave = new SnsProfile();

		$snsProfileToSave->userId	= $user->id;
		$snsProfileToSave->type		= SnsLoginGlobal::SNS_TYPE_GOOGLE;
		$snsProfileToSave->snsId	= $googleUser->id;
		$snsProfileToSave->token	= $accessToken;
		$snsProfileToSave->data		= json_encode( $googleUser );

		// Create SnsProfile
		$snsProfileToSave->save();

		// Return SnsProfile
		return $snsProfileToSave;
	}
}

?>