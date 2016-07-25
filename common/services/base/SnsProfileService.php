<?php
namespace cmsgears\social\login\common\services\base;

// Yii Imports
use \Yii;

// CMG Imports
use cmsgears\core\common\config\CoreGlobal;
use cmsgears\social\login\common\config\SnsLoginGlobal;

use cmsgears\social\login\common\models\base\SnsTables;
use cmsgears\social\login\common\models\entities\SnsProfile;

use cmsgears\core\common\services\interfaces\entities\IUserService;
use cmsgears\core\common\services\interfaces\mappers\ISiteMemberService;
use cmsgears\social\login\common\services\interfaces\base\ISnsProfileService;

abstract class SnsProfileService extends \yii\base\Object implements ISnsProfileService {

	// Variables ---------------------------------------------------

	// Globals -------------------------------

	// Constants --------------

	// Public -----------------

	public static $modelClass	= '\cmsgears\social\login\common\models\entities\SnsProfile';

	public static $modelTable	= SnsTables::TABLE_SNS_PROFILE;

	public static $parentType	= null;

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

		return SnsProfile::findByTypeSnsId( $type, $snsId );
	}

    // Read - Lists ----

    // Read - Maps -----

	// Read - Others ---

	// Create -------------

	// Update -------------

	public function update( $snsProfile, $config = [] ) {

		$snsUser		= $config[ 'snsUser' ];
		$accessToken	= $config[ 'accessToken' ];

		// Copy Attributes
		$profileToUpdate->token	= $accessToken;
		$profileToUpdate->data	= json_encode( $snsUser );

		// Return updated SnsProfile
		return parent::update( $model, [
			'attributes' => [ 'token', 'data' ]
		]);
	}

	// Delete -------------

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
