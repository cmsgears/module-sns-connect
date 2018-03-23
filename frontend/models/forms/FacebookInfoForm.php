<?php
namespace cmsgears\social\connect\frontend\models\forms;

// Yii Imports
use Yii;
use yii\base\Model;
use yii\helpers\ArrayHelper;

// CMG Imports
use cmsgears\core\common\config\CoreGlobal;

class FacebookInfoForm extends Model {

	// Variables ---------------------------------------------------

	// Public Variables --------------------

	public $email;

	// Instance Methods --------------------------------------------

	// yii\base\Model

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

    public function validateEmail( $attribute, $params ) {

        if( !$this->hasErrors() ) {

			$userService	= Yii::$app->factory->get( 'userService' );

            if( $userService->isExistByEmail( $this->email ) ) {

				$this->addError( $attribute, Yii::$app->coreMessage->getMessage( CoreGlobal::ERROR_EMAIL_EXIST ) );
            }
        }
    }

}
