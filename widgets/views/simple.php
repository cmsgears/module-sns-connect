<?php
// CMG Imports
use cmsgears\social\login\common\config\SnsLoginGlobal;
?>

<div class="menu-social max-cols-50 clearfix">
<?php
	foreach ( $settings as $key => $setting ) {
		
		if( $setting->isActive() ) {

			switch( $key ) {
		
				case SnsLoginGlobal::CONFIG_SNS_FACEBOOK: {
	
?>
	<div class="col12x4"> 
		<a class="btn facebook" href="<?= $setting->getLoginUrl() ?>"> <i class="cmti cmti-social-facebook"> </i> <em>FACEBOOK</em></a>
	</div>
<?php
					break;
				}
				case SnsLoginGlobal::CONFIG_SNS_GPLUS: {

?>
	<div class="col12x4">
		<a class="btn google" href="<?= $setting->getLoginUrl() ?>"> <i class="cmti cmti-social-google"> </i> <em>GOOGLE</em></a>
	</div>
<?php	
					break;
				}
				case SnsLoginGlobal::CONFIG_SNS_TWITTER: {

?>
	<div class="col12x4">
		<a class="btn twitter" href="<?= $setting->getLoginUrl() ?>"> <i class="cmti cmti-social-twitter"> </i> <em>TWITTER</em></a>
	</div>
<?php	
					break;
				}
			}
		}
	}
?>
</div>