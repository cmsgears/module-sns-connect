<?php
namespace cmsgears\social\login\frontend;

// Yii Imports
use \Yii;

class Module extends \cmsgears\core\common\base\Module {

    public $controllerNamespace = 'cmsgears\social\login\frontend\controllers';

    public function init() {

        parent::init();

        $this->setViewPath( '@cmsgears/module-sns-login/frontend/views' );
    }
}

?>