<?php
/**
 * This file is part of CMSGears Framework. Please view License file distributed
 * with the source code for license details.
 *
 * @link https://www.cmsgears.org/
 * @copyright Copyright (c) 2015 VulpineCode Technologies Pvt. Ltd.
 */

// CMG Imports
use cmsgears\core\common\base\Migration;

/**
 * The sns connect migration inserts the database tables of sns connect module. It also insert
 * the foreign keys if FK flag of migration component is true.
 *
 * @since 1.0.0
 */
class m160901_072358_sns_connect extends Migration {

	// Public Variables

	public $fk;
	public $options;

	// Private Variables

	private $prefix;

	public function init() {

		// Table prefix
		$this->prefix = Yii::$app->migration->cmgPrefix;

		// Get the values via config
		$this->fk		= Yii::$app->migration->isFk();
		$this->options	= Yii::$app->migration->getTableOptions();

		// Default collation
		if( $this->db->driverName === 'mysql' ) {

			$this->options = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
		}
	}

    public function up() {

		// SNS Profile
		$this->upSnsProfile();

		if( $this->fk ) {

			$this->generateForeignKeys();
		}
    }

	private function upSnsProfile() {

        $this->createTable( $this->prefix . 'sns_profile', [
			'id' => $this->bigPrimaryKey( 20 ),
			'userId' => $this->bigInteger( 20 ),
			'type' => $this->string( Yii::$app->core->mediumText )->notNull(),
			'snsId' => $this->string(Yii::$app->core->xLargeText )->notNull(),
			'token' => $this->string(Yii::$app->core->xxLargeText )->notNull(),
			'secret' => $this->string(Yii::$app->core->xLargeText ),
			'status' => $this->smallInteger( 6 )->notNull()->defaultValue( 0 ),
			'tokenExpiresAt' => $this->dateTime(),
			'createdAt' => $this->dateTime()->notNull(),
			'modifiedAt' => $this->dateTime(),
			'data' => $this->text()
        ], $this->options );

        // Index for columns site, parent, creator and modifier
		$this->createIndex( 'idx_' . $this->prefix . 'sns_profile_user', $this->prefix . 'sns_profile', 'userId' );
	}

	private function generateForeignKeys() {

		$this->addForeignKey( 'fk_' . $this->prefix . 'sns_profile_user', $this->prefix . 'sns_profile', 'userId', $this->prefix . 'core_user', 'id', 'CASCADE' );
	}

    public function down() {

		if( $this->fk ) {

			$this->dropForeignKeys();
		}

        $this->dropTable( $this->prefix . 'sns_profile' );
    }

	private function dropForeignKeys() {

		$this->dropForeignKey( 'fk_' . $this->prefix . 'sns_profile_user', $this->prefix . 'sns_profile' );
	}

}
