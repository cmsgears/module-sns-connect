<?php
use \Yii;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

$coreProperties = $this->context->getCoreProperties();
$this->title 	= $coreProperties->getSiteTitle() . ' | User Info';
?>
<h1>User Info</h1>

<p>We need further info before you continue with your twitter account:</p>

<?php
	if( $coreProperties->isPublicRegister() ) {

		$form = ActiveForm::begin( [ 'id' => 'frm-twitter' ] );
?>
	<ul>
		<li>
			<?= $form->field( $model, 'email' )->textInput( [ 'placeholder' => 'Email*' ] ) ?>
		</li>
		<li class="clearfix align-center">
			<input type="submit" value="Submit" />
		</li>
	</ul>
<?php
		ActiveForm::end();
	}
	else {
?>
	<p class="warning">Site login is disabled by Admin.</p>
<?php } ?>