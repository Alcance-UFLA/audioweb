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
		'nome' => NULL,
		'descricao' => NULL,
		'data_cadastro' => NULL,
		'data_alteracao' => NULL,
		'id_aula' => NULL,
	);

	protected $_belongs_to = array(
		'aula' => array('model' => 'Aula', 'foreign_key' => 'id_aula'),
	);

	protected $_has_many = array(
		'formulas' => array('model' => 'Secao_Formula', 'foreign_key' => 'id_secao'),
		'textos' => array('model' => 'Secao_Texto', 'foreign_key' => 'id_secao'),
		'imagens' => array('model' => 'Secao_Imagem', 'foreign_key' => 'id_secao')
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
			'data_cadastro' => array(
				array('not_empty')
			),
			'data_alteracao' => array(
				array('not_empty')
			),
			'id_aula' => array(
				array('not_empty')
			),
		);
	}
}