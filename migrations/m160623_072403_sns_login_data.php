<?php
// CMG Imports
use cmsgears\core\common\config\CoreGlobal;

use cmsgears\core\common\models\entities\Site;
use cmsgears\core\common\models\entities\User;
use cmsgears\core\common\models\resources\Form;
use cmsgears\core\common\models\resources\FormField;

use cmsgears\core\common\utilities\DateUtil;

class m160623_072403_sns_login_data extends \yii\db\Migration {

	public $prefix;

	private $site;

	private $master;

	public function init() {

		$this->prefix		= 'cmg_';

		$this->site		= Site::findBySlug( CoreGlobal::SITE_MAIN );
		$this->master	= User::findByUsername( 'demomaster' );

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
            'successMessage' => 'All configurations saved successfully.',
            'captcha' => false,
            'visibility' => Form::VISIBILITY_PROTECTED,
            'active' => true, 'userMail' => false, 'adminMail' => false,
            'createdAt' => DateUtil::getDateTime(),
            'modifiedAt' => DateUtil::getDateTime()
        ]);

		$config	= Form::findBySlug( 'config-facebook', CoreGlobal::TYPE_SYSTEM );

		$columns = [ 'formId', 'name', 'label', 'type', 'compress', 'validators', 'order', 'icon', 'htmlOptions' ];

		$fields	= [
			[ $config->id, 'active', 'Active', FormField::TYPE_TOGGLE, false, 'required', 0, NULL, '{\"title\":\"Check whether Facebook Login is active.\"}' ],
			[ $config->id, 'app_id', 'App Id', FormField::TYPE_TEXT, false, 'required', 0, NULL, '{\"title\":\"Application Id.\",\"placeholder\":\"Application Id\"}' ],
			[ $config->id, 'app_secret', 'App Secret', FormField::TYPE_PASSWORD, false, 'required', 0, NULL, '{\"title\":\"Application Secret.\",\"placeholder\":\"Application Secret\"}' ],
			[ $config->id, 'app_uri', 'App URI', FormField::TYPE_TEXT, false, 'required', 0, NULL, '{\"title\":\"Redirect URI.\",\"placeholder\":\"Redirect URI\"}' ]
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
            'successMessage' => 'All configurations saved successfully.',
            'captcha' => false,
            'visibility' => Form::VISIBILITY_PROTECTED,
            'active' => true, 'userMail' => false, 'adminMail' => false,
            'createdAt' => DateUtil::getDateTime(),
            'modifiedAt' => DateUtil::getDateTime()
        ]);

		$config	= Form::findBySlug( 'config-google', CoreGlobal::TYPE_SYSTEM );

		$columns = [ 'formId', 'name', 'label', 'type', 'compress', 'validators', 'order', 'icon', 'htmlOptions' ];

		$fields	= [
			[ $config->id, 'active', 'Active', FormField::TYPE_TOGGLE, false, 'required', 0, NULL, '{\"title\":\"Check whether Google Login is active.\"}' ],
			[ $config->id, 'app_id', 'App Id', FormField::TYPE_TEXT, false, 'required', 0, NULL, '{\"title\":\"Application Id.\",\"placeholder\":\"Application Id\"}' ],
			[ $config->id, 'app_secret', 'App Secret', FormField::TYPE_PASSWORD, false, 'required', 0, NULL, '{\"title\":\"Application Secret.\",\"placeholder\":\"Application Secret\"}' ],
			[ $config->id, 'redirect_uri', 'Redirect URI', FormField::TYPE_TEXT, false, 'required', 0, NULL, '{\"title\":\"Redirect URI.\",\"placeholder\":\"Redirect URI\"}' ]
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
            'successMessage' => 'All configurations saved successfully.',
            'captcha' => false,
            'visibility' => Form::VISIBILITY_PROTECTED,
            'active' => true, 'userMail' => false, 'adminMail' => false,
            'createdAt' => DateUtil::getDateTime(),
            'modifiedAt' => DateUtil::getDateTime()
        ]);

		$config	= Form::findBySlug( 'config-twitter', CoreGlobal::TYPE_SYSTEM );

		$columns = [ 'formId', 'name', 'label', 'type', 'compress', 'validators', 'order', 'icon', 'htmlOptions' ];

		$fields	= [
			[ $config->id, 'active', 'Active', FormField::TYPE_TOGGLE, false, 'required', 0, NULL, '{\"title\":\"Check whether Twitter Login is active.\"}' ],
			[ $config->id, 'api_key', 'API Id', FormField::TYPE_TEXT, false, 'required', 0, NULL, '{\"title\":\"Application Id.\",\"placeholder\":\"Application Id\"}' ],
			[ $config->id, 'api_secret', 'API Secret', FormField::TYPE_PASSWORD, false, 'required', 0, NULL, '{\"title\":\"Application Secret.\",\"placeholder\":\"Application Secret\"}' ],
			[ $config->id, 'redirect_uri', 'Redirect URI', FormField::TYPE_TEXT, false, 'required', 0, NULL, '{\"title\":\"Redirect URI.\",\"placeholder\":\"Redirect URI\"}' ]
		];

		$this->batchInsert( $this->prefix . 'core_form_field', $columns, $fields );
	}

	private function insertDefaultConfig() {

		$columns = [ 'modelId', 'name', 'label', 'type', 'valueType', 'value' ];

		$attributes	= [
			[ $this->site->id, 'active', 'Active', 'facebook', 'flag', '1' ],
			[ $this->site->id, 'app_id', 'App Id', 'facebook', 'text', null ],
			[ $this->site->id, 'app_secret', 'App Secret', 'facebook', 'text', null ],
			[ $this->site->id, 'redirect_uri', 'Redirect URI', 'facebook', 'text', '/sns/facebook/authorise' ],

			[ $this->site->id, 'active', 'Active', 'google', 'flag', '1' ],
			[ $this->site->id, 'app_id', 'App Id', 'google', 'text', null ],
			[ $this->site->id, 'app_secret', 'App Secret', 'google', 'text', null ],
			[ $this->site->id, 'redirect_uri', 'Redirect URI', 'google', 'text', '/sns/google/authorise' ],

			[ $this->site->id, 'active', 'Active', 'twitter', 'flag', '1' ],
			[ $this->site->id, 'api_key', 'API Key', 'twitter', 'text', null ],
			[ $this->site->id, 'api_secret', 'API Secret', 'twitter', 'text', null ],
			[ $this->site->id, 'redirect_uri', 'Redirect URI', 'twitter', 'text', '/sns/twitter/authorise' ],
		];

		$this->batchInsert( $this->prefix . 'core_site_attribute', $columns, $attributes );
	}

    public function down() {

        echo "m160623_072403_sns_login_data will be deleted with m160621_014408_core.\n";

        return true;
    }
}

?>