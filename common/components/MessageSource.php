<?php
namespace cmsgears\social\connect\common\components;

// Yii Imports
use yii\base\Component;

// CMG Imports
use cmsgears\social\connect\common\config\SnsConnectGlobal;

class MessageSource extends Component {

	// Variables ---------------------------------------------------

	// Global -----------------

	// Public -----------------

	// Protected --------------

	protected $messageDb = [

		// Generic Fields
		SnsConnectGlobal::FIELD_SNS_NETWORK => 'Social Network'
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
