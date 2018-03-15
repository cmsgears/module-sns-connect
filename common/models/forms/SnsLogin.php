<?php
/**
 * This file is part of CMSGears Framework. Please view License file distributed
 * with the source code for license details.
 *
 * @link https://www.cmsgears.org/
 * @copyright Copyright (c) 2015 VulpineCode Technologies Pvt. Ltd.
 */

namespace cmsgears\social\connect\common\models\forms;

// Yii Imports
use Yii;
use yii\base\Model;
use yii\helpers\ArrayHelper;

// CMG Imports
use cmsgears\core\common\config\CoreGlobal;

use cmsgears\core\common\utilities\DateUtil;

abstract class SnsLogin extends Model {

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

	protected $user;

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

    /**
     * @inheritdoc
     */
	public function rules() {

		// Model Rules
		$rules = [
			// Required, Safe
			[ 'email', 'required' ],
			[ 'email', 'email' ],
			[ 'email', 'validateUser' ]
		];

		// Trim Text
		if( Yii::$app->core->trimFieldValue ) {

			$trim[] = [ 'email', 'filter', 'filter' => 'trim', 'skipOnArray' => true ];

			return ArrayHelper::merge( $trim, $rules );
		}

		return $rules;
	}

    /**
     * @inheritdoc
     */
	public function attributeLabels() {

		return [
			'email' => Yii::$app->coreMessage->getMessage( CoreGlobal::FIELD_EMAIL )
		];
	}

	// CMG interfaces ------------------------

	// CMG parent classes --------------------

	// Validators ----------------------------

	/**
	 * Check whether valid user already exist and available for SNS login.
	 *
	 * @param string $attribute
	 * @param array $params
	 * @return void
	 */
    public function validateUser( $attribute, $params ) {

        if( !$this->hasErrors() ) {

			$user = $this->user;

            if( !isset( $user ) ) {

				$this->addError( $attribute, Yii::$app->coreMessage->getMessage( CoreGlobal::ERROR_USER_NOT_EXIST ) );
            }
			else {

				if( !$this->hasErrors() && !$user->isVerified( false ) ) {

					$this->addError( $attribute, Yii::$app->coreMessage->getMessage( CoreGlobal::ERROR_USER_VERIFICATION ) );
				}

				if( !$this->hasErrors() && $user->isBlocked() ) {

					$this->addError( $attribute, Yii::$app->coreMessage->getMessage( CoreGlobal::ERROR_BLOCKED ) );
				}
			}
        }
    }

	// FacebookLogin -------------------------

	/**
	 * Return the user for [[$email]].
	 *
	 * @return \cmsgears\core\common\models\entities\User
	 */
    public function getUser() {

        if( $this->user === false ) {

            $this->user = $this->userService->getByEmail( $this->email );
        }

        return $this->user;
    }

	/**
	 * Logs in the user.
	 *
	 * @return boolean
	 */
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
