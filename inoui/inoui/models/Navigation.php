<?php

namespace inoui\models;
use \lithium\g11n\Message;
use inoui\core\util\Set;

class Navigation extends \lithium\core\StaticObject {
	
	protected static $_data = array();

	/**
	 * Add items to navigation
	 * 
	 * @param string $path Dot separated path in the array. See \lithium\util\Set::insert().
	 * @param array $options Information to be inserted in the given path.
	 * @return void
	 */
	public static function add($path, $data = array()) {
		if (!strstr($path, '.')) {
			static::$_data[$path] = $options;
		} else {
			if ($_data = Set::find(static::$_data, $path)) {
				$data = Set::append($_data, $data);
			} 
			static::$_data = Set::insert(static::$_data, $path, $data);
		}
	}
	
	/**
	 * Removes given path from navigation.
	 * 
	 * @param string $path Dot separated path in the array. See \lithium\util\Set::insert().
	 * @return void
	 */ 
	public static function remove($path) {
		static::$_data = Set::remove(static::$_data, $path);
	}
	
	/**
	 * Returns navigation information
	 * 
	 * @return array
	 */
	public static function getData($path = null) {
		$data = Set::find(static::$_data, $path);
		ksort($data);
		return $data;
		// return Set::order($data);
	}
	
	/**
	 * Deletes all navigation information, mainly for test cases.
	 * 
	 * @return void
	 */ 
	public static function clearData() {
		static::$_data = array();
	}

	
}
?>