<?php HTML::start_block() ?>
<section id="conteudo-principal" role="main">
	<header class="jumbotron" itemscope="itemscope" itemtype="http://schema.org/Brand">
		<div class="container">
			<div id="apresentacao-audioweb" class="row">
				<div class="col-md-4 text-center">
					<img alt="Logotipo do AudioWeb" longdesc="<?= Route::url('default') ?>#apresentacao-audioweb" src="<?= URL::cdn('img/logo.png') ?>" width="320" height="153" class="img-responsive center-block" itemprop="logo" />
				</div>
				<div class="col-md-8">
					<?= HTML::header('Bem vindo ao <em itemprop="name">AudioWeb</em>') ?>
					<p class="lead">A Web que fala com você&hellip;</p>
				</div>
			</div>
		</div>
	</header>
	<div class="container">
		<div class="row margem-inferior">
			<div class="col-md-8 col-md-offset-2">
				<div class="pannel">
				<p class="lead">O AudioWeb é um sistema que visa tornar um pedacinho da Web um pouco mais acessível a todos os públicos, através da exposição de materiais digitalizados de forma falada, tais como textos, figuras, gráficos, tabelas, diagramas, símbolos e expressões matemáticas.</p>
				<p>O AudioWeb é uma realização da empresa <a href="http://www.polarisweb.com.br/">Polaris</a> e do núcleo Alcance. A Polaris Inovações em Soluções Web é uma empresa de base tecnológica fundada para criar inovações para educação, comércio e marketing online, incubada na Inbatec/UFLA, ao sul de Minas Gerais. O Alcance é o Núcleo de Pesquisas em Acessibilidade, Usabilidade e Tecnologia Assistiva, integrante da rede nacional de núcleos de pesquisas em tecnologia assistiva do <abbr title="Centro Nacional de Referência em Tecnologia Assistiva">CNRTA</abbr>.</p>
				<p>O AudioWeb é composto de 3 módulos: AudioImagem, AudioFórmula e AudioAula. Adiante, apresenta­-se uma descrição resumida deles.</p>
				</div>
			</div>
		</div>

		<div id ="caracteristicas" class="row">

			<div class="col-md-4">
				<?php HTML::start_block() ?>
				<article class="panel panel-1" itemscope="itemscope" itemtype="http://schema.org/WebPageElement">
					<header class="panel-heading" itemprop="headline">
						<?= HTML::start_header(array('class' => 'panel-title')) ?>
							<i class="glyphicon glyphicon-picture"></i> <span itemprop="name">AudioImagem</span>
						<?= HTML::end_header() ?>
					</header>
					<div class="panel-body" itemprop="text">
						<p>O <em>AudioImagem</em> é um módulo que permite o mapeamento audiodescrito de imagens, fotos, gráficos, diagramas, figuras de modo de geral. Não somente da imagem como um todo, mas de suas diversas áreas internas, que estão dentro de uma imagem. Uma vez mapeadas e audiodescritas, o AudioImagem permite que os usuários, com ou sem deficiência visual, possam interagir e ouvir as imagens. Este módulo está pronto para ser usado.</p>
					</div>
				</article>
				<?php HTML::end_block() ?>
			</div>

			<div class="col-md-4">
				<?php HTML::start_block() ?>
				<article class="panel panel-2" itemscope="itemscope" itemtype="http://schema.org/WebPageElement">
					<header class="panel-heading" itemprop="headline">
						<?= HTML::start_header(array('class' => 'panel-title')) ?>
							<i class="glyphicon glyphicon-formula"></i> <span itemprop="name">AudioFórmula</span>
						<?= HTML::end_header() ?>
					</header>
					<div class="panel-body" itemprop="text">
						<p>O <em>AudioFórmula</em> é um módulo que permite editar e audiodescrever fórmulas matemáticas, desde símbolos matemáticos simples até fórmulas matemáticas complexas, como somatório, derivada e integral. Uma vez editadas, o AudioFormula permite que os usuários, com ou sem deficiência visual, possam ouvir e compreender corretamente as fórmulas matemáticas. Este módulo ainda não está pronto.</p>
					</div>
				</article>
				<?php HTML::end_block() ?>
			</div>

			<div class="col-md-4">
				<?php HTML::start_block() ?>
				<article class="panel panel-3" itemscope="itemscope" itemtype="http://schema.org/WebPageElement">
					<header class="panel-heading" itemprop="headline">
						<?= HTML::start_header(array('class' => 'panel-title')) ?>
							<i class="glyphicon glyphicon-education"></i> <span itemprop="name">AudioAula</span>
						<?= HTML::end_header() ?>
					</header>
					<div class="panel-body" itemprop="text">
						<p>O <em>AudioAula</em> é um módulo que permite editar aulas com textos, imagens e fórmulas matemáticas, combinando­os em diversas seções para compor aulas em uma determinada disciplina. Uma vez preparadas, o AudioAula permite que os usuários, com ou sem deficiência visual, possam acessar os materiais didáticos contendo textos, imagens e fórmulas audiodescritas, e ouvi-­los de maneira interativa, ágil e amigável. Este módulo ainda não está pronto.</p>
					</div>
				</article>
				<?php HTML::end_block() ?>
			</div>

		</div>
	</div>
</section>
<?php HTML::end_block() ?>
