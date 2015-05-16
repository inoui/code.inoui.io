<?php

namespace inoui\extensions\models;


class Inoui extends \lithium\data\Model {


	protected $_schema = array(
		'_id'   => array('type' => 'id')
	);

	protected static function _initialize($class) {
		$self = parent::_initialize($class);
        if (method_exists($class,'validationRules')) {
            $validates = $self->validates;
            $self->validates = static::validationRules($validates);
        }
		return $self;
	}

}
?>