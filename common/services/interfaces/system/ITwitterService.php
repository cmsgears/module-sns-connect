<?php
/**
 * This file is part of CMSGears Framework. Please view License file distributed
 * with the source code for license details.
 *
 * @link https://www.cmsgears.org/
 * @copyright Copyright (c) 2015 VulpineCode Technologies Pvt. Ltd.
 */

namespace cmsgears\social\connect\common\services\interfaces\system;

// CMG Imports
use cmsgears\core\common\services\interfaces\base\ISystemService;

/**
 * ITwitterService declares methods specific to twitter login.
 *
 * @since 1.0.0
 */
interface ITwitterService extends ISystemService {

	public function generateBaseString( $tokenUrl, $headerParams, $post = true );

	public function generateCompositeKey( $apiSecret, $requestToken );

	public function generateAuthHeader( $headerParams );

	public function getLoginUrl();

	public function requestToken();

	public function setAuthToken( $oauth_token, $oauth_verifier );

	public function getAccessToken();

	public function getUser();

}
