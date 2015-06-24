<?php
/**
 * Model Publico_Alvo
 * @author Rubens Takiguti Ribeiro <rubs33@gmail.com>
 */
class Model_Publico_Alvo extends Model_Base {
	protected $_table_name = 'publicos_alvos';
	protected $_primary_key = 'id_publico_alvo';

	protected $_table_columns = array(
		'id_publico_alvo' => NULL,
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