<?php

namespace inoui\extensions\action;

use \inoui\models\Preferences;
use \lithium\security\Auth;

class InouiController extends \lithium\action\Controller{

    protected $_breadcrumbs = array();
    protected $_user;
    protected $_isAdmin;

	protected function _init(){
        $this->_render['negotiate'] = true;
		parent::_init();
        $prefs = Preferences::get();
        $jsInit = null;
        $this->_bind('jsInit', $jsInit);

        $cl = str_replace('/', ' ',$this->request->url);
        $this->_bind('pageClass', $cl);


		$this->_bind('preferences', $prefs);
        $this->_bind('breadcrumbs', $this->_breadcrumbs);

        $this->_user = Auth::check('user');
        $this->_isAdmin = false;
        if (!empty($this->_user) && $this->_user['role'] == 'admin') $this->_isAdmin = true;
        // if (empty($this->_user)) die('prout');
	}
    
    protected function _bind($name, &$value) {
        $this->_render['data'][$name] = &$value;
    }

}

?>