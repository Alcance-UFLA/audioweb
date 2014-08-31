<?php
class Model_Usuario extends ORM {

	protected $_table_name = 'usuarios';
	protected $_primary_key = 'id_usuario';

	protected $_table_columns = array(
		'id_usuario' => NULL,
		'nome' => NULL,
		'email' => NULL,
		'senha' => NULL,
	);

	protected $_has_many = array(
		'tokens' => array('model' => 'Usuario_Token'),
	);


	public function rules()
	{
		return array(
			'nome' => array(
				array('not_empty', null),
				array('min_length', array(':value', 3)),
				array('max_length', array(':value', 128))
			),
			'email' => array(
				array('not_empty'),
				array('min_length', array(':value', 3)),
				array('max_length', array(':value', 128)),
				array(array($this, 'unique'), array('email', ':value')),
			),
			'senha' => array(
				array('not_empty')
			)
		);
	}

	public function complete_login() {}

}
