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

class TwitterProfileService extends SnsProfileService {

	// Static Methods ----------------------------------------------

	public static function getUser( $twitterUser, $accessToken ) {

		$snsProfile		= self::findByTypeSnsId( SnsLoginGlobal::SNS_TYPE_TWITTER, $twitterUser->id );

		if( isset( $snsProfile ) ) {

			$snsProfile	= self::update( $snsProfile, $twitterUser, $accessToken );
			$user		= $snsProfile->user;
			
			return $user;
		}
		else if( isset( $twitterUser->email ) ) {

			$user 		= UserService::findByEmail( $twitterUser->email );

			if( !isset( $user ) ) {

				// Create User
				$user 		= self::register( $twitterUser );

				// Add User to current Site
				SiteMemberService::create( $user );
	
				// Trigger Mail
				Yii::$app->cmgSnsLoginMailer->sendRegisterTwitterMail( $user );
			}

			$snsProfile	= self::create( $user, $twitterUser, $accessToken );
			
			return $user;
		}

		return false;
	}

	// Create -----------

	function register( $twitterUser ) {

		$user 	= new User();
		$date	= DateUtil::getDateTime();

		$user->email 		= $twitterUser->email;
		$user->firstName	= $twitterUser->firstName;
		$user->lastName		= $twitterUser->lastName;
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
		$snsProfileToSave->secret	= $twitterUser->secret;
		$snsProfileToSave->data		= json_encode( $twitterUser );

		// Create SnsProfile
		$snsProfileToSave->save();

		// Return SnsProfile
		return $snsProfileToSave;
	}
}

?>