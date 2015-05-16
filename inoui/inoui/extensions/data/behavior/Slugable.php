<?php
namespace inoui\extensions\data\behavior;
use lithium\util\Inflector;

class Slugable extends \li3_behaviors\data\model\Behavior {

	protected static $_configurations = array();
    /**
     * Default field names to slug
     *
     * @var array
     */
    protected $_defaults = array(
        'fields' => array('title' => 'slug')
    );

    protected function _init(array $config = array()) {
        parent::_init();

		// $config += $this->_defaults;
        self::$_configurations = $this->_config + $this->_defaults;

        if ($model = $this->_model) {
            $behavior = $this;
            $model::applyFilter('save', function($self, $params, $chain) use ($behavior) {
                $params = $behavior->invokeMethod('_slug', array($params));
                return $chain->next($self, $params, $chain);
            });
        }
    }

    protected function _slug($params) {
        extract(self::$_configurations);
        
        foreach ($fields as $from => $to) {
            if (isset($params['data'][$from])) {

				$slug_base = strtolower(Inflector::slug($params['data'][$from]));
				$model = $this->_model;
				if (!$params['entity']->exists() || $params['entity']->slug != $slug_base) {
					$conditions = array();
					if (isset($params['entity']->_id)) {
						$conditions['_id'] = array('$nin' => array($params['entity']->_id));
					}
					$i = 1;
					$exits = true;
					while($exits && $i < 10) {
						if ($i == 1) $slug = "{$slug_base}";
						else  $slug = "{$slug_base}-{$i}";
						$conditions[$to] = $slug;
						$exits = count($model::find('first', compact('conditions')));
						$i++;
					}
	                $params['data'][$to] = $slug;
				}
            }
        }
        return $params;
    }
}
?>