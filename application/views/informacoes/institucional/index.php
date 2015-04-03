<?php HTML::start_block() ?>
<section id="conteudo-principal" class="container" role="main">
	<header class="page-header">
		<?= HTML::header('<i class="glyphicon glyphicon-globe"></i> Empreende<wbr />dorismo voltado para Inclusão') ?>
	</header>
	<?= Helper_Trilha::exibir($trilha) ?>
	<div class="row">
		<div class="col-md-6 text-center">
			<img class="img-responsive" src="<?= URL::cdn('img/polaris.png') ?>" alt="Logotipo da empresa Polaris Inovações em Soluções Web" width="453" height="200" />
		</div>
		<div class="col-md-6 text-center">
			<img class="img-responsive" src="<?= URL::cdn('img/alcance.png') ?>" alt="Logotipo provisória do Alcance, Núcleo de Pesquisas em Acessibilidade, Usabilidade e Tecnologia Assistiva" width="453" height="200" />
		</div>
	</div>
	<div class="row">
		<div class="col-lg-12">
			<p>O projeto AudioWeb é uma realização da empresa Polaris Inovações em Soluções Web e do núcleo de pesquisas Alcance. Polaris é uma empresa de base tecnológica fundada para inovar na web com soluções para educação inclusiva, comércio e marketing online; e está sendo incubada na <abbr title="Incubadora de Empresas de Base Tecnológica">Inbatec</abbr>/<abbr title="Universidade Federal de Lavras">UFLA</abbr>, a Incubadora de Empresas de Base Tecnológica da Universidade Federal de Lavras, que se localiza no sul de Minas Gerais. Alcance é o Núcleo de Pesquisas em Acessibilidade, Usabilidade e Tecnologia Assistiva, apoiado pelo <abbr title="Conselho Nacional de Desenvolvimento Científico e Tecnológico">CNPq</abbr>, e integrante da rede nacional de núcleos de pesquisas do <abbr title="Centro de Nacional de Referência em Tecnologia Assistiva">CNRTA</abbr>, que é o Centro de Nacional de Referência em Tecnologia Assistiva.</p>
			<p>Esse projeto nasceu da observação do processo de ensino e aprendizagem de um aluno com deficiência visual, a partir de 2007, e baseou-se na seguinte ideia: se um leitor de tela pode ler textos, porque não imagens? A empresa Polaris foi fundada, em 2011, para desenvolver essa tecnologia assistiva e enfrentou diversos desafios, dentre eles: a imaturidade do projeto e a falta de apoio, principalmente o financeiro. A equipe da empresa Polaris e depois ampliada com o núcleo Alcance, foi descobrindo gradualmente como o sistema deveria funcionar, e o primeiro apoio financeiro foi obtido somente três anos depois, no início de 2014, em edital de tecnologia assistiva do <abbr title="Conselho Nacional de Desenvolvimento Científico e Tecnológico">CNPq</abbr>. Este edital tinha como objetivo a criação e consolidação de núcleos de pesquisas em tecnologia assistiva, dando então origem ao núcleo Alcance. Com o amadurecimento do projeto, percebeu-se que o AudioImagem deveria se tornar uma das partes do AudioWeb, um sistema maior que engloba a audiodescrição de textos, imagens e fórmulas matemáticas.</p>
			<p>O AudioWeb não está pronto ainda. Somente o módulo AudioImagem está construído, e mesmo assim precisando de várias melhorias. Os módulos AudioFormula e AudioAula estão sendo desenvolvidos. O AudioAula deverá estar pronto em junho de 2015, e o AudioFormula em setembro de 2015. Caso queira ajudar a equipe do AudioWeb, ouça a página do link <a href="<?= Route::url('acao_padrao', array('directory' => 'informacoes', 'controller' => 'ajudar')) ?>">Quero Ajudar</a>. E caso deseje usar o AudioWeb, ouça a página do link <a href="<?= Route::url('acao_padrao', array('directory' => 'informacoes', 'controller' => 'funcionamento')) ?>">Funcionamento</a>.</p>
		</div>
	</div>
	<div class="row">
		<div class="col-lg-2 col-md-4 col-sm-6">
			<img class="img-responsive" src="<?= URL::cdn('img/cnpq.png') ?>" alt="Logotipo do CNPq, Conselho Nacional de Desenvolvimento Científico e Tecnológico" width="238" height="90" />
		</div>
		<div class="col-lg-2 col-md-4 col-sm-6">
			<img class="img-responsive" src="<?= URL::cdn('img/cti.png') ?>" alt="Logotipo do CTI, Centro de Tecnologia da Informação Renato Ancher" width="238" height="90" />
		</div>
		<div class="col-lg-2 col-md-4 col-sm-6">
			<img class="img-responsive" src="<?= URL::cdn('img/naufla.png') ?>" alt="Logotipo do NAUfla, Núclero de Acessibilidade da UFLA" width="238" height="90" />
		</div>
		<div class="col-lg-2 col-md-4 col-sm-6">
			<img class="img-responsive" src="<?= URL::cdn('img/inbatec.png') ?>" alt="Logotipo da Inbatec, Incubadora de Empresas de Base Tecnológica" width="238" height="90" />
		</div>
		<div class="col-lg-2 col-md-4 col-sm-6">
			<img class="img-responsive" src="<?= URL::cdn('img/comp.png') ?>" alt="Logotipo do DCC/UFLA, Departamento de Ciência da Computação da Universidade Federal de Lavras" width="238" height="90" />
		</div>
		<div class="col-lg-2 col-md-4 col-sm-6">
			<img class="img-responsive" src="<?= URL::cdn('img/cenav.png') ?>" alt="Logotipo do Cenav, Centro de Educação e Apoio às Necessidades Auditivas e Visuais" width="238" height="90" />
		</div>
	</div>
</section>
<?php HTML::end_block() ?>
