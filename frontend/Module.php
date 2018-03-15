<?php
namespace cmsgears\social\connect\frontend;

class Module extends \cmsgears\core\common\base\Module {

    public $controllerNamespace = 'cmsgears\social\connect\frontend\controllers';

    public function init() {

        parent::init();

        $this->setViewPath( '@cmsgears/module-sns-connect/frontend/views' );
    }
}
