<?php

namespace inoui_admin\models;
use \lithium\g11n\Message;

class Navigation extends \lithium\core\StaticObject {
    
    
    static $plugs_menu = array();
    
    /**
     * Default static menus.
     *
     * @var array
    */    
    static $static_menus = array(

		'store' => array(


	        'dashboard' => array(
	            'title' => 'Dashboard',
	            'url' => array('Dashboard::index', 'library'=>'inoui_admin', 'admin'=>true),
	            'options' => array('icon'=>'home')
	        ),

	        'orders' => array(
	            'title' => 'Orders',
	            'url' => array('Orders::index', 'library'=>'inoui_admin', 'admin'=>true),
	            'options' => array('icon'=>'archive')
	        ),

	        // 'customers' => array(
	        //     'title' => 'Customers',
	        //     'url' => array('Cutomers::index', 'library'=>'inoui_admin', 'admin'=>true),
	        //     'options' => array('icon'=>'group')
	        // ),

	        'products' => array(
	            'title' => 'Products',
	            'url' => array('Products::index', 'library'=>'inoui_admin', 'admin'=>true),
	            'options' => array('icon'=>'tags')
	        ),

	        'categories' => array(
	            'title' => 'Categories',
	            'url' => array('Categories::index', 'library'=>'inoui_admin', 'admin'=>true),
	            'options' => array('icon'=>'folder-close')
	        ),

	        'shippings' => array(
	            'title' => 'Shippings',
	            'url' => array('Shippings::index', 'library'=>'inoui_admin', 'admin'=>true),
	            'options' => array('icon'=>'truck')
	        ),
		), 
		'website' => array(
			
			'channels' => array(
	            'title' => 'Channels',
	            'url' => array('Channels::index', 'library'=>'inoui_admin', 'admin'=>true),
	            'options' => array('icon'=>'link')
	        ),
	        
	        'blog' => array(
	            'title' => 'Blog post',
	            'url' => array('Posts::index', 'library'=>'inoui_admin', 'admin'=>true),
	            'options' => array('icon'=>'list-ul')
	        ),

	        
	        'media' => array(
	            'title' => 'Media',
	            'url' => array('Media::index', 'library'=>'inoui_admin', 'admin'=>true),
	            'options' => array('icon'=>'picture')
	        ),

		)
		
        // 'channels' => array(
        //     'title' => 'Channels',
        //     'url' => array('Channels::index', 'library'=>'inoui_admin', 'admin'=>true),
        //     'options' => array('icon'=>'folder-close')
        // ),

    );
    public static function addMenu($menu){
        $arrMenu = $menu::$static_menus;
        self::$plugs_menu += $arrMenu;
    }

    public static function staticMenu($menu){
        return array_merge(self::$static_menus[$menu], self::$plugs_menu);
    }

    /**
     * Returns a static menu.
     * Static menus are defined as arrays.
     * There is a default admin menu and a default public site menu.
     *
     * This method is filterable so the menus can be added, added to or changed.
     *
     * @param string $name The name of the static menu to return (empty value returns all menus)
     * @param array $options
     * @return array The static menu(s)
    */
    public static function find($menu, $options=array()) {
        $defaults = array();
        $options += $defaults;
        $params = compact('name', 'options');
        return self::staticMenu($menu);
    }

}
?>