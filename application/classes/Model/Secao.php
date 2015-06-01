<?php
/**
 * Model Secao
 * @author Rubens Takiguti Ribeiro <rubs33@gmail.com>
 */
class Model_Secao extends ORM {
	protected $_table_name = 'secoes';
	protected $_primary_key = 'id_secao';

	protected $_table_columns = array(
		'id_secao' => NULL,
		'titulo' => NULL,
		'nivel' => NULL,
		'posicao' => NULL,
		'data_cadastro' => NULL,
		'data_alteracao' => NULL,
		'id_aula' => NULL,
	);

	protected $_created_column = array(
		'column' => 'data_cadastro',
		'format' => 'Y-m-d H:i:s'
	);

	protected $_updated_column = array(
		'column' => 'data_alteracao',
		'format' => 'Y-m-d H:i:s'
	);

	protected $_belongs_to = array(
		'aula' => array('model' => 'Aula', 'foreign_key' => 'id_aula'),
	);

	protected $_has_many = array(
		'formulas' => array('model' => 'Secao_Formula', 'foreign_key' => 'id_secao'),
		'imagens' => array('model' => 'Secao_Imagem', 'foreign_key' => 'id_secao')
	);

	public function rules()
	{
		return array(
			'titulo' => array(
				array('not_empty'),
				array('max_length', array(':value', 128))
			),
			'nivel' => array(
				array('not_empty')
			),
			'posicao' => array(
				array('not_empty')
			),
			'id_aula' => array(
				array('not_empty')
			),
		);
	}
}