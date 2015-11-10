<?php
namespace cmsgears\social\login\common\services;

// Yii Imports
use \Yii;

// CMG Imports
use cmsgears\social\login\common\config\SnsLoginGlobal;

use cmsgears\core\common\models\entities\User;
use cmsgears\social\login\common\models\entities\SnsProfile;

use cmsgears\core\common\services\SiteMemberService;

use cmsgears\core\common\utilities\DateUtil;

class TwitterProfileService extends SnsProfileService {

	// Static Methods ----------------------------------------------

	public static function getUser( $twitterUser, $accessToken ) {

		$snsProfile		= self::findByTypeSnsId( SnsLoginGlobal::SNS_TYPE_TWITTER, $twitterUser->id );
		$user			= null;

		if( isset( $snsProfile ) ) {

			$snsProfile	= self::update( $snsProfile, $twitterUser, $accessToken );
			$user		= $snsProfile->user;
		}
		else {

			// Create User
			$user 		= self::register( $twitterUser );
			$snsProfile	= self::create( $user, $twitterUser, $accessToken );

			// Add User to current Site
			SiteMemberService::create( $user );

			// Trigger Mail
			Yii::$app->cmgSnsLoginMailer->sendRegisterTwitterMail( $user );
		}

		return $user;
	}

	// Create -----------

	function register( $twitterUser ) {

		$user 	= new User();
		$date	= DateUtil::getDateTime();

		$user->email 		= $twitterUser->email;
		$user->firstName	= $twitterUser->given_name;
		$user->lastName		= $twitterUser->family_name;
		$user->newsletter	= 0;
		$user->registeredAt	= $date;
		$user->status		= User::STATUS_ACTIVE;

		$user->generateVerifyToken();
		$user->generateAuthKey();

		$user->save();

		return $user;
	}

	public static function create( $user, $twitterUser, $accessToken ) {

		$snsProfileToSave = new SnsProfile();

		$snsProfileToSave->userId	= $user->id;
		$snsProfileToSave->type		= SnsLoginGlobal::SNS_TYPE_TWITTER;
		$snsProfileToSave->snsId	= $twitterUser->id;
		$snsProfileToSave->token	= $accessToken;
		$snsProfileToSave->data		= json_encode( $twitterUser );

		// Create SnsProfile
		$snsProfileToSave->save();

		// Return SnsProfile
		return $snsProfileToSave;
	}
}

?>