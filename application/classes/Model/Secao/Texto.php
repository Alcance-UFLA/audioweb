<?php
/**
 * Model Secao_Texto
 * @author Rubens Takiguti Ribeiro <rubs33@gmail.com>
 */
class Model_Secao_Texto extends Model_Base {
	protected $_table_name = 'secoes_textos';
	protected $_primary_key = 'id_secao_texto';

	protected $_table_columns = array(
		'id_secao_texto' => NULL,
		'texto' => NULL,
		'posicao' => NULL,
		'id_secao' => NULL,
	);

	protected $_belongs_to = array(
		'secao' => array('model' => 'Secao', 'foreign_key' => 'id_secao'),
	);

	public function rules()
	{
		return array(
			'texto' => array(
				array('not_empty')
			),
			'posicao' => array(
				array('not_empty'),
				array('range', array(':value', 1, 256))
			),
			'id_secao' => array(
				array('not_empty')
			),
		);
	}
}