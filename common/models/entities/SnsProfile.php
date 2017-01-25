<?php
namespace cmsgears\social\login\common\models\entities;

// Yii Imports
use \Yii;
use yii\db\Expression;
use yii\behaviors\TimestampBehavior;

// CMG Imports
use cmsgears\core\common\config\CoreGlobal;
use cmsgears\social\login\common\config\SnsLoginGlobal;

use cmsgears\core\common\models\entities\User;
use cmsgears\core\common\models\traits\resources\DataTrait;
use cmsgears\social\login\common\models\base\SnsTables;

/**
 * SnsProfile Entity
 *
 * @property integer $id
 * @property integer $userId
 * @property integer $type
 * @property string $snsId
 * @property string $token
 * @property datetime $createdAt
 * @property datetime $modifiedAt
 * @property string $data
 */
class SnsProfile extends \cmsgears\core\common\models\base\Entity {

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
                'class' => TimestampBehavior::className(),
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

        return [
        	// Required, Safe
            [ [ 'type', 'snsId', 'token' ], 'required' ],
			[ [ 'id', 'userId', 'data' ], 'safe' ],
            // Text Limit
            [ [ 'type' ], 'string', 'min' => 1, 'max' => Yii::$app->core->mediumText ],
            [ [ 'snsId', 'token', 'secret' ], 'string', 'min' => 1, 'max' => Yii::$app->core->xLargeText ],
			// Other
            [ [ 'createdAt', 'modifiedAt' ], 'date', 'format' => Yii::$app->formatter->datetimeFormat ]
        ];
    }

    /**
     * @inheritdoc
     */
	public function attributeLabels() {

		return [
			'userId' => Yii::$app->coreMessage->getMessage( CoreGlobal::FIELD_USER ),
			'type' => Yii::$app->coreMessage->getMessage( CoreGlobal::FIELD_TYPE ),
			'snsId' => 'Social Network',
			'token' => 'Token',
			'data' => Yii::$app->coreMessage->getMessage( CoreGlobal::FIELD_DATA )
		];
	}

	// CMG interfaces ------------------------

	// CMG parent classes --------------------

	// Validators ----------------------------

	// SnsProfile ----------------------------

	public function getUser() {

		return $this->hasOne( User::className(), [ 'id' => 'userId' ] );
	}

	// Static Methods ----------------------------------------------

	// Yii parent classes --------------------

	// yii\db\ActiveRecord ----

    /**
     * @inheritdoc
     */
	public static function tableName() {

		return SnsTables::TABLE_SNS_PROFILE;
	}

	// CMG parent classes --------------------

	// SnsProfile ----------------------------

	// Read - Query -----------

	public static function queryWithHasOne( $config = [] ) {

		$relations				= isset( $config[ 'relations' ] ) ? $config[ 'relations' ] : [ 'user' ];
		$config[ 'relations' ]	= $relations;

		return parent::queryWithAll( $config );
	}

	// Read - Find ------------

	/**
	 * @return SnsProfile - by slug.
	 */
	public static function findByTypeSnsId( $type, $snsId ) {

		return self::find()->where( 'type=:type AND snsId=:snsId', [ ':type' => $type, ':snsId' => $snsId ] )->one();
	}

	// Create -----------------

	// Update -----------------

	// Delete -----------------
}