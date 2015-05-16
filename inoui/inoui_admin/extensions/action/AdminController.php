<?php

namespace inoui_admin\extensions\action;
use \lithium\security\Auth;
use lithium\core\Libraries;

class AdminController extends \lithium\action\Controller{

    protected $_breadcrumbs = array();

	protected function _init(){
		parent::_init();
		$path = Libraries::get('inoui_admin', 'path'); 
		$this->_render['paths'] = array(
	        'layout' => array(
				"{$path}/views/layouts/{:layout}.{:type}.php"
			),
	        'template' => array(
				'{:library}/views_admin/{:controller}/{:template}.{:type}.php',
			),
	        'element'  => array(
	            '{:library}/views_admin/{:controller}/element_{:template}.{:type}.php',
	            '{:library}/views/{:controller}/{:template}.{:type}.php',
	            '{:library}/views/{:controller}/{:template}.{:type}.php',
	            '{:library}/views/elements/{:template}.{:type}.php',
				"{$path}/views/{:controller}/{:template}.{:type}.php",
				"{$path}/views/elements/{:template}.{:type}.php"
	        )
	    );
        $this->_bind('breadcrumbs', $this->_breadcrumbs);
		
		if ($this->request->is('ajax')) {
			$this->_render['layout'] = 'blank';
		}

        $this->_breadcrumbs['Dashboard'] = array('Dashboard::index', 'library'=>'inoui_admin');
	}
    
    protected function _bind($name, &$value) {
        $this->_render['data'][$name] = &$value;
    }

}

?>