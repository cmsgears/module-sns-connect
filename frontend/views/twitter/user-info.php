<?php
use yii\widgets\ActiveForm;

$coreProperties = $this->context->getCoreProperties();
$this->title 	= $coreProperties->getSiteTitle() . ' | User Info';
?>
<h1>User Info</h1>

<p>We need further info before you continue with your twitter account:</p>

<?php
	if( $coreProperties->isRegistration() ) {

		$form = ActiveForm::begin( [ 'id' => 'frm-twitter', 'options' => [ 'class' => 'form' ] ] ); ?>
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