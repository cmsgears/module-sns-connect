<?php
namespace cmsgears\social\login\frontend\models\forms;

// Yii Imports
use \Yii;
use yii\validators\FilterValidator;
use yii\helpers\ArrayHelper;
use yii\base\Model;

// CMG Imports
use cmsgears\core\common\config\CoreGlobal;

use cmsgears\core\common\services\UserService;

class TwitterInfoForm extends Model {

	// Variables ---------------------------------------------------

	// Public Variables --------------------

	public $email;

	// Instance Methods --------------------------------------------
	
	// yii\base\Model

	public function rules() {
		
		$trim		= [];

		if( Yii::$app->cmgCore->trimFieldValue ) {

			$trim[] = [ [ 'email' ], 'filter', 'filter' => 'trim', 'skipOnArray' => true ];
		}

        $rules = [
			[ [ 'email' ], 'required' ],
			[ 'email', 'email' ],
			[ 'email', 'validateEmail' ]
		];

		if( Yii::$app->cmgCore->trimFieldValue ) {

			return ArrayHelper::merge( $trim, $rules );
		}

		return $rules;
	}

	public function attributeLabels() {

		return [
			'email' => Yii::$app->cmgCoreMessage->getMessage( CoreGlobal::FIELD_EMAIL )
		];
	}

    public function validateEmail( $attribute, $params ) {

        if( !$this->hasErrors() ) {

            if( UserService::isExistByEmail( $this->email ) ) {
            	
				$this->addError( $attribute, Yii::$app->cmgCoreMessage->getMessage( CoreGlobal::ERROR_EMAIL_EXIST ) );
            }
        }
    }

    public function validateUsername( $attribute, $params ) {

        if( !$this->hasErrors() ) {

            if( UserService::isExistByUsername( $this->username ) ) {

                $this->addError( $attribute, Yii::$app->cmgCoreMessage->getMessage( CoreGlobal::ERROR_USERNAME_EXIST ) );
            }
        }
    }

	public function termsValidator( $attribute, $params ) {

		if( !isset( $this->terms ) || strlen( $this->terms ) <= 0 ) {

			$this->addError( $attribute, Yii::$app->cmgCoreMessage->getMessage( CoreGlobal::ERROR_TERMS ) );
		}
	}
}

?>