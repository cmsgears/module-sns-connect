<?php
// CMG Imports
use cmsgears\social\login\common\config\SnsLoginGlobal;
?>

<div class="row menu-social clearfix">
<?php
	foreach ( $settings as $key => $setting ) {
		
		if( $setting->isActive() ) {

			switch( $key ) {
		
				case SnsLoginGlobal::CONFIG_SNS_FACEBOOK: {
	
?>
	<div class="col12x4"> <a class="btn facebook" href="<?= $setting->getLoginUrl() ?>"> <i class="cmti cmti-social-facebook"> </i> <em class="margin-left-5">FACEBOOK</em> </a></div>
<?php
					break;
				}
				case SnsLoginGlobal::CONFIG_SNS_GPLUS: {

?>
	<div class="col12x4"> <a class="btn google" href="<?= $setting->getLoginUrl() ?>"> <i class="cmti cmti-social-google"> </i> <em class="margin-left-5">GOOGLE</em> </a></div>
<?php	
					break;
				}
				case SnsLoginGlobal::CONFIG_SNS_TWITTER: {

?>
	<div class="col12x4"> <a class="btn twitter" href="<?= $setting->getLoginUrl() ?>"> <i class="cmti cmti-social-twitter"> </i> <em class="margin-left-5">TWITTER </em></a></div>
<?php	
					break;
				}
			}
		}
	}
?>
</div>