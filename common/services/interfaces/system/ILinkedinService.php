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
 * ILinkedinService declares methods specific to LinkedIn Login.
 *
 * @since 1.0.0
 */
interface ILinkedinService extends ISystemService {

	public function getLoginUrl();

	public function getAccessToken( $code, $state );

	public function getUser( $accessToken );

}
