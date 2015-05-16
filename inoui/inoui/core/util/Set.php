<?php

namespace inoui\core\util;

class Set extends \lithium\util\Set {
	
	/**
	 * Orders nested array based on array key.
	 * 
	 * @param array $data
	 * @param string $key
	 * @return array
	 */
	public static function order($data, $key = 'weight') {
		$output = array();
		
		if (!$data) {
			return $output;
		}
		
		$flat = static::flatten($data);
		print_r($flat);
		$flatWeight = array();
		foreach ($flat AS $k => $v) {
			if (strstr($k, $key)) {
				$flatWeight[$k] = $v;
			}
		}
		asort($flatWeight);
		
		foreach ($flatWeight AS $path => $weight) {
			$pathE = explode('.', $path);
			$depth = count($pathE);
			unset($pathE[$depth - 1]);
			$currentPath = implode('.', $pathE);
			$output = self::insert($output, $currentPath, self::find($data, $currentPath));
		}
		$output = self::merge($output, self::diff($data, $output));
		return $output;
	}
	
	/**
	 * Checks if a particular path is set in an array, and returns the value
	 *
	 * @param mixed $data Data to check on.
	 * @param mixed $path A dot-delimited string.
	 * @return mixed value if path is found, `false` otherwise.
	 */
	public static function find($data, $path = null) {
		if (!$path) {
			return $data;
		}
		$path = is_array($path) ? $path : explode('.', $path);

		foreach ($path as $i => $key) {
			if (is_numeric($key) && intval($key) > 0 || $key === '0') {
				$key = intval($key);
			}
			if ($i === count($path) - 1) {
				if (is_array($data) && isset($data[$key])) {
					return $data[$key];
				}
			} else {
				if (!is_array($data) || !isset($data[$key])) {
					return false;
				}
				$data =& $data[$key];
			}
		}
	}
	
	/**
	 * Searches for a value in the array and returns dot separated path.
	 *
	 * @param mixed $data Data to check on.
	 * @param mixed $value Value to search for.
	 * @param string $key Limit search by key.
	 * @return mixed Dot separated path if value is found, `false` otherwise.
	 */
	public static function findPath($data, $value, $key = null) {
		$flatData = static::flatten($data);
		foreach ($flatData AS $k => $v) {
			if (!$key && $v == $value) {
				return $k;
			} elseif ($key && $key == $k && $value == $v) {
				return $k;
			}
		}
		return false;
	}
	
}

?>
