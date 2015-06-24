<?php
/**
 * Model Secao_Formula
 * @author Rubens Takiguti Ribeiro <rubs33@gmail.com>
 */
class Model_Secao_Formula extends Model_Base {
	protected $_table_name = 'secoes_formulas';
	protected $_primary_key = 'id_secao_formula';

	protected $_table_columns = array(
		'id_secao_formula' => NULL,
		'posicao' => NULL,
		'id_secao' => NULL,
		'id_formula' => NULL,
	);

	protected $_belongs_to = array(
		'formula' => array('model' => 'Formula', 'foreign_key' => 'id_formula'),
		'secao' => array('model' => 'Secao', 'foreign_key' => 'id_secao'),
	);

	public function rules()
	{
		return array(
			'posicao' => array(
				array('not_empty')
			),
			'id_secao' => array(
				array('not_empty')
			),
			'id_formula' => array(
				array('not_empty')
			),
		);
	}
}