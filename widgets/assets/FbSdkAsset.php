<?php
/**
 * This file is part of CMSGears Framework. Please view License file distributed
 * with the source code for license details.
 *
 * @link https://www.cmsgears.org/
 * @copyright Copyright (c) 2015 VulpineCode Technologies Pvt. Ltd.
 */

namespace cmsgears\social\connect\widgets\assets;

// Yii Imports
use yii\web\View;

// CMG Imports
use cmsgears\social\connect\common\config\FacebookProperties;

/**
 * FbSdkAsset registers the inline script of Facebook JS SDK.
 *
 * @since 1.0.0
 */
class FbSdkAsset extends \yii\web\AssetBundle {

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

	// Constructor and Initialisation ------------------------------

	// Instance methods --------------------------------------------

	// Yii interfaces ------------------------

	// Yii parent classes --------------------

	public function registerAssetFiles( $view ) {

		parent::registerAssetFiles( $view );

		// FB App Id
		$appId = FacebookProperties::getInstance()->getAppId();

		// FB SDK Script
		$script = "
			window.fbAsyncInit = function() {
			  FB.init({
				appId            : '$appId',
				autoLogAppEvents : true,
				xfbml            : true,
				version          : 'v3.0'
			  });
			};

			(function(d, s, id){
			   var js, fjs = d.getElementsByTagName(s)[0];
			   if (d.getElementById(id)) {return;}
			   js = d.createElement(s); js.id = id;
			   js.src = \"https://connect.facebook.net/en_US/sdk.js\";
			   fjs.parentNode.insertBefore(js, fjs);
			 }(document, 'script', 'facebook-jssdk'));";

		$view->registerJs( $script, View::POS_HEAD );
	}

	// CMG interfaces ------------------------

	// CMG parent classes --------------------

	// FbSdkAsset ----------------------------

}
