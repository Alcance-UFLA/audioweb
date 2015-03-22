<section id="conteudo-principal" class="container" role="main">
	<header class="page-header">
		<h1><i class="glyphicon glyphicon-globe"></i> Institucional</h1>
	</header>
	<?= Helper_Trilha::exibir($trilha) ?>
	<div class="row">
		<div class="col-lg-12">
			<h2>Desenvolvedores e Parceiros</h2>
			<p>//TODO Figuras das logomarcas: Alcance, Polaris, CNPq, CNRTA, Inbatec, UFLA, NAUFLA, CENAV e DCC, com destaque para as duas primeiras (Polaris e Alcance)</p>

			<h2>Perguntas e Respostas</h2>
			<dl>
				<dt>Quem está desenvolvendo o AudioWeb?</dt>
				<dd>O núcleo de pesquisas Alcance e a empresa Polaris. O Alcance é o Núcleo de Pesquisas em Acessibilidade, Usabilidade e Tecnologia Assistiva, apoiado pelo CNPq, e integrante da rede nacional de núcleos de pesquisas do CNRTA, que é o Centro de Nacional de Referência em Tecnologia Assistiva. A Polaris Inovações em Soluções Web é uma empresa incubada na Inbatec/UFLA, a Incubadora de Empresas de Base Tecnológica da Universidade Federal de Lavras, ao sul de Minas Gerais. O AudioWeb é o produto que está sendo desenvolvido pelo núcleo Alcance, em estreita parceria com a empresa Polaris.</dd>

				<dt>Como nasceu o projeto?</dt>
				<dd>Na experiência de ensino de um aluno com deficiência visual, a partir de 2007, baseada na seguinte ideia: se um leitor de tela pode ler textos, porque não imagens? A empresa Polaris Inovações em Soluções Web foi fundada, em 2011, para desenvolver essa tecnologia assistiva.</dd>

				<dt>Porque demorou tanto a ser desenvolvido?<dt>
				<dd>Devido a dois motivos principais: a imaturidade do projeto, e a falta de apoio, principalmente o financeiro. A equipe da empresa Polaris e depois do núcleo Alcance, foi gradualmente descobrindo como o sistema deveria ser, e o primeiro apoio financeiro foi obtido somente três anos depois, no início de 2014, em edital de tecnologia assistiva do CNPq, que tinha como o objetivo a criação e consolidação de núcleos de pesquisas em tecnologia assistiva. Com o amadurecimento do projeto, percebeu-se que o AudioImagem deveria se tornar uma parte do AudioWeb, um sistema maior que engloba a audiodescrição de textos, imagens e fórmulas matemáticas.</dd>

				<dt>O AudioWeb está pronto?<dt>
				<dd>Não. Somente o módulo AudioImagem está construído, e mesmo assim precisando de várias melhorias. Os módulos AudioFormula e AudioAula ainda estão sendo desenvolvidos. O AudioAula deverá estar pronto em junho de 2015, e o AudioFormula em setembro de 2015.</dd>

				<dt>O AudioImagem está pronto?</dt>
				<dd>Também não. O AudioImagem está em fase de aperfeiçoamento (versão beta). Por causa disso, optamos por fazer com que todas as fotos e imagens preparadas no AudioWeb possam ser vistas, ouvidas e alteradas por todos os demais usuários do AudioWeb. Numa versão posterior, as figuras e fotos continuarão a poder ser vistas e ouvidas por todos, mas somente quem preparou uma imagem poderá alterá-la.<dd>

				<dt>Quem tem auxiliado no desenvolvimento do AudioWeb?<dt>
				<dd>Além dos desenvolvedores (o Alcance e a Polaris), sua equipe conta com o apoio e/ou parceira do CNPq, CNRTA, Inbatec/UFLA, Núcleo de Acessibilidade da UFLA (NAUfla), Centro de Educação e Apoio às Necessidades Auditivas e Visuais (CENAV), e o Departamento de Ciência da Computação da UFLA (DCC/UFLA).</dd>

				<dt>Estes apoios são suficientes para completar o AudioWeb?</dt>
				<dd>Não. Mais do que nunca, a equipe do AudioWeb precisa do apoio dos usuários, tantos dos que têm deficiência visual como daqueles que os auxiliam no dia-a-dia. A equipe do AudioWeb acredita que somente na interação com os usuários é que o AudioWeb poderá ser melhorado e completado. Afinal, AudioWeb está sendo feito para estes usuários, logo o seu funcionamento deve ser guiado por suas necessidades.</dd>

				<dt>Posso ajudar a melhorar o AudioWeb?</dt>
				<dd>Sim. A melhor forma de ajudar é usar o AudioWeb e depois comentar sobre o que conseguiu fazer, e o que não conseguiu fazer; contar as suas dificuldades no uso do AudioWeb, criticar e sugerir possíveis melhorias; além de sugerir o que gostariam que o AudioWeb fizesse para auxiliá-los em suas atividades acadêmicas e profissionais.</dd>

				<dt>Onde posso comentar sobre o AudioWeb?<dt>
				<dd>Ao final desse texto há um formulário de contato simples, em que o usuário pode preencher, comentando, criticando e sugerindo ideias novas. Além desse formulário, os usuários estão convidados a se juntar ao Grupo AudioWeb, no facebook. Por meio dele, os usuários poderão interagir não somente com a equipe de desenvolvimento, mas também com todos os demais usuários, podendo levantar e discutir os problemas no uso do AudioWeb, e suas possíveis soluções.</dd>

				<dt>O que preciso fazer para usar o AudioWeb?</dt>
				<dd>É simples. Primeiro, é necessário se cadastrar no AudioWeb, através do link Cadastre-se. Após acessar a página de cadastro, é preciso que o usuário preencha os seus dados, que são o seu nome, seu e-mail e sua senha. Além disso, é preciso que o usuário assinale explicitamente que concorda com a licença de uso gratuita, e com a política de privacidade do AudioWeb. Link <a href="<?= Route::url('acao_padrao', array('directory' => 'usuario', 'controller' => 'cadastrar')) ?>">Cadastre-se</a>.</dd>
			</dl>

			<p>//TODO Form de contato</p>
		</div>
	</div>
</section>


