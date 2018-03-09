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
 * The sns login index migration inserts the recommended indexes for better performance. It
 * also list down other possible index commented out. These indexes can be created using
 * project based migration script.
 *
 * @since 1.0.0
 */
class m160623_072802_sns_login_index extends Migration {

	// Public Variables

	// Private Variables

	private $prefix;

	public function init() {

		// Table prefix
		$this->prefix = Yii::$app->migration->cmgPrefix;
	}

	public function up() {

		$this->upPrimary();
	}

	private function upPrimary() {

		// SNS Profile
		$this->createIndex( 'idx_' . $this->prefix . 'sns_profile_type', $this->prefix . 'sns_profile', 'type' );
		//$this->createIndex( 'idx_' . $this->prefix . 'sns_profile_snsid', $this->prefix . 'sns_profile', 'snsId' );
	}

	public function down() {

		$this->downPrimary();
	}

	private function downPrimary() {

		// SNS Profile
		$this->dropIndex( 'idx_' . $this->prefix . 'sns_profile_type', $this->prefix . 'sns_profile' );
		//$this->dropIndex( 'idx_' . $this->prefix . 'sns_profile_snsid', $this->prefix . 'sns_profile' );
	}
}
