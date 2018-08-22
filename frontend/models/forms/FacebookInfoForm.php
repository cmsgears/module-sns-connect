<?php
/**
 * This file is part of CMSGears Framework. Please view License file distributed
 * with the source code for license details.
 *
 * @link https://www.cmsgears.org/
 * @copyright Copyright (c) 2015 VulpineCode Technologies Pvt. Ltd.
 */

namespace cmsgears\social\connect\frontend\models\forms;

// Yii Imports
use Yii;
use yii\base\Model;
use yii\helpers\ArrayHelper;

// CMG Imports
use cmsgears\core\common\config\CoreGlobal;

/**
 * It collect email from user before completing registration of newly signed in users using Facebook Login.
 *
 * @since 1.0.0
 */
class FacebookInfoForm extends Model {

	// Variables ---------------------------------------------------

	// Globals -------------------------------

	// Constants --------------

	// Public -----------------

	// Protected --------------

	// Variables -----------------------------

	// Public -----------------

	public $email;

	// Protected --------------

	// Private ----------------

	// Traits ------------------------------------------------------

	// Constructor and Initialisation ------------------------------

	// Instance methods --------------------------------------------

	// Yii interfaces ------------------------

	// Yii parent classes --------------------

	// yii\base\Component -----

	// yii\base\Model ---------

	public function rules() {

        $rules = [
			[ [ 'email' ], 'required' ],
			[ 'email', 'email' ],
			[ 'email', 'validateEmail' ]
		];

		if( Yii::$app->core->trimFieldValue ) {

			$trim[] = [ [ 'email' ], 'filter', 'filter' => 'trim', 'skipOnArray' => true ];

			return ArrayHelper::merge( $trim, $rules );
		}

		return $rules;
	}

	public function attributeLabels() {

		return [
			'email' => Yii::$app->coreMessage->getMessage( CoreGlobal::FIELD_EMAIL )
		];
	}

	// CMG interfaces ------------------------

	// CMG parent classes --------------------

	// Validators ----------------------------

    public function validateEmail( $attribute, $params ) {

        if( !$this->hasErrors() ) {

			$userService = Yii::$app->factory->get( 'userService' );

            if( $userService->isExistByEmail( $this->email ) ) {

				$this->addError( $attribute, Yii::$app->coreMessage->getMessage( CoreGlobal::ERROR_EMAIL_EXIST ) );
            }
        }
    }

	// FacebookInfoForm ----------------------

}
