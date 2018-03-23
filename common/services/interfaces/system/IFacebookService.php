<?php
namespace cmsgears\social\connect\common\services\interfaces\system;

// CMG Imports
use cmsgears\core\common\services\interfaces\base\ISystemService;

interface IFacebookService extends ISystemService {

	public function getLoginUrl();

	public function getAccessToken( $code, $state );

	public function getUser( $accessToken );

}
