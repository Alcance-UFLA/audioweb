<?php
/**
 * Restrição padrão da aplicação.
 * @author Rubens Takiguti Ribeiro <rubs33@gmail.com>
 */
class Model_Restricao_Aplicacao extends Model_Base {
	protected $_table_name = 'restricoes_aplicacao';
	protected $_primary_key = 'id_restricao_aplicacao';

	protected $_table_columns = array(
		'id_restricao_aplicacao' => NULL,
		'chave' => NULL,
		'nome' => NULL,
		'valor_padrao' => NULL
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
			)
		);
	}
}
