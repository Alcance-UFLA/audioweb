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
			<img class="img-responsive" src="<?= URL::cdn('img/alcance.png') ?>" alt="Logotipo do Alcance, Núcleo de Pesquisas em Acessibilidade, Usabilidade e Tecnologia Assistiva" width="453" height="200" />
		</div>
	</div>
	<div class="row">
		<div class="col-lg-12">
			<p>O projeto AudioWeb é uma realização da empresa <a href="http://www.polarisweb.com.br">Polaris Inovações em Soluções Web</a> e do núcleo de pesquisas Alcance. Polaris é uma empresa de base tecnológica fundada para inovar na web com soluções para educação inclusiva, organização de eventos, comércio e marketing online; e está sendo incubada na <abbr title="Incubadora de Empresas de Base Tecnológica">Inbatec</abbr>/<abbr title="Universidade Federal de Lavras">UFLA</abbr>, a Incubadora de Empresas de Base Tecnológica da Universidade Federal de Lavras, que se localiza no sul de Minas Gerais. Alcance é o Núcleo de Pesquisas em Acessibilidade, Usabilidade e Tecnologia Assistiva, apoiado pelo <abbr title="Conselho Nacional de Desenvolvimento Científico e Tecnológico">CNPq</abbr>, e integrante da rede nacional de núcleos de pesquisas do CNRTA, que é o Centro de Nacional de Referência em Tecnologia Assistiva.</p>
			<p>Este projeto nasceu da observação do processo de ensino e aprendizagem de um aluno com deficiência visual, a partir de 2007, e baseou-se na seguinte ideia: se um leitor de tela pode ler textos, porque não imagens? A empresa Polaris foi fundada, em 2011, para desenvolver essa tecnologia assistiva e enfrentou diversos desafios, dentre eles: a imaturidade do projeto e a falta de apoio, principalmente o financeiro. A equipe da empresa Polaris e depois ampliada com o núcleo Alcance, foi descobrindo gradualmente como o sistema deveria funcionar, e o primeiro apoio financeiro foi obtido somente três anos depois, no início de 2014, em edital de tecnologia assistiva do <abbr title="Ministério da Ciência, Tecnologia e Inovação">MCTI</abbr>/<abbr title="Secretaria de Ciência e Tecnologia para Inclusão Social ">SECIS</abbr>/<abbr title="Conselho Nacional de Desenvolvimento Científico e Tecnológico">CNPq</abbr>. Este edital tinha como objetivo a criação e consolidação de núcleos de pesquisas em tecnologia assistiva, dando origem ao Núcleo Alcance. Com o amadurecimento do projeto, percebeu-se que o AudioImagem deveria se tornar uma das partes do AudioWeb, um sistema maior que engloba a audiodescrição de textos, imagens e fórmulas matemáticas.</p>
			<p>O AudioWeb não está pronto ainda. Somente o módulo AudioImagem está construído, e mesmo assim precisando de várias correções e melhorias. Os módulos AudioFormula e AudioAula estão sendo desenvolvidos. O AudioAula deverá estar pronto em junho de 2015, e o AudioFórmula em setembro de 2015. Caso queira ajudar a equipe do AudioWeb, ouça a página do link <a href="<?= Route::url('acao_padrao', array('directory' => 'informacoes', 'controller' => 'ajudar')) ?>">Quero Ajudar</a>. E caso deseje usar o AudioWeb, ouça antes a página do link <a href="<?= Route::url('acao_padrao', array('directory' => 'informacoes', 'controller' => 'funcionamento')) ?>">Funcionamento</a>. Caso queira entrar em contato conosco, utilize os contatos abaixo.</p>
			<p>
				<b>Empresa Polaris</b>
				<ul>
					<li>Telefone: <a href="tel:03538221133">(35) 3822-1133</a></li>
					<li>E-mail: <a href="mailto:comercial@polarisweb.com.br">comercial@polarisweb.com.br</a></li>
				</ul>
			</p>
			<p>
				<b>Núcleo Alcance</b>
				<ul>
					<li>Telefone: <a href="tel:03538291539">(35) 3829-1539</a> / <a href="tel:03538291536">3829-1536</a></li>
					<li>E-mail: <a href="mailto:monserrat@dcc.ufla.br">monserrat@dcc.ufla.br</a> / <a href="mailto:apfreire@dcc.ufla.br">apfreire@dcc.ufla.br</a></li>
				</ul>
			</p>

		</div>
	</div>
	<div class="row">
		<div class="col-md-4 col-sm-6">
			<img class="img-responsive" src="<?= URL::cdn('img/cnrta.png') ?>" alt="Logotipo do CNRTA, Centro de Nacional de Referência em Tecnologia Assistiva" width="238" height="90" />
		</div>
		<div class="col-md-4 col-sm-6">
			<img class="img-responsive" src="<?= URL::cdn('img/cnpq.png') ?>" alt="Logotipo do CNPq, Conselho Nacional de Desenvolvimento Científico e Tecnológico" width="238" height="90" />
		</div>
		<div class="col-md-4 col-sm-6">
			<img class="img-responsive" src="<?= URL::cdn('img/naufla.png') ?>" alt="Logotipo do NAUfla, Núclero de Acessibilidade da UFLA" width="238" height="90" />
		</div>
		<div class="col-md-4 col-sm-6">
			<img class="img-responsive" src="<?= URL::cdn('img/cenav.png') ?>" alt="Logotipo do Cenav, Centro de Educação e Apoio às Necessidades Auditivas e Visuais" width="238" height="90" />
		</div>
		<div class="col-md-4 col-sm-6">
			<img class="img-responsive" src="<?= URL::cdn('img/inbatec.png') ?>" alt="Logotipo da Inbatec, Incubadora de Empresas de Base Tecnológica" width="238" height="90" />
		</div>
		<div class="col-md-4 col-sm-6">
			<img class="img-responsive" src="<?= URL::cdn('img/comp.png') ?>" alt="Logotipo do DCC/UFLA, Departamento de Ciência da Computação da Universidade Federal de Lavras" width="238" height="90" />
		</div>
		<div class="col-md-4 col-sm-6">
			<img class="img-responsive" src="<?= URL::cdn('img/mcti.png') ?>" alt="Logotipo do MCTI, Ministério da Ciência, Tecnologia e Inovação" width="238" height="90" />
		</div>
		<div class="col-md-4 col-sm-6">
			<img class="img-responsive" src="<?= URL::cdn('img/mec.png') ?>" alt="Logotipo do MEC, Ministério da Educação" width="238" height="90" />
		</div>
		<div class="col-md-4 col-sm-6">
			<img class="img-responsive" src="<?= URL::cdn('img/ufla.png') ?>" alt="Logotipo da UFLA, Universidade Federal de Lavras" width="238" height="90" />
		</div>
	</div>
</section>
<?php HTML::end_block() ?>
