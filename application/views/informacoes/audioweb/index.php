<?php HTML::start_block() ?>
<section id="conteudo-principal" class="container" role="main">
	<header class="page-header">
		<?= HTML::header('<i class="glyphicon glyphicon-info-sign"></i> Ouvir para Ver, e Ver Melhor') ?>
	</header>
	<?= Helper_Trilha::exibir($trilha) ?>
	<div class="row">
		<div class="col-lg-12">
			<p class="lead">O AudioWeb é um sistema web que fala o conteúdo digital de uma página, e que foi desenvolvido especialmente para os usuários com deficiência visual e para as pessoas que trabalham com eles e buscam auxiliá-­los em suas atividades diárias, acadêmicas e profissionais.</p>
			<p>O AudioWeb pode ajudar professores, monitores, audiodescritores, pedagogos e educadores de um modo geral a preparar material digitalizado, tais como textos, imagens, diagramas, fotos, símbolos e fórmulas matemáticas para serem ouvidos por usuários com deficiência visual.</p>
			<p>O AudioWeb é composto de 3 módulos:</p>
			<ul>
				<li>AudioImagem, que prepara figuras para serem navegadas, interagidas e ouvidas;</li>
				<li>AudioFórmula, que edita e prepara expressões matemáticas para serem ouvidas corretamente; e</li>
				<li>AudioAula, que prepara aulas, com textos, imagens e fórmulas matemáticas, para serem navegadas, interagidas e ouvidas, de maneira interativa, ágil e amigável.</li>
			</ul>
			<p>Caso queira experimentar o AudioWeb, basta se cadastrar e começar a usar. O modelo de negócio do AudioWeb é baseado em duas alternativas básicas de licença de uso, a gratuita e a paga. No caso da gratuita, todo o material criado no sistema é compartilhado com os demais usuários do AudioWeb. No caso da licença paga, o usuário terá a opção de definir com quem compartilhar o material que vier a criar, e também terá a opção de comercializá­-lo. Essa alternativa ainda não está disponível.</p>
			<p>O AudioWeb está sendo desenvolvido pela empresa Polaris e pelo núcleo de pesquisas Alcance. Para informações mais detalhadas, ouça a página do link Institucional, acessível na barra de menu principal. Link: <a href="<?= Route::url('acao_padrao', array('directory' => 'informacoes', 'controller' => 'institucional')) ?>">Institucional</a>.</p>
		</div>
	</div>
</section>
<?php HTML::end_block() ?>