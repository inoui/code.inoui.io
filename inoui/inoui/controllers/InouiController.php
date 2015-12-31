<?php

namespace inoui\controllers;
use \lithium\analysis\Logger;
use inoui\models\Preferences;

class InouiController extends \inoui\extensions\action\InouiController{

    public $publicActions = array('install');

	protected function _init(){
		parent::_init();
		$this->_bind('preferences', Preferences::get());
	}

	public function log($message) {
	    Logger::debug($message);
	}

    public function install() {

	}


    protected function _bind($name, &$value) {
        $this->_render['data'][$name] = &$value;
    }



}
?>
