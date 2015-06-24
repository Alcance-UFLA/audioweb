<?php
/**
 * Model Formula_Area
 * @author Rubens Takiguti Ribeiro <rubs33@gmail.com>
 */
class Model_Formula_Area extends Model_Base {
	protected $_table_name = 'formulas_areas';
	protected $_primary_key = 'id_formula_area';

	protected $_table_columns = array(
		'id_formula_area' => NULL,
		'id_formula' => NULL,
		'id_area' => NULL,
	);

	protected $_belongs_to = array(
		'area' => array('model' => 'Area', 'foreign_key' => 'id_area'),
		'formula' => array('model' => 'Formula', 'foreign_key' => 'id_formula'),
	);

	public function rules()
	{
		return array(
			'id_formula' => array(
				array('not_empty')
			),
			'id_area' => array(
				array('not_empty')
			),
		);
	}
}