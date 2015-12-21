<?php
namespace cmsgears\social\login\common\services;

// Yii Imports
use \Yii;

// CMG Imports
use cmsgears\social\login\common\config\SnsLoginGlobal;

use cmsgears\core\common\models\entities\User;
use cmsgears\social\login\common\models\entities\SnsTables;
use cmsgears\social\login\common\models\entities\SnsProfile;

use cmsgears\core\common\utilities\DateUtil;

/**
 * The class SnsProfileService is base class to perform database activities for SnsProfile Entity.
 */
class SnsProfileService extends \cmsgears\core\common\services\Service {

	// Static Methods ----------------------------------------------

	// Read ----------------

	/**
	 * @param integer $id
	 * @return SnsProfile
	 */
	public static function findById( $id ) {

		return SnsProfile::findById( $id );
	}

	/**
	 * @param string $type
	 * @param string $snsId
	 * @return SnsProfile
	 */
	public static function findByTypeSnsId( $type, $snsId ) {

		return SnsProfile::findByTypeSnsId( $type, $snsId );
	}

	// Data Provider ----

	/**
	 * @param array $config to generate query
	 * @return ActiveDataProvider
	 */
	public static function getPagination( $config = [] ) {

		return self::getDataProvider( new SnsProfile(), $config );
	}

	// Update -----------

	public static function update( $snsProfile, $snsUser, $accessToken ) {

		// Find existing SnsProfile
		$profileToUpdate	= self::findById( $snsProfile->id );

		// Copy Attributes
		$profileToUpdate->token	= $accessToken;
		$profileToUpdate->data	= json_encode( $snsUser );

		// Update SnsProfile
		$profileToUpdate->update();

		// Return updated SnsProfile
		return $profileToUpdate;
	}

	// Delete -----------

	public static function delete( $profile ) {

		// Find existing SnsProfile
		$profileToDelete	= self::findById( $profile->id );

		// Delete SnsProfile
		$profileToDelete->delete();

		return true;
	}
}

?>