<?php
/**
 * This file is part of CMSGears Framework. Please view License file distributed
 * with the source code for license details.
 *
 * @link https://www.cmsgears.org/
 * @copyright Copyright (c) 2015 VulpineCode Technologies Pvt. Ltd.
 */

// CMG Imports
use cmsgears\core\common\config\CoreGlobal;

use cmsgears\core\common\base\Migration;

use cmsgears\core\common\models\entities\Site;
use cmsgears\core\common\models\entities\User;
use cmsgears\core\common\models\resources\Form;
use cmsgears\core\common\models\resources\FormField;

use cmsgears\core\common\utilities\DateUtil;

/**
 * The sns connect data migration inserts the base data required to run the application.
 *
 * @since 1.0.0
 */
class m160623_072403_sns_connect_data extends Migration {

	// Public Variables

	// Private Variables

	private $prefix;

	private $site;

	private $master;

	public function init() {

		// Table prefix
		$this->prefix	= Yii::$app->migration->cmgPrefix;

		$this->site		= Site::findBySlug( CoreGlobal::SITE_MAIN );
		$this->master	= User::findByUsername( Yii::$app->migration->getSiteMaster() );

		Yii::$app->core->setSite( $this->site );
	}

    public function up() {

		// Create various config
		$this->insertFacebookConfig();
		$this->insertGoogleConfig();
		$this->insertTwitterConfig();

		// Init default config
		$this->insertDefaultConfig();
    }

	private function insertFacebookConfig() {

		$this->insert( $this->prefix . 'core_form', [
            'siteId' => $this->site->id,
            'createdBy' => $this->master->id, 'modifiedBy' => $this->master->id,
            'name' => 'Config Facebook', 'slug' => 'config-facebook',
            'type' => CoreGlobal::TYPE_SYSTEM,
            'description' => 'Facebook configuration form.',
            'success' => 'All configurations saved successfully.',
            'captcha' => false,
            'visibility' => Form::VISIBILITY_PROTECTED,
            'status' => Form::STATUS_ACTIVE, 'userMail' => false, 'adminMail' => false,
            'createdAt' => DateUtil::getDateTime(),
            'modifiedAt' => DateUtil::getDateTime()
        ]);

		$config	= Form::findBySlugType( 'config-facebook', CoreGlobal::TYPE_SYSTEM );

		$columns = [ 'formId', 'name', 'label', 'type', 'compress', 'validators', 'order', 'icon', 'htmlOptions' ];

		$fields	= [
			[ $config->id, 'active', 'Active', FormField::TYPE_TOGGLE, false, 'required', 0, NULL, '{"title":"Check whether Facebook Login is active."}' ],
			[ $config->id, 'app_id', 'App Id', FormField::TYPE_TEXT, false, 'required', 0, NULL, '{"title":"Application Id.","placeholder":"Application Id"}' ],
			[ $config->id, 'app_secret', 'App Secret', FormField::TYPE_PASSWORD, false, 'required', 0, NULL, '{"title":"Application Secret.","placeholder":"Application Secret"}' ],
			[ $config->id, 'redirect_uri', 'Redirect URI', FormField::TYPE_TEXT, false, 'required', 0, NULL, '{"title":"Redirect URI.","placeholder":"Redirect URI"}' ]
		];

		$this->batchInsert( $this->prefix . 'core_form_field', $columns, $fields );
	}

	private function insertGoogleConfig() {

		$this->insert( $this->prefix . 'core_form', [
            'siteId' => $this->site->id,
            'createdBy' => $this->master->id, 'modifiedBy' => $this->master->id,
            'name' => 'Config Google', 'slug' => 'config-google',
            'type' => CoreGlobal::TYPE_SYSTEM,
            'description' => 'Google configuration form.',
            'success' => 'All configurations saved successfully.',
            'captcha' => false,
            'visibility' => Form::VISIBILITY_PROTECTED,
            'status' => Form::STATUS_ACTIVE, 'userMail' => false, 'adminMail' => false,
            'createdAt' => DateUtil::getDateTime(),
            'modifiedAt' => DateUtil::getDateTime()
        ]);

		$config	= Form::findBySlugType( 'config-google', CoreGlobal::TYPE_SYSTEM );

		$columns = [ 'formId', 'name', 'label', 'type', 'compress', 'validators', 'order', 'icon', 'htmlOptions' ];

		$fields	= [
			[ $config->id, 'active', 'Active', FormField::TYPE_TOGGLE, false, 'required', 0, NULL, '{"title":"Check whether Google Login is active."}' ],
			[ $config->id, 'app_id', 'App Id', FormField::TYPE_TEXT, false, 'required', 0, NULL, '{"title":"Application Id.","placeholder":"Application Id"}' ],
			[ $config->id, 'app_secret', 'App Secret', FormField::TYPE_PASSWORD, false, 'required', 0, NULL, '{"title":"Application Secret.","placeholder":"Application Secret"}' ],
			[ $config->id, 'redirect_uri', 'Redirect URI', FormField::TYPE_TEXT, false, 'required', 0, NULL, '{"title":"Redirect URI.","placeholder":"Redirect URI"}' ]
		];

		$this->batchInsert( $this->prefix . 'core_form_field', $columns, $fields );
	}

	private function insertTwitterConfig() {

		$this->insert( $this->prefix . 'core_form', [
            'siteId' => $this->site->id,
            'createdBy' => $this->master->id, 'modifiedBy' => $this->master->id,
            'name' => 'Config Twitter', 'slug' => 'config-twitter',
            'type' => CoreGlobal::TYPE_SYSTEM,
            'description' => 'Twitter configuration form.',
            'success' => 'All configurations saved successfully.',
            'captcha' => false,
            'visibility' => Form::VISIBILITY_PROTECTED,
            'status' => Form::STATUS_ACTIVE, 'userMail' => false, 'adminMail' => false,
            'createdAt' => DateUtil::getDateTime(),
            'modifiedAt' => DateUtil::getDateTime()
        ]);

		$config	= Form::findBySlugType( 'config-twitter', CoreGlobal::TYPE_SYSTEM );

		$columns = [ 'formId', 'name', 'label', 'type', 'compress', 'validators', 'order', 'icon', 'htmlOptions' ];

		$fields	= [
			[ $config->id, 'active', 'Active', FormField::TYPE_TOGGLE, false, 'required', 0, NULL, '{"title":"Check whether Twitter Login is active."}' ],
			[ $config->id, 'consumer_key', 'Consumer Key', FormField::TYPE_TEXT, false, 'required', 0, NULL, '{"title":"Consumer Key","placeholder":"Consumer Key"}' ],
			[ $config->id, 'consumer_secret', 'Consumer Secret', FormField::TYPE_PASSWORD, false, 'required', 0, NULL, '{"title":"Consumer Secret","placeholder":"Consumer Secret"}' ],
			[ $config->id, 'access_token', 'Access Token', FormField::TYPE_TEXT, false, NULL, 0, NULL, '{"title":"Access Token","placeholder":"Access Token"}' ],
			[ $config->id, 'access_token_secret', 'Access Token Secret', FormField::TYPE_PASSWORD, false, NULL, 0, NULL, '{"title":"Access Token Secret","placeholder":"Access Token Secret"}' ],
			[ $config->id, 'redirect_uri', 'Redirect URI', FormField::TYPE_TEXT, false, 'required', 0, NULL, '{"title":"Redirect URI.","placeholder":"Redirect URI"}' ]
		];

		$this->batchInsert( $this->prefix . 'core_form_field', $columns, $fields );
	}

	private function insertDefaultConfig() {

		$columns = [ 'modelId', 'name', 'label', 'type', 'active', 'valueType', 'value', 'data' ];

		$metas	= [
			[ $this->site->id, 'active', 'Active', 'facebook', 1, 'flag', '1', NULL ],
			[ $this->site->id, 'app_id', 'App Id', 'facebook', 1, 'text', NULL, NULL ],
			[ $this->site->id, 'app_secret', 'App Secret', 'facebook', 1, 'text', NULL, NULL ],
			[ $this->site->id, 'redirect_uri', 'Redirect URI', 'facebook', 1, 'text', '/sns/facebook/authorise', NULL ],

			[ $this->site->id, 'active', 'Active', 'google', 1, 'flag', '1', NULL ],
			[ $this->site->id, 'app_id', 'App Id', 'google', 1, 'text', NULL, NULL ],
			[ $this->site->id, 'app_secret', 'App Secret', 'google', 1, 'text', NULL, NULL ],
			[ $this->site->id, 'redirect_uri', 'Redirect URI', 'google', 1, 'text', '/sns/google/authorise', NULL ],

			[ $this->site->id, 'active', 'Active', 'twitter', 1, 'flag', '1', NULL ],
			[ $this->site->id, 'consumer_key', 'Consumer Key', 'twitter', 1, 'text', NULL, NULL ],
			[ $this->site->id, 'consumer_secret', 'Consumer Secret', 'twitter', 1, 'text', NULL, NULL ],
			[ $this->site->id, 'access_token', 'Access Token', 'twitter', 1, 'text', NULL, NULL ],
			[ $this->site->id, 'access_token_secret', 'Access Token Secret', 'twitter', 1, 'text', NULL, NULL ],
			[ $this->site->id, 'redirect_uri', 'Redirect URI', 'twitter', 1, 'text', '/sns/twitter/authorise', NULL ],
		];

		$this->batchInsert( $this->prefix . 'core_site_meta', $columns, $metas );
	}

    public function down() {

        echo "m160623_072403_sns_connect_data will be deleted with m160621_014408_core.\n";

        return true;
    }

}
