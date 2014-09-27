<?php
/**
 * Model Imagem_Regiao
 * @author Rubens Takiguti Ribeiro <rubs33@gmail.com>
 */
class Model_Imagem_Regiao extends ORM {

	protected $_table_name = 'imagens_regioes';
	protected $_primary_key = 'id_imagem_regiao';

	protected $_table_columns = array(
		'id_imagem_regiao' => NULL,
		'nome' => NULL,
		'descricao' => NULL,
		'posicao' => NULL,
		'tipo_regiao' => NULL,
		'coordenadas' => NULL,
		'id_imagem' => NULL,
	);

	protected $_belongs_to = array(
		'imagem' => array('model' => 'Imagem', 'foreign_key' => 'id_imagem'),
	);

	public function rules()
	{
		return array(
			'id_imagem_regiao' => array(
				array('not_empty')
			),
			'nome' => array(
				array('not_empty')
			),
			'descricao' => array(
				array('not_empty')
			),
			'posicao' => array(
				array('not_empty')
			),
			'tipo_regiao' => array(
				array('not_empty')
			),
			'coordenadas' => array(
				array('not_empty')
			),
			'id_imagem' => array(
				array('not_empty')
			),
		);
	}
}