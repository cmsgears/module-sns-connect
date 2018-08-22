<?php
/**
 * This file is part of CMSGears Framework. Please view License file distributed
 * with the source code for license details.
 *
 * @link https://www.cmsgears.org/
 * @copyright Copyright (c) 2015 VulpineCode Technologies Pvt. Ltd.
 */

namespace cmsgears\social\connect\common\components;

// CMG Imports
use cmsgears\core\common\base\Mailer as BaseMailer;

/**
 * The mail component used for sending possible mails by the CMSGears sns login module.
 *
 * @since 1.0.0
 */
class Mailer extends BaseMailer {

	// Variables ---------------------------------------------------

	// Globals -------------------------------

	// Constants --------------

	const MAIL_REG_FACEBOOK		= 'register/facebook';
	const MAIL_REG_GOOGLE		= 'register/google';
	const MAIL_REG_TWITTER		= 'register/twitter';
	const MAIL_REG_LINKEDIN		= 'register/linkedin';

	// Public -----------------

	// Protected --------------

	// Variables -----------------------------

	// Public -----------------

    public $htmlLayout 	= '@cmsgears/module-sns-connect/common/mails/layouts/html';
    public $textLayout 	= '@cmsgears/module-sns-connect/common/mails/layouts/text';
    public $viewPath 	= '@cmsgears/module-sns-connect/common/mails/views';

	// Protected --------------

	// Private ----------------

	// Traits ------------------------------------------------------

	// Constructor and Initialisation ------------------------------

	// Instance methods --------------------------------------------

	// Yii interfaces ------------------------

	// Yii parent classes --------------------

	// CMG interfaces ------------------------

	// CMG parent classes --------------------

	// Mailer --------------------------------

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

	public function sendRegisterGoogleMail( $user ) {

		$fromEmail 	= $this->mailProperties->getSenderEmail();
		$fromName 	= $this->mailProperties->getSenderName();

		// Send Mail
        $this->getMailer()->compose( self::MAIL_REG_GOOGLE, [ 'coreProperties' => $this->coreProperties, 'user' => $user ] )
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

	public function sendRegisterLinkedinMail( $user ) {

		$fromEmail 	= $this->mailProperties->getSenderEmail();
		$fromName 	= $this->mailProperties->getSenderName();

		// Send Mail
        $this->getMailer()->compose( self::MAIL_REG_LINKEDIN, [ 'coreProperties' => $this->coreProperties, 'user' => $user ] )
            ->setTo( $user->email )
            ->setFrom( [ $fromEmail => $fromName ] )
            ->setSubject( "Registration | " . $this->coreProperties->getSiteName() )
            //->setTextBody( $contact->contact_message )
            ->send();
	}

}
