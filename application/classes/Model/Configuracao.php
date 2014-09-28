<?php
/**
 * Model Configuracao
 * @author Rubens Takiguti Ribeiro <rubs33@gmail.com>
 */
class Model_Configuracao extends ORM {
	protected $_table_name = 'configuracoes';
	protected $_primary_key = 'id_configuracao';

	protected $_table_columns = array(
		'id_configuracao' => NULL,
		'chave' => NULL,
		'nome' => NULL,
		'valor_padrao' => NULL,
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
			'valor_padrao' => array(
				array('not_empty')
			),
		);
	}
}