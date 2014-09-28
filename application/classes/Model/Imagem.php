<?php
/**
 * Imagem mapeada
 * @author Rubens Takiguti Ribeiro <rubs33@gmail.com>
 */
class Model_Imagem extends ORM {
	protected $_table_name = 'imagens';
	protected $_primary_key = 'id_imagem';

	protected $_created_column = array(
		'column' => 'data_cadastro',
		'format' => 'Y-m-d H:i:s'
	);

	protected $_uptaded_column = array(
		'column' => 'data_alteracao',
		'format' => 'Y-m-d H:i:s'
	);

	protected $_table_columns = array(
		'id_imagem' => NULL,
		'nome' => NULL,
		'descricao' => NULL,
		'arquivo' => NULL,
		'mime_type' => NULL,
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

	protected $_has_many = array(
		'secoes' => array('model' => 'Secao_Imagem', 'foreign_key' => 'id_imagem'),
		'regioes' => array('model' => 'Imagem_Regiao', 'foreign_key' => 'id_imagem'),
		'publicos_alvos' => array('model' => 'Publico_Alvo', 'through' => 'imagens_publicos_alvos', 'foreign_key' => 'id_imagem', 'far_key' => 'id_publico_alvo'),
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
			'mime_type' => array(
				array('not_empty')
			),
			'altura' => array(
				array('not_empty'),
				array('numeric')
			),
			'largura' => array(
				array('not_empty'),
				array('numeric')
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
