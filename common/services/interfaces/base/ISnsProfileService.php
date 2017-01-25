<?php
namespace cmsgears\social\login\common\services\interfaces\base;

interface ISnsProfileService extends \cmsgears\core\common\services\interfaces\base\IEntityService {

	// Data Provider ------

	// Read ---------------

	public function getByTypeSnsId( $type, $snsId );

	public function getUser( $snsUser, $accessToken );

    // Read - Models ---

    // Read - Lists ----

    // Read - Maps -----

	// Create -------------

	public function register( $snsUser );

	// Update -------------

	// Delete -------------

}
