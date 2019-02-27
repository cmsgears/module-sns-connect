<?php
/**
 * This file is part of CMSGears Framework. Please view License file distributed
 * with the source code for license details.
 *
 * @link https://www.cmsgears.org/
 * @copyright Copyright (c) 2015 VulpineCode Technologies Pvt. Ltd.
 */

namespace cmsgears\social\connect\common\services\base;

// CMG Imports
use cmsgears\core\common\services\interfaces\entities\IUserService;
use cmsgears\core\common\services\interfaces\mappers\ISiteMemberService;
use cmsgears\social\connect\common\services\interfaces\base\ISnsProfileService;

use cmsgears\core\common\services\base\EntityService;

/**
 * SnsProfileService provide service methods of SNS profile.
 *
 * @since 1.0.0
 */
abstract class SnsProfileService extends EntityService implements ISnsProfileService {

	// Variables ---------------------------------------------------

	// Globals -------------------------------

	// Constants --------------

	// Public -----------------

	public static $modelClass = '\cmsgears\social\connect\common\models\entities\SnsProfile';

	// Protected --------------

	// Variables -----------------------------

	// Public -----------------

	// Protected --------------

	protected $userService;

	protected $siteMemberService;

	// Private ----------------

	// Traits ------------------------------------------------------

	// Constructor and Initialisation ------------------------------

    public function __construct( IUserService $userService, ISiteMemberService $siteMemberService, $config = [] ) {

		$this->userService			= $userService;
		$this->siteMemberService 	= $siteMemberService;

        parent::__construct( $config );
    }

	// Instance methods --------------------------------------------

	// Yii parent classes --------------------

	// yii\base\Component -----

	// CMG interfaces ------------------------

	// CMG parent classes --------------------

	// SnsProfileService ---------------------

	// Data Provider ------

	// Read ---------------

    // Read - Models ---

   	public function getByTypeSnsId( $type, $snsId ) {

		$modelClass	= static::$modelClass;

		return $modelClass::findByTypeSnsId( $type, $snsId );
	}

    // Read - Lists ----

    // Read - Maps -----

	// Read - Others ---

	// Create -------------

	// Update -------------

	public function update( $model, $config = [] ) {

		$snsUser		= $config[ 'snsUser' ];
		$accessToken	= $config[ 'accessToken' ];

		// Copy Attributes
		$model->token	= $accessToken;
		$model->data	= json_encode( $snsUser );

		// Return updated SnsProfile
		return parent::update( $model, [
			'attributes' => [ 'token', 'data' ]
		]);
	}

	// Delete -------------

	// Bulk ---------------

	// Notifications ------

	// Cache --------------

	// Additional ---------

	// Static Methods ----------------------------------------------

	// CMG parent classes --------------------

	// SnsProfileService ---------------------

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
