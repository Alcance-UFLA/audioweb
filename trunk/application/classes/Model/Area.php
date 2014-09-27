<?php
/**
 * Model Area
 * @author Rubens Takiguti Ribeiro <rubs33@gmail.com>
 */
class Model_Area extends ORM {

	protected $_table_name = 'areas';
	protected $_primary_key = 'id_area';

	protected $_table_columns = array(
		'id_area' => NULL,
		'nome' => NULL,
	);

	public function rules()
	{
		return array(
			'id_area' => array(
				array('not_empty')
			),
			'nome' => array(
				array('not_empty')
			),
		);
	}
}