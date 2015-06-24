<?php
/**
 * Model Area
 * @author Rubens Takiguti Ribeiro <rubs33@gmail.com>
 */
class Model_Area extends Model_Base {
	protected $_table_name = 'areas';
	protected $_primary_key = 'id_area';

	protected $_table_columns = array(
		'id_area' => NULL,
		'nome' => NULL,
	);

	public function rules()
	{
		return array(
			'nome' => array(
				array('not_empty')
			),
		);
	}
}