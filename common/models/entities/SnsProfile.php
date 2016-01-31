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
class SnsProfile extends \cmsgears\core\common\models\entities\CmgEntity {

	// Instance Methods --------------------------------------------

	public function getUser() {

		return $this->hasOne( User::className(), [ 'id' => 'userId' ] );
	}

	// yii\base\Component ----------------

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

	// yii\base\Model --------------------

    /**
     * @inheritdoc
     */
	public function rules() {

        return [
            [ [ 'type', 'snsId', 'token' ], 'required' ],
			[ [ 'id', 'userId', 'data' ], 'safe' ],
            [ [ 'createdAt', 'modifiedAt' ], 'date', 'format' => Yii::$app->formatter->datetimeFormat ]
        ];
    }

    /**
     * @inheritdoc
     */
	public function attributeLabels() {

		return [
			'userId' => Yii::$app->cmgCoreMessage->getMessage( CoreGlobal::FIELD_USER ),
			'type' => Yii::$app->cmgCoreMessage->getMessage( CoreGlobal::FIELD_TYPE ),
			'snsId' => Yii::$app->cmgCoreMessage->getMessage( CoreGlobal::FIELD_TYPE ),
			'token' => Yii::$app->cmgCoreMessage->getMessage( CoreGlobal::FIELD_TYPE ),
			'data' => Yii::$app->cmgCoreMessage->getMessage( CoreGlobal::FIELD_TYPE )
		];
	}

	// Static Methods ----------------------------------------------

    /**
     * @inheritdoc
     */
	public static function tableName() {

		return SnsTables::TABLE_SNS_PROFILE;
	}

	// SnsProfile

	// Read ------

	/**
	 * @return SnsProfile - by slug.
	 */
	public static function findByTypeSnsId( $type, $snsId ) {

		return self::find()->where( 'type=:type AND snsId=:snsId', [ ':type' => $type, ':snsId' => $snsId ] )->one();
	}
}

?>