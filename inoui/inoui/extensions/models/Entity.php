<?php

namespace inoui\extensions\models;
use \lithium\core\Environment;

class Entity extends \lithium\data\Entity {

	public function &__get($name) {

		$return =  parent::__get($name);
		if (is_array($return)) {
			$locale = Environment::get('locale');
			if (isset($return-$locale)) return $return->$locale;
		}
		return $return;
	}

}