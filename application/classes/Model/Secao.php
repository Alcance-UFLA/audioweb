<?php
/**
 * Model Secao
 * @author Rubens Takiguti Ribeiro <rubs33@gmail.com>
 */
class Model_Secao extends ORM {

	protected $_table_name = 'secoes';
	protected $_primary_key = 'id_secao';

	protected $_table_columns = array(
		'id_secao' => NULL,
		'nome' => NULL,
		'descricao' => NULL,
		'data_cadastro' => NULL,
		'data_atualizacao' => NULL,
		'id_aula' => NULL,
	);

	protected $_belongs_to = array(
		'aula' => array('model' => 'Aula', 'foreign_key' => 'id_aula'),
	);

	public function rules()
	{
		return array(
			'id_secao' => array(
				array('not_empty')
			),
			'nome' => array(
				array('not_empty')
			),
			'descricao' => array(
				array('not_empty')
			),
			'data_cadastro' => array(
				array('not_empty')
			),
			'data_atualizacao' => array(
				array('not_empty')
			),
			'id_aula' => array(
				array('not_empty')
			),
		);
	}
}