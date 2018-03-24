<?php
/**
 * This file is part of CMSGears Framework. Please view License file distributed
 * with the source code for license details.
 *
 * @link https://www.cmsgears.org/
 * @copyright Copyright (c) 2015 VulpineCode Technologies Pvt. Ltd.
 */

namespace cmsgears\social\connect\common\services\interfaces\base;

// CMG Imports
use cmsgears\core\common\services\interfaces\base\IEntityService;

/**
 * ISnsProfileService declares methods specific to sns login.
 *
 * @since 1.0.0
 */
interface ISnsProfileService extends IEntityService {

	// Data Provider ------

	// Read ---------------

	// Read - Models ---

	public function getByTypeSnsId( $type, $snsId );

	public function getUser( $model, $accessToken );

	// Read - Lists ----

	// Read - Maps -----

	// Read - Others ---

	// Create -------------

	// Update -------------

	// Delete -------------

	// Bulk ---------------

	// Notifications ------

	// Cache --------------

	// Additional ---------

}
