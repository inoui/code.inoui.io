<?php

namespace inoui_cms\models;

use \inoui\models\Media;
use \lithium\g11n\Message;
use \lithium\core\Environment;
use li3_behaviors\data\model\Behaviors;
use \inoui\models\Channels;




class Pages extends \inoui\extensions\models\Inoui {

    // protected $_actsAs = array('Dateable', 'Versionable');
    use Behaviors;
    
    protected $_actsAs = ['Dateable', 'Slugable' => ['fields' => array('name' => 'slug')]];



	public static function thumbnail($entity, $pos=0, $options = array()) {
		if (!isset($entity->_files)) $entity->images();
		if ($pos == 0)  $url = (count($entity->_files)) ? $entity->_files->first()->url($options):'/media/placeholder.jpg';
		else  $url = (count($entity->_files)) ? $entity->_files->next()->url($options):'/media/placeholder.jpg';
		return $url;
	}

	public static function images($entity) {
		if (!isset($entity->_files)) {
			$conditions = array('fk_id'=>(String)$entity->_id);
			$order = 'position';
			$files = Media::find('all', compact('conditions', 'order'));
			$entity->_files = $files;
		}
		return $entity->_files;
	}

	public function type($entity) {
		if ($entity->channel_id) {
			$channel = Channels::first($entity->channel_id);
			return $channel->title;
		}
		return 'default';
	}

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


Pages::applyFilter('save', function($self, $params, $chain){
	$entity = $params['entity'];
	if (!isset($entity->name) || empty($entity->name)) {
		$params['data']['name'] = $entity->title;
	}
    return $chain->next($self, $params, $chain);
});


?>