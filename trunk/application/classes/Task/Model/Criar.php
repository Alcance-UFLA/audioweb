<?php
/**
 * Script para ajudar a criar um model cru.
 * @author Rubens Takiguti Ribeiro <rubs33@gmail.com>
 */
class Task_Model_Criar extends Minion_Task {

	protected $_options = array(
		'conexao' => 'default',
		'tabela' => NULL,
		'model' => NULL,
		'exibir' => false
	);

	protected function _execute(array $params)
	{
		if (is_null($params['tabela']))
		{
			throw new InvalidArgumentException('Faltou informar o parametro --tabela com o nome da tabela.');
		}
		if (is_null($params['model']))
		{
			throw new InvalidArgumentException('Faltou informar o parametro --model com o nome da classe Model');
		}

		$config_database = Kohana::$config->load('database');
		if ( ! isset($config_database[$params['conexao']]))
		{
			throw new InvalidArgumentException('Parametro --conexao possui valor inválido.');
		}
		$config_conexao = $config_database[$params['conexao']];

		$banco = $this->_obter_nome_banco($config_conexao);

		$colunas = $this->_obter_colunas_tabela($banco, $params['tabela']);
		if (empty($colunas))
		{
			throw new RuntimeException(sprintf('A tabela %s não possui colunas ou não existe.', $params['tabela']));
		}

		$relacionamentos = $this->_obter_relacionamentos_tabela($banco, $params['tabela']);

		$conteudo_model = $this->_criar_model($params['conexao'], $params['model'], $params['tabela'], $colunas, $relacionamentos);
		if ($params['exibir'])
		{
			fwrite(STDOUT, $conteudo_model);
			exit(0);
		}

		$arquivo_model = APPPATH . 'classes/Model/' . str_replace('_', '/', $params['model']) . '.php';
		if ( ! is_file($arquivo_model))
		{
			$diretorio_model = dirname($arquivo_model);
			if ( ! is_dir($diretorio_model) && ! mkdir($diretorio_model, 0755, true))
			{
				throw new RuntimeException(sprintf('Erro ao criar diretório %s', $diretorio_model));
			}
			if (file_put_contents($arquivo_model, $conteudo_model) === false)
			{
				throw new RuntimeException(sprintf('Erro ao criar arquivo %s', $arquivo_model));
			}
		}
		else
		{
			throw new RuntimeException(sprintf('Arquivo %s já existe', $arquivo_model));
		}
		fprintf(STDOUT, "Arquivo %s criado com sucesso\n", $arquivo_model);
		exit(0);
	}

	protected function _obter_nome_banco($config_conexao)
	{
		$dsn = $config_conexao['connection']['dsn'];

		if ( ! preg_match('/^mysql:(.*)$/', $dsn, $matches_dsn))
		{
			throw new RuntimeException('Este script só suporta bancos de dados MySQL.');
		}
		$parametros_dsn = explode(';', $matches_dsn[1]);

		foreach ($parametros_dsn as $parametro_dsn)
		{
			if (preg_match('/dbname=(.*)/i', $parametro_dsn, $matches_parametro_dsn))
			{
				return $matches_parametro_dsn[1];
			}
		}
		throw new RuntimeException('Nome do banco não encontrado.');
	}

	protected function _obter_colunas_tabela($banco, $tabela)
	{
		$query_colunas = DB::query(Database::SELECT, 'SELECT * FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_SCHEMA = :banco AND TABLE_NAME = :tabela ORDER BY ORDINAL_POSITION');
		$query_colunas->parameters(array(
			':banco' => $banco,
			':tabela' => $tabela
		));
		return $query_colunas->execute()->as_array();
	}

	protected function _obter_relacionamentos_tabela($banco, $tabela)
	{
		$query_colunas = DB::query(Database::SELECT, 'SELECT * FROM INFORMATION_SCHEMA.KEY_COLUMN_USAGE WHERE TABLE_SCHEMA = :banco AND TABLE_NAME = :tabela AND REFERENCED_TABLE_NAME IS NOT NULL');
		$query_colunas->parameters(array(
			':banco' => $banco,
			':tabela' => $tabela
		));
		return $query_colunas->execute()->as_array();
	}

	protected function _criar_model($conexao, $model, $tabela, $colunas, $relacionamentos)
	{
		$linha_db = '';
		if ($conexao != 'default')
		{
			$linha_db = sprintf("\tprotected \$db_group = '%s';", var_export($conexao, true));
		}

		$lista_colunas = '';
		$lista_rules = '';
		$quebra_linha = '';
		$pk = NULL;
		foreach ($colunas as $coluna)
		{
			if ($coluna['COLUMN_KEY'] == 'PRI')
			{
				$pk = $coluna['COLUMN_NAME'];
			}
			$lista_colunas .= sprintf(
				"%s\t\t%s => NULL,",
				$quebra_linha,
				var_export($coluna['COLUMN_NAME'], true)
			);
			$lista_rules .= sprintf(
				"%s\t\t\t%s => array(\n\t\t\t\tarray('not_empty')\n\t\t\t),",
				$quebra_linha,
				var_export($coluna['COLUMN_NAME'], true)

			);
			$quebra_linha = "\n";
		}

		if ($pk === NULL)
		{
			throw new RuntimeException('Tabela não possui chave primária.');
		}

		$atributo_relacionamentos = '';
		if ($relacionamentos)
		{
			$lista_relacionamentos = '';
			$quebra_linha = '';
			foreach ($relacionamentos as $relacionamento)
			{
				$lista_relacionamentos .= sprintf(
					"%s\t\t%s => array('model' => 'MODEL', 'foreign_key' => %s),",
					$quebra_linha,
					var_export($relacionamento['REFERENCED_TABLE_NAME'], true),
					var_export($relacionamento['COLUMN_NAME'], true)
				);
				$quebra_linha = "\n";
			}
			$atributo_relacionamentos = sprintf("\n\tprotected \$_belongs_to = array(\n%s\n\t);\n", $lista_relacionamentos);
		}

		$conteudo = <<<ARQ
<?php
/**
 * Model {$model}
 * @author Nome <email>
 */
class Model_{$model} extends ORM {
{$linha_db}
	protected \$_table_name = '{$tabela}';
	protected \$_primary_key = '{$pk}';

	protected \$_table_columns = array(
{$lista_colunas}
	);
{$atributo_relacionamentos}
	public function rules()
	{
		return array(
{$lista_rules}
		);
	}
}
ARQ;
		return $conteudo;
	}
}