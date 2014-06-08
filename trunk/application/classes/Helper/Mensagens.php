<?php
/**
 * Helper para montar mensagens de aviso
 * @author Rubens Takiguti Ribeiro <rubs33@gmail.com>
 */
class Helper_Mensagens {

	/**
	 * Retorna as mensagens formatadas.
	 * @param array[
	 *     string => string || array[string]
	 * ] $mensagens Array indexado pelo tipo de mensagem ('erro', 'sucesso', 'aviso', 'informacao').
	 * Cada indice deve apontar para um array contendo as mensagens a serem exibidas.
	 * @return string
	 */
	public static function exibir(array $mensagens)
	{
		$tipos_mensagens = array(
			'erro' => array(
				'class'    => 'alert alert-danger alert-dismissable',
				'singular' => 'Erro',
				'plural'   => 'Erros'
			),
			'sucesso' => array(
				'class'    => 'alert alert-success alert-dismissable',
				'singular' => 'Aviso',
				'plural'   => 'Avisos'
			),
			'atencao' => array(
				'class'    => 'alert alert-warning alert-dismissable',
				'singular' => 'Atenção',
				'plural'   => 'Atenção'
			),
			'informacao' => array(
				'class'    => 'alert alert-info alert-dismissable',
				'singular' => 'Informação',
				'plural'   => 'Informações'
			)
		);

		$html = '';
		foreach ($mensagens as $tipo => $mensagens_tipo)
		{
			if ( ! isset($tipos_mensagens[$tipo]))
			{
				throw new InvalidArgumentException('Tipo de mensagem invalido: '.$tipo);
			}
			$dados_tipo = $tipos_mensagens[$tipo];

			if (is_string($mensagens_tipo)) {
				$mensagens_tipo = array($mensagens_tipo);
			}

			if (count($mensagens_tipo) == 1)
			{
				$str_titulo = $dados_tipo['singular'];
				$str_mensagens = self::lista($mensagens_tipo);
			}
			else
			{
				$str_titulo = $dados_tipo['plural'];
				$str_mensagens = self::lista($mensagens_tipo);
			}
			$html .= sprintf(
				'<div class="%s">'.
				'    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>'.
				'    <div><strong>%s</strong>: %s</div>'.
				'</div>',
				$dados_tipo['class'],
				$str_titulo,
				$str_mensagens
			);
		}

		return $html;
	}

	private static function lista($lista)
	{
		if (is_string($lista))
		{
			$html = $lista;
		}
		elseif (is_array($lista))
		{
			if (count($lista) == 1)
			{
				$html = self::lista(current($lista));
			}
			else
			{
				$html = '<ul>';
				foreach ($lista as $item)
				{
					$html .= sprintf('<li>%s</li>', self::lista($item));
				}
				$html .= '</ul>';
			}
		}
		return $html;
	}
}