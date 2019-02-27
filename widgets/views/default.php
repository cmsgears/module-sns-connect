<?php
// CMG Imports
use cmsgears\social\connect\common\config\SnsConnectGlobal;
?>

<div class="menu-social row max-cols-50">
<?php
	foreach( $settings as $key => $setting ) {

		if( $setting->isActive() ) {

			switch( $key ) {

				case SnsConnectGlobal::CONFIG_SNS_FACEBOOK: {

					$facebookService = Yii::$app->factory->get( 'facebookService' );
?>
					<div class="col col12x3">
						<a class="btn facebook" href="<?= $facebookService->getLoginUrl() ?>"> <i class="cmti cmti-social-facebook"> </i> Facebook</a>
					</div>
<?php
					break;
				}
				case SnsConnectGlobal::CONFIG_SNS_GOOGLE: {

					$googleService = Yii::$app->factory->get( 'googleService' );
?>
					<div class="col col12x3">
						<a class="btn google" href="<?= $googleService->getLoginUrl() ?>"> <i class="cmti cmti-social-google"> </i> Google</a>
					</div>
<?php
					break;
				}
				case SnsConnectGlobal::CONFIG_SNS_TWITTER: {

					$twitterService = Yii::$app->factory->get( 'twitterService' );
?>
					<div class="col col12x3">
						<a class="btn twitter" href="<?= $twitterService->getLoginUrl() ?>"> <i class="cmti cmti-social-twitter"> </i> Twitter</a>
					</div>
<?php
					break;
				}
				case SnsConnectGlobal::CONFIG_SNS_LINKEDIN: {

					$linkedinService = Yii::$app->factory->get( 'linkedinService' );
?>
					<div class="col col12x3">
						<a class="btn linkedin" href="<?= $linkedinService->getLoginUrl() ?>"> <i class="cmti cmti-social-linkedin"> </i> LinkedIn</a>
					</div>
<?php
					break;
				}
			}
		}
	}
?>
</div>
