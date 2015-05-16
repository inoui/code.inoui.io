<?php

namespace inoui_admin\models;
use \lithium\core\Environment;
use li3_behaviors\data\model\Behaviors;


class Categories extends \lithium\data\Model {

    use Behaviors;

    protected $_actsAs = ['Tree', 'Dateable', 'Slugable'];


    public static $_categories = array();
    public static $_root;

    
    protected $_schema = array(
        '_id'  => array('type' => 'id'), // required for Mongo
        'title' => array('type' => 'string'),
        'parent_id' => array('type' => 'MongoId') 
    );


    public static function _initCategory() {
        if (empty(self::$_categories)) {
            self::$_categories = self::find('all');
            self::$_root = self::first(array('conditions'=>array('path'=>null)));
        }        
    }


    public static function getSelect() {
        $categories = $rootCat->nestedChildrens(true);
        return self::$categories;
    }

    public static function getNested() {
        $rootCat = self::first(array('conditions'=>array('parent_id'=>null)));
        $categories = $rootCat->nestedChildrens(true);
        return $categories;
    }



    public static function get($id) {
        self::_initCategory();
        return isset(self::$_categories[$id])?self::$_categories[$id]:'';
    }


}

?>