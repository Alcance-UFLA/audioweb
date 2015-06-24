<?php
/**
 * Model Formula
 * @author Rubens Takiguti Ribeiro <rubs33@gmail.com>
 */
class Model_Formula extends Model_Base {
	protected $_table_name = 'formulas';
	protected $_primary_key = 'id_formula';

	protected $_table_columns = array(
		'id_formula' => NULL,
		'nome' => NULL,
		'descricao' => NULL,
		'expressao' => NULL,
		'data_cadastro' => NULL,
		'data_alteracao' => NULL,
		'id_usuario' => NULL,
	);

	protected $_belongs_to = array(
		'usuario' => array('model' => 'Usuario', 'foreign_key' => 'id_usuario'),
	);

	protected $_has_many = array(
		'areas' => array('model' => 'Area', 'through' => 'formulas_areas', 'foreign_key' => 'id_formula', 'far_key' => 'id_area'),
		'secoes' => array('model' => 'Secao_Formula', 'foreign_key' => 'id_formula', 'far_key' => 'id_secao')
	);

	public function rules()
	{
		return array(
			'nome' => array(
				array('not_empty')
			),
			'descricao' => array(
				array('not_empty')
			),
			'expressao' => array(
				array('not_empty')
			),
			'data_cadastro' => array(
				array('not_empty')
			),
			'data_alteracao' => array(
				array('not_empty')
			),
			'id_usuario' => array(
				array('not_empty')
			),
		);
	}
}