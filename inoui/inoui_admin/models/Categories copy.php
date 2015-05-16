<?php

namespace inoui_admin\models;
use \lithium\core\Environment;

class Categories extends \inoui\extensions\models\Inoui {


	public static $_categories = array();
    public static $_root;

    protected $_meta = array(
        'key'   => '_id',
        'title' => 'title'
    );

    protected $_actsAs = array('Dateable', 'Slugable', 'Tree');

    public static function _initCategory() {
        if (empty(self::$_categories)) {
            self::$_categories = self::find('all');
            self::$_root = self::first(array('conditions'=>array('path'=>null)));
        }        
    }


	public static function getSelect() {
		return self::$_categories;
	}

	// public function title($entity) {
	// 	$env = Environment::get('locale');
	// 	return $entity->name->$env;		
	// }

    public static function get($id) {
        self::_initCategory();
    	return isset(self::$_categories[$id])?self::$_categories[$id]:'';
    }

    public static function getChildren(array $options = array()) {
        self::_initCategory();
        $rootId = self::$_root->_id;
        $defaults = array('path' => $rootId, 'recursive' => true);
        $options += $defaults;

        $pathId = (string)$options['path'];
        $regex = new \MongoRegex("/^".$pathId."/i");
        $conditions = array('path' => $regex);
        $order = array('path' => 'asc');
        $children = self::find('all', compact('conditions', 'order'));
        return $children;

    }

    public static function getChildrenTree(array $options = array()) {
        $children = self::getChildren($options)->to('array');
        $childrenTree = [];
        foreach ($children as $key => $child) {
            $level = self::getLevel($child['path']);
            $childrenTree = self::setChildren($childrenTree, $child, $level);
        }
        print_r($childrenTree);
        return $childrenTree;
    }

    public static function setChildren($tree, $entity, $level) {

        if ($level == 1) {
            $entity['children'] = array();
            $tree[] = $entity;
            // echo $entity['title'];
        } else {
            $k = $tree[count($tree)-1];
            echo $k['title']; 
            $tree[count($tree)-1]['children'] = self::setChildren($tree[count($tree)-1]['children'], $entity, $level-1);
        }

        return $tree;
    }

    public static function getLevel($path = null) {
        $aLevel = explode('#', $path);
        return count($aLevel);
    }

    public static function getAncestors(array $options = array()) {

    }

}

?>