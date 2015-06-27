<?php
/**
 * Model Operacao
 * @author Rubens Takiguti Ribeiro <rubs33@gmail.com>
 */
class Model_Operacao extends Model_Base {
	protected $_table_name = 'operacoes';
	protected $_primary_key = 'id_operacao';

	protected $_table_columns = array(
		'id_operacao' => NULL,
		'chave' => NULL,
		'nome' => NULL,
		'tecla_padrao' => NULL,
		'shift' => NULL,
		'alt' => NULL,
		'ctrl' => NULL
	);

	public function rules()
	{
		return array(
			'chave' => array(
				array('not_empty')
			),
			'nome' => array(
				array('not_empty')
			),
			'tecla_padrao' => array(
				array('not_empty')
			),
			'shift' => array(
				array('not_empty')
			),
			'alt' => array(
				array('not_empty')
			),
			'ctrl' => array(
				array('not_empty')
			),
		);
	}
}