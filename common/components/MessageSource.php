<?php
namespace cmsgears\social\login\common\components;

// CMG Imports
use cmsgears\social\login\common\config\SnsLoginGlobal;

class MessageSource extends \yii\base\Component {

	// Variables ---------------------------------------------------

	// Global -----------------

	// Public -----------------

	// Protected --------------

	protected $messageDb = [

		// Generic Fields
		SnsLoginGlobal::FIELD_SNS_NETWORK => 'Social Network'
	];

	// Private ----------------

	// Constructor and Initialisation ------------------------------

	// Instance methods --------------------------------------------

	// Yii parent classes --------------------

	// CMG parent classes --------------------

	// MessageSource -------------------------

	public function getMessage( $messageKey, $params = [], $language = null ) {

		return $this->messageDb[ $messageKey ];
	}
}
