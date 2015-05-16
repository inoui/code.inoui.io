<?php
namespace inoui\extensions\data\behavior;

use lithium\util\Inflector;
use lithium\data\Connections;

class Dateable extends \li3_behaviors\data\model\Behavior {

	protected static $_configurations = array();


    protected function _init(array $config = array()) {
        parent::_init();
        
		$defaults = array(
			'updated' => array('field' => 'updated', 'format' => 'Y-m-d H:i:s', 'auto' => true),
			'created' => array('field' => 'created', 'format' => 'Y-m-d H:i:s', 'auto' => true)
		);
		$config += $defaults;
        self::$_configurations = $config;

        if ($model = $this->_model) {
            $behavior = $this;

            $model::applyFilter('save', function($self, $params, $chain) use ($behavior) {
                $params = $behavior->invokeMethod('_formatupdate', array($params, 'updated'));
				$record = $params['entity'];
			    if(!($record->exists())){
                	$params = $behavior->invokeMethod('_formatupdate', array($params, 'created'));
				}
                return $chain->next($self, $params, $chain);
            });
		}
	}

    protected function _formatupdate($params, $type) {
        $config = self::$_configurations[$type];
        $time = time();
        $datetime = date($config['format'], $time);
        $params['data'][$config['field']] = $datetime;
        return $params;
    }

}

?>