<?php
class Model_Usuario extends ORM {

	protected $_table_name = 'usuarios';

	protected $_table_columns = array(
		'id' => NULL,
		'usuario' => NULL,
		'nome' => NULL
	);

	public function rules()
	{
		return array(
			'usuario' => array(
				array('not_empty'),
				array('min_length', array(':value', 3)),
				array('max_length', array(':value', 45))
			),
			'nome' => array(
				array('not_empty', null),
				array('min_length', array(':value', 3)),
				array('max_length', array(':value', 45))
			)
		);
	}

	public static function usuario_unico($usuario)
	{
		return ! DB::select(array(DB::expr('COUNT(*)'), 'total'))
			->from('usuarios')
			->where('usuario', '=', $usuario)
			->limit(1)
			->execute()
			->get('total');
	}

}
