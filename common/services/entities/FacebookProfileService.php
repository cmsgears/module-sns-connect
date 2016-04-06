<?php
namespace cmsgears\social\login\common\services\entities;

// Yii Imports
use \Yii;

// CMG Imports
use cmsgears\social\login\common\config\SnsLoginGlobal;

use cmsgears\core\common\models\entities\User;
use cmsgears\social\login\common\models\entities\SnsProfile;

use cmsgears\core\common\services\entities\UserService;
use cmsgears\core\common\services\mappers\SiteMemberService;

use cmsgears\core\common\utilities\DateUtil;

class FacebookProfileService extends \cmsgears\social\login\common\services\base\SnsProfileService {

	// Static Methods ----------------------------------------------

	public static function getUser( $fbUser, $accessToken ) {

		$snsProfile		= self::findByTypeSnsId( SnsLoginGlobal::SNS_TYPE_FACEBOOK, $fbUser->id );

		if( isset( $snsProfile ) ) {

			$snsProfile	= self::update( $snsProfile, $fbUser, $accessToken );
			$user		= $snsProfile->user;

			return $user;
		}
		else {

			$user 		= UserService::findByEmail( $fbUser->email );

			if( !isset( $user ) ) {

				// Create User
				$user 		= self::register( $fbUser );

				// Add User to current Site
				SiteMemberService::create( $user );

				// Trigger Mail
				Yii::$app->cmgSnsLoginMailer->sendRegisterFacebookMail( $user );
			}

			$snsProfile	= self::create( $user, $fbUser, $accessToken );

			return $user;
		}

		return false;
	}

	// Create -----------

	public static function register( $fbUser ) {

		$user 	= new User();
		$date	= DateUtil::getDateTime();

		$user->email 		= $fbUser->email;
		$user->firstName	= $fbUser->first_name;
		$user->lastName		= $fbUser->last_name;
		$user->newsletter	= 0;
		$user->registeredAt	= $date;
		$user->status		= User::STATUS_ACTIVE;

		$user->generateVerifyToken();
		$user->generateAuthKey();

		$user->save();

		return $user;
	}

	public static function create( $user, $fbUser, $accessToken ) {

		$snsProfileToSave = new SnsProfile();

		$snsProfileToSave->userId	= $user->id;
		$snsProfileToSave->type		= SnsLoginGlobal::SNS_TYPE_FACEBOOK;
		$snsProfileToSave->snsId	= $fbUser->id;
		$snsProfileToSave->token	= $accessToken;
		$snsProfileToSave->data		= json_encode( $fbUser );

		// Create SnsProfile
		$snsProfileToSave->save();

		// Return SnsProfile
		return $snsProfileToSave;
	}
}

?>