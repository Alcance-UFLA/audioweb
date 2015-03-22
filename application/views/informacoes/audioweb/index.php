<section id="conteudo-principal" class="container" role="main">
	<header class="page-header">
		<h1><i class="glyphicon glyphicon-info-sign"></i> Sobre o AudioWeb</h1>
	</header>
	<?= Helper_Trilha::exibir($trilha) ?>
	<div class="row">
		<div class="col-lg-12">
			<dl>
				<dt>O que é o AudioWeb?</dt>
				<dd>É um sistema web que fala o conteúdo digital de uma página, e que foi desenvolvido especialmente para os usuários com deficiência visual e para as pessoas que trabalham com eles e buscam auxiliá-los em suas atividades diárias, acadêmicas e profissionais.</dd>

				<dt>Como o AudioWeb pode ajudar?</dt>
				<dd>Professores, monitores e educadores de um modo geral podem preparar material digitalizado, tais como textos, imagens, diagramas, fotos, símbolos e fórmulas matemáticas para serem ouvidos por usuários com deficiência visual.</dd>

				<dt>Como é composto o AudioWeb?</dt>
				<dd>
					São 3 partes:
					<ol>
						<li>o módulo AudioImagem, que prepara figuras para serem interagidas e ouvidas;</li>
						<li>o módulo AudioFórmula, que prepara expressões matemáticas para serem ouvidas corretamente; e</li>
						<li>o módulo AudioAula, que prepara aulas, com textos, imagens e fórmulas matemáticas, para serem navegadas, interagidas e ouvidas por usuários com deficiência visual, de maneira ágil e amigável.</li>
					</ol>
				</dd>

				<dt>Já posso usar o AudioWeb?</dt>
				<dd>Sim, basta se cadastrar e começar a usar. O modelo de negócio do AudioWeb é baseado em duas alternativas básicas de licença de uso, a gratuita e a paga. No caso da gratuita, todo o material criado no sistema é compartilhado com os demais usuários do AudioWeb. No caso da licença paga, o usuário terá a opção de definir com quem compartilhar o material que vier a criar, e também poderá comercializá-lo. Essa alternativa ainda não está disponível.</dd>

				<dt>Quem são os desenvolvedores e os parceiros do projeto AudioWeb?</dt>
				<dd>Respostas no link Institucional, acessível ao final desta frase, ou na barra de navegação da página principal do AudioWeb. Link: <a href="<?= Route::url('acao_padrao', array('directory' => 'informacoes', 'controller' => 'institucional')) ?>">Institucional</a>.</dd>
			</dl>
		</div>
	</div>
</section>