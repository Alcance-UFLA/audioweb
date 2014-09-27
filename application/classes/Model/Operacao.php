<?php
/**
 * Model Operacao
 * @author Rubens Takiguti Ribeiro <rubs33@gmail.com>
 */
class Model_Operacao extends ORM {

	protected $_table_name = 'operacoes';
	protected $_primary_key = 'id_operacao';

	protected $_table_columns = array(
		'id_operacao' => NULL,
		'chave' => NULL,
		'nome' => NULL,
		'tecla_padrao' => NULL,
	);

	public function rules()
	{
		return array(
			'id_operacao' => array(
				array('not_empty')
			),
			'chave' => array(
				array('not_empty')
			),
			'nome' => array(
				array('not_empty')
			),
			'tecla_padrao' => array(
				array('not_empty')
			),
		);
	}
}