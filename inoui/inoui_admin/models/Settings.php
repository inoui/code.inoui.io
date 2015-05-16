<?php

namespace inoui_admin\models;

class Settings extends \lithium\data\Model {

	public $validates = array(
		'title' => array(
			'lengthBetween',
			'message' => 'Title can not be empty.'
		)
	);

	protected $_schema = array(
		'_id'   => array('type' => 'id'),
		'title' => array('type' => 'string', 'null' => false)
	);
}
?>