<?php
/**
 * Imagem mapeada
 * @author Rubens Takiguti Ribeiro <rubs33@gmail.com>
 */
class Model_Imagem extends ORM {

	protected $_table_name = 'imagens';
	protected $_primary_key = 'id_imagem';

	protected $_table_columns = array(
		'id_imagem' => NULL,
		'nome' => NULL,
		'descricao' => NULL,
		'arquivo' => NULL,
		'altura' => NULL,
		'largura' => NULL,
		'rotulos' => NULL,
		'data_cadastro' => NULL,
		'data_alteracao' => NULL,
		'id_tipo_imagem' => NULL,
		'id_usuario' => NULL
	);

	protected $_belongs_to = array(
		'usuario' => array('model' => 'Usuario', 'foreign_key' => 'id_usuario'),
		'tipo_imagem' => array('model' => 'Tipo_Imagem', 'foreign_key' => 'id_tipo_imagem')
	);

	public function rules()
	{
		return array(
			'nome' => array(
				array('not_empty'),
				array('min_length', array(':value', 3)),
				array('max_length', array(':value', 64))
			),
			'descricao' => array(
				array('not_empty'),
				array('min_length', array(':value', 3))
			),
			'arquivo' => array(
				array('not_empty'),
				array('max_length', array(':value', 64))
			),
			'altura' => array(
				array('not_empty')
			),
			'largura' => array(
				array('not_empty')
			),
			'rotulos' => array(
				array('max_length', array(':value', 256))
			),
			'id_tipo_imagem' => array(
				array('not_empty')
			),
			'id_usuario' => array(
				array('not_empty')
			),
		);
	}

	public function filters()
	{
		return array(
			'nome' => array(
				array('trim')
			),
			'descricao' => array(
				array('trim')
			)
		);
	}

}
