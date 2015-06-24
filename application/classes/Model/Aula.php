<?php
/**
 * Model Aula
 * @author Rubens Takiguti Ribeiro <rubs33@gmail.com>
 */
class Model_Aula extends Model_Base {
	protected $_table_name = 'aulas';
	protected $_primary_key = 'id_aula';

	protected $_created_column = array(
		'column' => 'data_cadastro',
		'format' => 'Y-m-d H:i:s'
	);

	protected $_updated_column = array(
		'column' => 'data_alteracao',
		'format' => 'Y-m-d H:i:s'
	);

	protected $_table_columns = array(
		'id_aula' => NULL,
		'nome' => NULL,
		'descricao' => NULL,
		'rotulos' => NULL,
		'data_cadastro' => NULL,
		'data_alteracao' => NULL,
		'id_usuario' => NULL,
	);

	protected $_belongs_to = array(
		'usuario' => array('model' => 'Usuario', 'foreign_key' => 'id_usuario'),
	);

	protected $_has_many = array(
		'secoes' => array('model' => 'Secao', 'foreign_key' => 'id_aula', 'far_key' => 'id_secao')
	);

	public function rules()
	{
		return array(
			'nome' => array(
				array('not_empty'),
				array('min_length', array(':value', 3)),
				array('max_length', array(':value', 128))
			),
			'descricao' => array(
				array('not_empty'),
				array('min_length', array(':value', 3))
			),
			'rotulos' => array(
				array('max_length', array(':value', 256))
			),
			'id_usuario' => array(
				array('not_empty')
			),
		);
	}

	public function filters()
	{
		return array(
			'nome' => array(
				array('trim')
			),
			'descricao' => array(
				array('trim')
			)
		);
	}
}