<?php
namespace cmsgears\social\connect\widgets;

// Yii Imports
use yii\helpers\Html;

// CMG Imports
use cmsgears\social\connect\common\config\SnsLoginGlobal;

use cmsgears\core\common\base\Widget;

use cmsgears\social\connect\common\config\FacebookProperties;
use cmsgears\social\connect\common\config\GoogleProperties;
use cmsgears\social\connect\common\config\TwitterProperties;

class SnsLoginWidget extends Widget {

	// Variables ---------------------------------------------------

	// Public Variables --------------------

	// SNS
	public $sns			= [ SnsLoginGlobal::CONFIG_SNS_FACEBOOK, SnsLoginGlobal::CONFIG_SNS_GOOGLE, SnsLoginGlobal::CONFIG_SNS_TWITTER ];

	// Private Variables -------------------

	private $settings	= null;

	// Constructor and Initialisation ------------------------------

	// yii\base\Object

    public function init() {

        parent::init();
    }

	// Instance Methods --------------------------------------------

	// yii\base\Widget

    public function run() {

        return $this->renderWidget();
    }

	// SnsLoginWidget

    public function renderWidget( $config = [] ) {

		foreach ( $this->sns as $sns ) {

			switch( $sns ) {

				case SnsLoginGlobal::CONFIG_SNS_FACEBOOK: {

					$this->settings[ $sns ] = FacebookProperties::getInstance();

					break;
				}
				case SnsLoginGlobal::CONFIG_SNS_GOOGLE: {

					$this->settings[ $sns ] = GoogleProperties::getInstance();

					break;
				}
				case SnsLoginGlobal::CONFIG_SNS_TWITTER: {

					$this->settings[ $sns ] = TwitterProperties::getInstance();

					break;
				}
			}
		}

		$widgetHtml = $this->render( $this->template, [ 'settings' => $this->settings ] );

        return Html::tag( 'div', $widgetHtml, $this->options );
    }
}
