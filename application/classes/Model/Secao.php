<?php
/**
 * Model Secao
 * @author Rubens Takiguti Ribeiro <rubs33@gmail.com>
 */
class Model_Secao extends Model_Base {
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
		'formulas' => array('model' => 'Secao_Formula', 'foreign_key' => 'id_secao', 'far_key' => 'id_secao_formula'),
		'imagens' => array('model' => 'Secao_Imagem', 'foreign_key' => 'id_secao', 'far_key' => 'id_secao_imagem'),
		'textos' => array('model' => 'Secao_Texto', 'foreign_key' => 'id_secao', 'far_key' => 'id_secao_texto')
	);

	public function rules()
	{
		return array(
			'titulo' => array(
				array('not_empty'),
				array('max_length', array(':value', 128))
			),
			'nivel' => array(
				array('not_empty'),
				array('range', array(':value', 1, 6))
			),
			'posicao' => array(
				array('not_empty'),
				array('range', array(':value', 1, 256))
			),
			'id_aula' => array(
				array('not_empty')
			),
		);
	}

	public function obter_itens()
	{
		$textos = ORM::Factory('Secao_Texto')
			->where('id_secao', '=', $this->pk())
			->order_by('posicao')
			->find_all();
		$imagens = ORM::Factory('Secao_Imagem')
			->where('id_secao', '=', $this->pk())
			->order_by('posicao')
			->find_all();
		$formulas = ORM::Factory('Secao_Formula')
			->where('id_secao', '=', $this->pk())
			->order_by('posicao')
			->find_all();

		$itens = array();
		foreach ($textos as $texto) {
			$itens[$texto->posicao] = $texto;
		}
		foreach ($imagens as $imagem) {
			$itens[$imagem->posicao] = $imagem;
		}
		foreach ($formulas as $formula) {
			$itens[$formula->posicao] = $formula;
		}

		ksort($itens);

		return $itens;
	}

	/**
	 * Atualiza a posicao dos itens da secao para ficar consistente
	 * @return void
	 */
	public function atualizar_posicoes_itens()
	{
		$posicao = 1;
		foreach ($this->obter_itens() as $item) {
			if ($item->posicao != $posicao) {
				$item->posicao = $posicao;
				$item->save();
			}
			$posicao += 1;
		}
	}
}