<?php
namespace cmsgears\social\login\common\models\forms;

// Yii Imports
use \Yii;

// CMG Imports
use cmsgears\core\common\config\CoreGlobal;

use cmsgears\core\common\models\entities\User;

use cmsgears\core\common\services\UserService;

use cmsgears\core\common\utilities\DateUtil;

class GoogleLogin extends \yii\base\Model {

	// Variables ---------------------------------------------------

	// Public Variables --------------------
	
	public $email;

	// Private Variables -------------------

    private $_user;

	// Constructor and Initialisation ------------------------------

	public function __construct( $user )  {

		$this->_user 	= $user;
		$this->email	= $user->email;
	}

	// Instance Methods --------------------------------------------

	// yii\base\Model

	public function rules() {

		return  [
			[ [ 'email' ], 'required' ],
			[ 'email', 'email' ],
			[ 'email', 'validateUser' ]
		];
	}

	public function attributeLabels() {

		return [
			'email' => 'Email'
		];
	}

	// LoginForm

    public function getUser() {

        if( $this->_user === false ) {

            $this->_user = UserService::findByEmail( $this->email );
        }

        return $this->_user;
    }

    public function validateUser( $attribute, $params ) {

        if( !$this->hasErrors() ) {

            if( !$this->user ) {

				$this->addError( $attribute, Yii::$app->cmgCoreMessage->getMessage( CoreGlobal::ERROR_USER_NOT_EXIST ) );
            }

			if( !$this->hasErrors() && !$this->user->isConfirmed() ) {

				$this->addError( $attribute, Yii::$app->cmgCoreMessage->getMessage( CoreGlobal::ERROR_USER_VERIFICATION ) );
			}

			if( !$this->hasErrors() && $this->user->isBlocked() ) {

				$this->addError( $attribute, Yii::$app->cmgCoreMessage->getMessage( CoreGlobal::ERROR_BLOCKED ) );
			}
        }
    }

    public function login() {

        if ( $this->validate() ) {

			$user				= $this->user;
			$user->lastLoginAt 	= DateUtil::getDateTime();

			$user->save();

            return Yii::$app->user->login( $user, 0 );
        }

		return false;
    }
}

?>