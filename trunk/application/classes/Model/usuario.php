<?php defined('SYSPATH') or die('No direct access allowed.');

class Model_Usuario extends ORM {
	
	protected $_table_name = 'usuarios';
	
	protected $_table_columns = array(
		'id' => NULL,
		'usuario' => NULL,
		'nome' => NULL
	);
	
	protected $_rules = array(
		'usuario' => array(
			'not_empty'  => NULL,
			'min_length' => array(3),
			'max_length' => array(45),
			'regex'      => array('/^[-\pL\pN_.]++$/uD'),
		),
		'nome' => array(
			'not_empty'  => NULL,
			'min_length' => array(3),
			'max_length' => array(45),
			'regex'      => array('/^[-\pL\pN_.]++$/uD'),
		),
	);
	
}
