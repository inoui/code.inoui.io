<?php
namespace inoui\extensions\data\behavior;
use lithium\util\Inflector;

class Versionable extends \li3_behaviors\data\model\Behavior {

	protected static $_configurations = array();
    /**
     * Default field names to slug
     *
     * @var array
     */
    protected $_defaults = array(
        'maxrevisions' => 10
    );

    protected function _init(array $config = array()) {
        parent::_init();

		$config += $this->_defaults;
        self::$_configurations = $config;

        if ($model = $this->_model) {
            $behavior = $this;
            $model::applyFilter('save', function($self, $params, $chain) use ($behavior) {
		        $version = $params['entity']->to('array');
                $return = $chain->next($self, $params, $chain);
				$behavior->invokeMethod('_versioning', array($params['entity']->_id, $version));
				return $return;
            });
        }
    }

    protected function _versioning($id, $version) {
		unset($version['_versions']);
		unset($version['_id']);		
		$model = $this->_model;
		$model::update(
			array('$addToSet' => array('_versions' => $version)), 
		  	array('_id' => $id), 
		  	array('atomic' => false)
		);

    }
}
?>