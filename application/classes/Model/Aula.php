<?php
/**
 * Model Aula
 * @author Rubens Takiguti Ribeiro <rubs33@gmail.com>
 */
class Model_Aula extends ORM {

	protected $_table_name = 'aulas';
	protected $_primary_key = 'id_aula';

	protected $_table_columns = array(
		'id_aula' => NULL,
		'nome' => NULL,
		'descricao' => NULL,
		'rotulos' => NULL,
		'data_cadastro' => NULL,
		'data_atualizacao' => NULL,
		'id_usuario' => NULL,
	);

	protected $_belongs_to = array(
		'usuario' => array('model' => 'Usuario', 'foreign_key' => 'id_usuario'),
	);

	public function rules()
	{
		return array(
			'id_aula' => array(
				array('not_empty')
			),
			'nome' => array(
				array('not_empty')
			),
			'descricao' => array(
				array('not_empty')
			),
			'rotulos' => array(
				array('not_empty')
			),
			'data_cadastro' => array(
				array('not_empty')
			),
			'data_atualizacao' => array(
				array('not_empty')
			),
			'id_usuario' => array(
				array('not_empty')
			),
		);
	}
}