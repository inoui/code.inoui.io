<?php

namespace inoui_cms\models;

use \inoui\models\Media;
use \lithium\g11n\Message;
use \lithium\core\Environment;

class Posts extends \inoui\extensions\models\Inoui {

    // protected $_actsAs = array('Dateable', 'Versionable');
	protected $_actsAs = array('Dateable', 'Slugable');

	// public function &__get($name) {
	// 	if (isset($this->_relationships[$name])) {
	// 		return $this->_relationships[$name];
	// 	}
	// 	if (isset($this->_updated[$name])) {
	// 		return $this->_updated[$name];
	// 	}
	// 	$null = null;
	// 	return $null;
	// }



	public function category($entity) {
		return $entity->category;
	}
		
		
		
	public function title($entity) {
		if (count(Environment::get('locales'))>1) {
			$locale = Environment::get('locale');
			return $entity->title->$locale;
		}
		return $entity->title;		
	}

	// public function __call($name, $params) {
	// 	$methods = static::instanceMethods();
	// 	try {
	// 		return parent::__call($name, $params);
	// 	} catch (\BadMethodCallException $e) {
	// 
	// 		$entity = $params[0];
	// 		$field = $entity->$name;
	// 		if (isset($params[1]) && in_array($params[1], Environment::get('locales')) ) {
	// 			$locale = $params[1];
	// 		} else {
	//  				$locale = Environment::get('locale');
	// 		}
	// 		if ( is_object($field) && isset($field->$locale)) {
	// 			return $field->$locale;
	// 		}
	// 	}		
	// }

}


?>