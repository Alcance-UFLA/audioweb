<?php
/**
 * Model Secao_Texto
 * @author Rubens Takiguti Ribeiro <rubs33@gmail.com>
 */
class Model_Secao_Texto extends ORM {

	protected $_table_name = 'secoes_textos';
	protected $_primary_key = 'id_secao_texto';

	protected $_table_columns = array(
		'id_secao_texto' => NULL,
		'identificacao' => NULL,
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
			'id_secao_texto' => array(
				array('not_empty')
			),
			'identificacao' => array(
				array('not_empty')
			),
			'texto' => array(
				array('not_empty')
			),
			'posicao' => array(
				array('not_empty')
			),
			'id_secao' => array(
				array('not_empty')
			),
		);
	}
}