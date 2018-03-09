<?php
/**
 * This file is part of CMSGears Framework. Please view License file distributed
 * with the source code for license details.
 *
 * @link https://www.cmsgears.org/
 * @copyright Copyright (c) 2015 VulpineCode Technologies Pvt. Ltd.
 */

namespace cmsgears\social\login\common\models\entities;

// Yii Imports
use Yii;
use yii\db\Expression;
use yii\behaviors\TimestampBehavior;

// CMG Imports
use cmsgears\core\common\config\CoreGlobal;
use cmsgears\social\login\common\config\SnsLoginGlobal;

use cmsgears\core\common\models\interfaces\resources\IData;

use cmsgears\core\common\models\base\Entity;
use cmsgears\core\common\models\entities\User;
use cmsgears\social\login\common\models\base\SnsTables;

use cmsgears\core\common\models\traits\resources\DataTrait;

/**
 * SnsProfile store the token and secret of auth clients used to login with social
 * accounts.
 *
 * @property integer $id
 * @property integer $userId
 * @property integer $type
 * @property string $snsId
 * @property string $token
 * @property string $secret
 * @property datetime $createdAt
 * @property datetime $modifiedAt
 * @property string $data
 *
 * @since 1.0.0
 */
class SnsProfile extends Entity implements IData {

	// Variables ---------------------------------------------------

	// Globals -------------------------------

	// Constants --------------

	// Public -----------------

	// Protected --------------

	// Variables -----------------------------

	// Public -----------------

	// Protected --------------

	// Private ----------------

	// Traits ------------------------------------------------------

	use DataTrait;

	// Constructor and Initialisation ------------------------------

	// Instance methods --------------------------------------------

	// Yii interfaces ------------------------

	// Yii parent classes --------------------

	// yii\base\Component -----

    /**
     * @inheritdoc
     */
    public function behaviors() {

        return [

            'timestampBehavior' => [
                'class' => TimestampBehavior::class,
				'createdAtAttribute' => 'createdAt',
 				'updatedAtAttribute' => 'modifiedAt',
 				'value' => new Expression('NOW()')
            ]
        ];
    }

	// yii\base\Model ---------

    /**
     * @inheritdoc
     */
	public function rules() {

		// Model Rules
        $rules = [
        	// Required, Safe
            [ [ 'type', 'snsId', 'token' ], 'required' ],
			[ [ 'id', 'userId', 'data' ], 'safe' ],
			// Unique
			[ [ 'snsId', 'userId', 'type' ], 'unique', 'targetAttribute' => [ 'snsId', 'userId', 'type' ], 'comboNotUnique' => Yii::$app->coreMessage->getMessage( CoreGlobal::ERROR_EXIST ) ],
            // Text Limit
            [ 'type', 'string', 'min' => 1, 'max' => Yii::$app->core->mediumText ],
            [ [ 'snsId', 'token', 'secret' ], 'string', 'min' => 1, 'max' => Yii::$app->core->xLargeText ],
			// Other
            [ [ 'createdAt', 'modifiedAt' ], 'date', 'format' => Yii::$app->formatter->datetimeFormat ]
        ];

		return $rules;
    }

    /**
     * @inheritdoc
     */
	public function attributeLabels() {

		return [
			'userId' => Yii::$app->coreMessage->getMessage( CoreGlobal::FIELD_USER ),
			'type' => Yii::$app->coreMessage->getMessage( CoreGlobal::FIELD_TYPE ),
			'snsId' => Yii::$app->snsLoginMessage->getMessage( SnsLoginGlobal::FIELD_SNS_NETWORK ),
			'token' => Yii::$app->coreMessage->getMessage( CoreGlobal::FIELD_TOKEN ),
			'data' => Yii::$app->coreMessage->getMessage( CoreGlobal::FIELD_DATA )
		];
	}

	// CMG interfaces ------------------------

	// CMG parent classes --------------------

	// Validators ----------------------------

	// SnsProfile ----------------------------

	public function getUser() {

		return $this->hasOne( User::class, [ 'id' => 'userId' ] );
	}

	// Static Methods ----------------------------------------------

	// Yii parent classes --------------------

	// yii\db\ActiveRecord ----

    /**
     * @inheritdoc
     */
	public static function tableName() {

		return SnsTables::getTableName( SnsTables::TABLE_SNS_PROFILE );
	}

	// CMG parent classes --------------------

	// SnsProfile ----------------------------

	// Read - Query -----------

    /**
     * @inheritdoc
     */
	public static function queryWithHasOne( $config = [] ) {

		$relations				= isset( $config[ 'relations' ] ) ? $config[ 'relations' ] : [ 'user' ];
		$config[ 'relations' ]	= $relations;

		return parent::queryWithAll( $config );
	}

	// Read - Find ------------

	/**
	 * Find and return the sns profile using given type and sns id.
	 *
	 * @param string $type
	 * @param string $snsId
	 * @return SnsProfile
	 */
	public static function findByTypeSnsId( $type, $snsId ) {

		return self::find()->where( 'type=:type AND snsId=:snsId', [ ':type' => $type, ':snsId' => $snsId ] )->one();
	}

	// Create -----------------

	// Update -----------------

	// Delete -----------------

}
