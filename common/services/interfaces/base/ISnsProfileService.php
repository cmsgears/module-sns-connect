<?php
namespace cmsgears\social\connect\common\services\interfaces\base;

// CMG Imports
use cmsgears\core\common\services\interfaces\base\IEntityService;

interface ISnsProfileService extends IEntityService {

	// Data Provider ------

	// Read ---------------

	public function getByTypeSnsId( $type, $snsId );

	public function getUser( $model, $accessToken );

    // Read - Models ---

    // Read - Lists ----

    // Read - Maps -----

	// Create -------------

	// Update -------------

	// Delete -------------

}
