<?php
namespace cmsgears\social\login\common\models\forms;

// Yii Imports
use \Yii;

// CMG Imports
use cmsgears\core\common\config\CoreGlobal;

use cmsgears\core\common\models\entities\User;

use cmsgears\core\common\utilities\DateUtil;

class TwitterLogin extends \yii\base\Model {

	// Variables ---------------------------------------------------

	// Globals -------------------------------

	// Constants --------------

	// Public -----------------

	// Protected --------------

	// Variables -----------------------------

	// Public -----------------

	public $email;

	// Protected --------------

	protected $userService;

	// Private ----------------

	private $user;

	// Traits ------------------------------------------------------

	// Constructor and Initialisation ------------------------------

	public function __construct( $user )  {

		$this->user 	= $user;
		$this->email	= $user->email;
	}

	public function init() {

		parent::init();

		$this->userService	= Yii::$app->factory->get( 'userService' );
	}

	// Instance methods --------------------------------------------

	// Yii interfaces ------------------------

	// Yii parent classes --------------------

	// yii\base\Component -----

	// yii\base\Model ---------

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

	// CMG interfaces ------------------------

	// CMG parent classes --------------------

	// Validators ----------------------------

    public function validateUser( $attribute, $params ) {

        if( !$this->hasErrors() ) {

            if( !$this->user ) {

				$this->addError( $attribute, Yii::$app->coreMessage->getMessage( CoreGlobal::ERROR_USER_NOT_EXIST ) );
            }

			if( !$this->hasErrors() && !$this->user->isVerified() ) {

				$this->addError( $attribute, Yii::$app->coreMessage->getMessage( CoreGlobal::ERROR_USER_VERIFICATION ) );
			}

			if( !$this->hasErrors() && $this->user->isBlocked() ) {

				$this->addError( $attribute, Yii::$app->coreMessage->getMessage( CoreGlobal::ERROR_BLOCKED ) );
			}
        }
    }

	// TwitterLogin --------------------------

    public function getUser() {

        if( $this->user === false ) {

            $this->user = $this->userService->getByEmail( $this->email );
        }

        return $this->user;
    }

    public function login() {

        if ( $this->validate() ) {

			$user				= $this->getUser();
			$user->lastLoginAt 	= DateUtil::getDateTime();

			$user->save();

            return Yii::$app->user->login( $user, false );
        }

		return false;
    }
}
