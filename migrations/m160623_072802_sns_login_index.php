<?php

class m160623_072802_sns_login_index extends \yii\db\Migration {

	// Public Variables

	// Private Variables

	private $prefix;

	public function init() {

		// Fixed
		$this->prefix	= 'cmg_';
	}

	public function up() {

		$this->upPrimary();
	}

	private function upPrimary() {

		// SNS Profile
		$this->createIndex( 'idx_' . $this->prefix . 'sns_profile_type', $this->prefix . 'sns_profile', 'type' );
	}

	public function down() {

		$this->downPrimary();
	}

	private function downPrimary() {

		// SNS Profile
		$this->dropIndex( 'idx_' . $this->prefix . 'sns_profile_type', $this->prefix . 'sns_profile' );
	}
}