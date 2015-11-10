<?php
namespace cmsgears\social\login\common\components;

// Yii Imports
use \Yii;

/**
 * The mail component used for sending possible mails by the CMSGears sns login module. It must be initialised 
 * for app using the name cmgSnsLoginMailer. It's used by various controllers to trigger mails.  
 */
class Mailer extends \cmsgears\core\common\base\Mailer {

	const MAIL_REG_FACEBOOK		= 'register-facebook';
	const MAIL_REG_GPLUS		= 'register-gplus';
	const MAIL_REG_TWITTER		= 'register-twitter';

    public $htmlLayout 			= '@cmsgears/module-sns-login/common/mails/layouts/html';
    public $textLayout 			= '@cmsgears/module-sns-login/common/mails/layouts/text';
    public $viewPath 			= '@cmsgears/module-sns-login/common/mails/views';

	public function sendRegisterFacebookMail( $user ) {

		$fromEmail 	= $this->mailProperties->getSenderEmail();
		$fromName 	= $this->mailProperties->getSenderName();

		// Send Mail
        $this->getMailer()->compose( self::MAIL_REG_FACEBOOK, [ 'coreProperties' => $this->coreProperties, 'user' => $user ] )
            ->setTo( $user->email )
            ->setFrom( [ $fromEmail => $fromName ] )
            ->setSubject( "Registration | " . $this->coreProperties->getSiteName() )
            //->setTextBody( $contact->contact_message )
            ->send();
	}

	public function sendRegisterGPlusMail( $user ) {

		$fromEmail 	= $this->mailProperties->getSenderEmail();
		$fromName 	= $this->mailProperties->getSenderName();

		// Send Mail
        $this->getMailer()->compose( self::MAIL_REG_GPLUS, [ 'coreProperties' => $this->coreProperties, 'user' => $user ] )
            ->setTo( $user->email )
            ->setFrom( [ $fromEmail => $fromName ] )
            ->setSubject( "Registration | " . $this->coreProperties->getSiteName() )
            //->setTextBody( $contact->contact_message )
            ->send();
	}

	public function sendRegisterTwitterMail( $user ) {

		$fromEmail 	= $this->mailProperties->getSenderEmail();
		$fromName 	= $this->mailProperties->getSenderName();

		// Send Mail
        $this->getMailer()->compose( self::MAIL_REG_TWITTER, [ 'coreProperties' => $this->coreProperties, 'user' => $user ] )
            ->setTo( $user->email )
            ->setFrom( [ $fromEmail => $fromName ] )
            ->setSubject( "Registration | " . $this->coreProperties->getSiteName() )
            //->setTextBody( $contact->contact_message )
            ->send();
	}
}

?>