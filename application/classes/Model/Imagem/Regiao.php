<?php
/**
 * Model Imagem_Regiao
 * @author Rubens Takiguti Ribeiro <rubs33@gmail.com>
 */
class Model_Imagem_Regiao extends Model_Base {
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
			'nome' => array(
				array('not_empty'),
				array('min_length', array(':value', 3)),
				array('max_length', array(':value', 64))
			),
			'descricao' => array(
				array('not_empty'),
				array('min_length', array(':value', 3))
			),
			'posicao' => array(
				array('not_empty'),
				array('numeric')
			),
			'tipo_regiao' => array(
				array('not_empty'),
				array('regex', array(':value', '/^(poly|rect|circle)$/'))
			),
			'coordenadas' => array(
				array('not_empty'),
				array('regex', array(':value', '/^\d+(,\d+)+$/'))
			),
			'id_imagem' => array(
				array('not_empty')
			),
		);
	}

	/**
	 * Obtem as caracteristicas de uma regiao de forma descritiva
	 * @return array
	 */
	public function obter_caracteristicas()
	{
		$largura = $this->imagem->largura;
		$altura  = $this->imagem->altura;

		$coordenadas = explode(',', $this->coordenadas);
		switch ($this->tipo_regiao) {
		case 'circle':
			$caracteristicas['formato'] = 'círculo';
			$centro_x       = $coordenadas[0];
			$centro_y       = $coordenadas[1];
			$raio           = $coordenadas[2];
			$largura_regiao = $raio * 2;
			$altura_regiao  = $raio * 2;
			break;
		case 'rect':
			$caracteristicas['formato'] = 'retângulo';
			$centro_x       = ($coordenadas[0] + $coordenadas[2]) / 2;
			$centro_y       = ($coordenadas[1] + $coordenadas[3]) / 2;
			$largura_regiao = $coordenadas[2] - $coordenadas[0];
			$altura_regiao  = $coordenadas[3] - $coordenadas[1];
			break;
		case 'poly':
			$tamanho = count($coordenadas);
			$menor_x = $largura;
			$menor_y = $altura;
			$maior_x = 0;
			$maior_y = 0;
			for ($i = 0; $i < $tamanho; $i += 2) {
				$x = (int)$coordenadas[$i];
				$y = (int)$coordenadas[$i + 1];
				if ($x < $menor_x) {
					$menor_x = $x;
				}
				if ($x > $maior_x) {
					$maior_x = $x;
				}
				if ($y < $menor_y) {
					$menor_y = $y;
				}
				if ($y > $maior_y) {
					$maior_y = $y;
				}
			}
			$centro_x       = ($menor_x + $maior_x) / 2;
			$centro_y       = ($menor_y + $maior_y) / 2;
			$largura_regiao = $maior_x - $menor_x;
			$altura_regiao  = $maior_y - $menor_y;
			break;
		}

		return array(
			'formato' => $this->obter_formato($this->tipo_regiao),
			'posicao' => $this->obter_posicao_ponto($centro_x, $centro_y, $largura, $altura),
			'tamanho' => $this->obter_tamanho($largura_regiao, $altura_regiao, $largura, $altura)
		);
	}

	/**
	 * Obtem o nome do formato da regiao
	 * @param string $tipo_regiao
	 * @return string
	 */
	private function obter_formato($tipo_regiao)
	{
		switch ($tipo_regiao) {
		case 'rect':
			return 'retângulo';
		case 'poly':
			return 'polígono';
		case 'circle':
			return 'círculo';
		}
	}

	/**
	 * Obtem a posicao de um ponto em relacao a um retangulo.
	 * @param int $x Coordenada X do ponto
	 * @param int $y Coordenada Y do ponto
	 * @param int $largura Largura do retangulo
	 * @param int $altura Altura do retangulo
	 * @return string
	 */
	private function obter_posicao_ponto($x, $y, $largura, $altura)
	{
		$posicao_vertical   = '';
		$posicao_horizontal = '';

		$altura_quadrante = $altura / 3;
		$largura_quadrante = $largura / 3;
		if ($y < $altura_quadrante) {
			$posicao_vertical = 'topo';
		} elseif ($y < 2 * $altura_quadrante) {
			$posicao_vertical = 'centro vertical';
		} else {
			$posicao_vertical = 'base';
		}
		if ($x < $largura_quadrante) {
			$posicao_horizontal = 'esquerda';
		} elseif ($x < 2 * $largura_quadrante) {
			$posicao_horizontal = 'centro horizontal';
		} else {
			$posicao_horizontal = 'direita';
		}
		return $posicao_vertical . ' / ' . $posicao_horizontal;
	}

	/**
	 * Obtem o tamanho de uma regiao em comparacao ao tamanho da imagem
	 * @param int $largura_regiao Largura da regiao
	 * @param int $altura_regiao Altura da regiao
	 * @param int $largura Largura da imagem
	 * @param int $altura Altura da imagem
	 * @return string
	 */
	private function obter_tamanho($largura_regiao, $altura_regiao, $largura, $altura)
	{
		$area_regiao = $largura_regiao * $altura_regiao;
		$area_imagem = $largura * $altura;
		$proporcao = $area_regiao / $area_imagem;
		if ($proporcao < 0.05) {
			return 'muito pequena';
		} elseif ($proporcao < 0.33) {
			return 'pequena';
		} elseif ($proporcao < 0.66) {
			return 'média';
		} elseif ($proporcao < 0.95) {
			return 'grande';
		} else {
			return 'muito grande';
		}
	}
}