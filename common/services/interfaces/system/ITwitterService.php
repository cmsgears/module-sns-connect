<?php
namespace cmsgears\social\connect\common\services\interfaces\system;

// CMG Imports
use cmsgears\core\common\services\interfaces\base\ISystemService;

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
