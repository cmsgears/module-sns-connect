<?php
namespace cmsgears\social\login\widgets;

// Yii Imports
use \Yii;
use yii\helpers\Html;

// CMG Imports
use cmsgears\core\common\config\CmgProperties;

use cmsgears\social\login\common\config\SnsLoginGlobal;
use cmsgears\social\login\common\config\FacebookProperties;
use cmsgears\social\login\common\config\GPlusProperties;
use cmsgears\social\login\common\config\TwitterProperties;

class SnsLoginWidget extends \cmsgears\core\common\base\Widget {

	// Variables ---------------------------------------------------

	// Public Variables --------------------

	// SNS
	public $sns			= [ SnsLoginGlobal::CONFIG_SNS_FACEBOOK, SnsLoginGlobal::CONFIG_SNS_GPLUS, SnsLoginGlobal::CONFIG_SNS_TWITTER ];

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

        return $this->renderButtons();
    }

	// SnsLoginWidget

    public function renderButtons() {

		foreach ( $this->sns as $sns ) {

			switch( $sns ) {

				case SnsLoginGlobal::CONFIG_SNS_FACEBOOK: {

					$this->settings[ $sns ] = FacebookProperties::getInstance();

					break;
				}
				case SnsLoginGlobal::CONFIG_SNS_GPLUS: {

					$this->settings[ $sns ] = GPlusProperties::getInstance();

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

?>