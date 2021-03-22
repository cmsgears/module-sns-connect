<?php
/**
 * This file is part of CMSGears Framework. Please view License file distributed
 * with the source code for license details.
 *
 * @link https://www.cmsgears.org/
 * @copyright Copyright (c) 2015 VulpineCode Technologies Pvt. Ltd.
 */

namespace cmsgears\social\connect\widgets;

// Yii Imports
use yii\helpers\Html;

// CMG Imports
use cmsgears\social\connect\common\config\SnsConnectGlobal;

use cmsgears\social\connect\common\config\FacebookProperties;
use cmsgears\social\connect\common\config\GoogleProperties;
use cmsgears\social\connect\common\config\TwitterProperties;
use cmsgears\social\connect\common\config\LinkedinProperties;

class SnsLoginWidget extends \cmsgears\core\common\base\Widget {

	// Variables ---------------------------------------------------

	// Globals -------------------------------

	// Constants --------------

	// Public -----------------

	// Protected --------------

	// Variables -----------------------------

	// Public -----------------

	public $sns = [
		SnsConnectGlobal::CONFIG_SNS_FACEBOOK,
		SnsConnectGlobal::CONFIG_SNS_GOOGLE,
		SnsConnectGlobal::CONFIG_SNS_TWITTER,
		SnsConnectGlobal::CONFIG_SNS_LINKEDIN
	];

	public $icons	= true;
	public $text	= true;

	// Protected --------------

	// Private ----------------

	private $settings = null;

	// Traits ------------------------------------------------------

	// Constructor and Initialisation ------------------------------

	// Instance methods --------------------------------------------

	// Yii interfaces ------------------------

	// Yii parent classes --------------------

	// CMG interfaces ------------------------

	// CMG parent classes --------------------

	// cmsgears\core\common\base\Widget

	/**
	 * @inheritdoc
	 */
    public function renderWidget( $config = [] ) {

		foreach( $this->sns as $sns ) {

			switch( $sns ) {

				case SnsConnectGlobal::CONFIG_SNS_FACEBOOK: {

					$this->settings[ $sns ] = FacebookProperties::getInstance();

					break;
				}
				case SnsConnectGlobal::CONFIG_SNS_GOOGLE: {

					$this->settings[ $sns ] = GoogleProperties::getInstance();

					break;
				}
				case SnsConnectGlobal::CONFIG_SNS_TWITTER: {

					$this->settings[ $sns ] = TwitterProperties::getInstance();

					break;
				}
				case SnsConnectGlobal::CONFIG_SNS_LINKEDIN: {

					$this->settings[ $sns ] = LinkedinProperties::getInstance();

					break;
				}
			}
		}

		$widgetHtml = $this->render( $this->template, [ 'widget' => $this, 'settings' => $this->settings ] );

        return Html::tag( 'div', $widgetHtml, $this->options );
    }

	// SnsLoginWidget ------------------------

}
