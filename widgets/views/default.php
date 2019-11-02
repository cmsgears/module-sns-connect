<?php
// CMG Imports
use cmsgears\social\connect\common\config\SnsConnectGlobal;

$icons = $widget->icons;
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
						<?php if( $icons ) { ?>
							<a class="btn facebook" href="<?= $facebookService->getLoginUrl() ?>"> <i class="cmti cmti-social-facebook"></i></a>
						<?php } else { ?>
							<a class="btn facebook" href="<?= $facebookService->getLoginUrl() ?>"> <i class="cmti cmti-social-facebook"></i> Facebook</a>
						<?php } ?>
					</div>
<?php
					break;
				}
				case SnsConnectGlobal::CONFIG_SNS_GOOGLE: {

					$googleService = Yii::$app->factory->get( 'googleService' );
?>
					<div class="col col12x3">
						<?php if( $icons ) { ?>
							<a class="btn google" href="<?= $googleService->getLoginUrl() ?>"> <i class="cmti cmti-social-google"></i></a>
						<?php } else { ?>
							<a class="btn google" href="<?= $googleService->getLoginUrl() ?>"> <i class="cmti cmti-social-google"></i> Google</a>
						<?php } ?>
					</div>
<?php
					break;
				}
				case SnsConnectGlobal::CONFIG_SNS_TWITTER: {

					$twitterService = Yii::$app->factory->get( 'twitterService' );
?>
					<div class="col col12x3">
						<?php if( $icons ) { ?>
							<a class="btn twitter" href="<?= $twitterService->getLoginUrl() ?>"> <i class="cmti cmti-social-twitter"></i></a>
						<?php } else { ?>
							<a class="btn twitter" href="<?= $twitterService->getLoginUrl() ?>"> <i class="cmti cmti-social-twitter"></i> Twitter</a>
						<?php } ?>
					</div>
<?php
					break;
				}
				case SnsConnectGlobal::CONFIG_SNS_LINKEDIN: {

					$linkedinService = Yii::$app->factory->get( 'linkedinService' );
?>
					<div class="col col12x3">
						<?php if( $icons ) { ?>
							<a class="btn linkedin" href="<?= $linkedinService->getLoginUrl() ?>"> <i class="cmti cmti-social-linkedin"></i></a>
						<?php } else { ?>
							<a class="btn linkedin" href="<?= $linkedinService->getLoginUrl() ?>"> <i class="cmti cmti-social-linkedin"></i> LinkedIn</a>
						<?php } ?>
					</div>
<?php
					break;
				}
			}
		}
	}
?>
</div>
