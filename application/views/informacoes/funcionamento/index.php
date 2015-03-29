<section id="conteudo-principal" class="container" role="main">
	<header class="page-header">
		<h1><i class="glyphicon glyphicon-cog"></i> Funcionamento do AudioWeb</h1>
	</header>
	<?= Helper_Trilha::exibir($trilha) ?>
	<div class="row">
		<div class="col-lg-12">

			<div class="panel-group" id="funcionamento" role="tablist" aria-multiselectable="true">

				<div class="panel panel-default">
					<div class="panel-heading" role="tab" id="cabecalho-como-usar">
						<h2 class="panel-title">
							<a data-toggle="collapse" data-parent="#funcionamento" href="#ajuda-como-usar" aria-expanded="false" aria-controls="ajuda-como-usar">
								Como usar o AudioWeb?
							</a>
						</h2>
					</div>
					<div id="ajuda-como-usar" class="panel-collapse collapse" role="tabpanel" aria-labelledby="cabecalho-como-usar">
						<div class="panel-body">
							<p>O primeiro passo é se cadastrar no AudioWeb, através do link Cadastre­se, localizada na barra de menu principal. Após acessar a página de cadastro, é preciso que o usuário preencha os seus dados, que são o nome, e­mail e senha. Além disso, é preciso que o usuário assinale explicitamente que concorda com a licença gratuita de uso do AudioWeb e com a sua política de privacidade.</p>
						</div>
					</div>
				</div>

				<div class="panel panel-default">
					<div class="panel-heading" role="tab" id="cabecalho-como-funciona">
						<h2 class="panel-title">
							<a data-toggle="collapse" data-parent="#funcionamento" href="#ajuda-como-funciona" aria-expanded="false" aria-controls="ajuda-como-funciona">
								Como funciona o AudioWeb?
							</a>
						</h2>
					</div>
					<div id="ajuda-como-funciona" class="panel-collapse collapse" role="tabpanel" aria-labelledby="cabecalho-como-funciona">
						<div class="panel-body">
							<p>Há dois tipos de usuários no AudioWeb: o que prepara o material digital para ser ouvido pelo usuário com deficiência visual, ou seja, o usuário preparador; e aquele que utiliza o material preparado, isto é, o usuário ouvidor. No caso, do AudioImagem, o usuário preparador seleciona uma imagem, delimita ou marca uma ou mais áreas dentro da imagem, descreve cada uma delas textualmente e o AudioImagem salva tudo e gera os áudios falados de descrição da imagem e de suas áreas marcadas. Uma vez preparada a imagem, pelo usuário preparador, ela está pronta para ser vista, interagida e ouvida pelo usuário ouvidor. Para tanto, o usuário com deficiência visual precisa entrar no AudioWeb, com login e senha, escolher o módulo AudioImagem, e selecionar uma imagem para ser ouvida a partir de uma lista de imagens, já preparadas previamente. Ao selecionar uma delas, ele poderá interagir e ouvir a imagem escolhida.</p>
						</div>
					</div>
				</div>

				<div class="panel panel-default">
					<div class="panel-heading" role="tab" id="cabecalho-como-interagir">
						<h2 class="panel-title">
							<a data-toggle="collapse" data-parent="#funcionamento" href="#ajuda-como-interagir" aria-expanded="false" aria-controls="ajuda-como-interagir">
								Como faço para interagir e ouvir as áreas marcadas de uma imagem?
							</a>
						</h2>
					</div>
					<div id="ajuda-como-interagir" class="panel-collapse collapse" role="tabpanel" aria-labelledby="cabecalho-como-interagir">
						<div class="panel-body">
							<p>A interação é feita mexendo-se o ponteiro do cursor, a setinha, sobre a imagem, movendo o mouse, ou movendo uma caneta sobre uma mesa digitalizadora (tablet de desenho), ou ainda movendo o dedo sobre um monitor com tela touch-screen. Quando a setinha está sobre uma área marcada, o AudioImagem fala a descrição curta da área marcada, ou seja, audiodescreve aquela área. É importante que o computador esteja com os alto-falantes ou fones de ouvidos ligados para que o usuário possa ouvir as audiodescrições da imagem.</p>
						</div>
					</div>
				</div>

				<div class="panel panel-default">
					<div class="panel-heading" role="tab" id="cabecalho-mover-seta">
						<h2 class="panel-title">
							<a data-toggle="collapse" data-parent="#funcionamento" href="#ajuda-mover-seta" aria-expanded="false" aria-controls="ajuda-mover-seta">
								Como mexer a setinha sobre a imagem, se não a vejo?
							</a>
						</h2>
					</div>
					<div id="ajuda-mover-seta" class="panel-collapse collapse" role="tabpanel" aria-labelledby="cabecalho-mover-seta">
						<div class="panel-body">
							<p>O AudioImagem fala várias mensagens e emite alguns sons que avisam a onde a setinha se encontra no momento. Se a setinha for movida para a esquerda da imagem, o AudioImagem irá falar: "À esquerda da imagem". Se o usuário mover a setinha para cima da imagem, ouvirá: "Acima da imagem", e assim por diante. Se deixar a setinha parada, sem movê-la, e apertar a tecla <kbd><?= $teclas['falar_posicao']['tecla'] ?></kbd>, o AudioImagem irá falar a posição em que a setinha se encontra, dentro e fora da imagem. Por exemplo, "Dentro, abaixo e à direita da imagem", "Dentro e no centro da imagem", "À direita e acima da imagem", e assim por diante.</p>
						</div>
					</div>
				</div>

				<div class="panel panel-default">
					<div class="panel-heading" role="tab" id="cabecalho-alternar-modos">
						<h2 class="panel-title">
							<a data-toggle="collapse" data-parent="#funcionamento" href="#ajuda-alternar-modos" aria-expanded="false" aria-controls="ajuda-alternar-modos">
								Como ajustar a figura no meio da tela, para poder ouvi-la, se não a vejo?
							</a>
						</h2>
					</div>
					<div id="ajuda-alternar-modos" class="panel-collapse collapse" role="tabpanel" aria-labelledby="cabecalho-alternar-modos">
						<div class="panel-body">
							<p>O AudioImagem permite mostrar a imagem no maior tamanho possível apertando a tecla <kbd><?= $teclas['alternar_modo_exibicao']['tecla'] ?></kbd>, que alterna entre o modo vidente e o modo cego. Quando o usuário aperta a tecla <kbd><?= $teclas['alternar_modo_exibicao']['tecla'] ?></kbd>, o AudioImagem fala: "Modo Cego" ou "Modo Vidente", avisando para qual modo mudou. No modo vidente, caso o usuário clique na imagem, o AudioWeb centraliza a imagem para que possa ser navegada e ouvida pelo usuário vidente, embora sem aumentar o tamanho da imagem.</p>
						</div>
					</div>
				</div>

				<div class="panel panel-default">
					<div class="panel-heading" role="tab" id="cabecalho-falar-descricoes">
						<h2 class="panel-title">
							<a data-toggle="collapse" data-parent="#funcionamento" href="#ajuda-falar-descricoes" aria-expanded="false" aria-controls="ajuda-falar-descricoes">
								Como ouvir a descrição da imagem como um todo?
							</a>
						</h2>
					</div>
					<div id="ajuda-falar-descricoes" class="panel-collapse collapse" role="tabpanel" aria-labelledby="cabecalho-falar-descricoes">
						<div class="panel-body">
							<p>O AudioImagem fala duas audiodescrições de uma imagem como um todo, sem necessidade de mexer a setinha. Quando o usuário aperta a tecla <kbd><?= $teclas['falar_nome_imagem']['tecla'] ?></kbd>, o AudioImagem fala a descrição curta da imagem; e a a tecla <kbd><?= $teclas['falar_descricao_imagem']['tecla'] ?></kbd>, a descrição longa da imagem como um todo.</p>
						</div>
					</div>
				</div>

				<div class="panel panel-default">
					<div class="panel-heading" role="tab" id="cabecalho-leitor-tela">
						<h2 class="panel-title">
							<a data-toggle="collapse" data-parent="#funcionamento" href="#ajuda-leitor-tela" aria-expanded="false" aria-controls="ajuda-leitor-tela">
								Preciso desligar meu leitor de tela quando uso AudioWeb?
							</a>
						</h2>
					</div>
					<div id="ajuda-leitor-tela" class="panel-collapse collapse" role="tabpanel" aria-labelledby="cabecalho-leitor-tela">
						<div class="panel-body">
							<p>Essa é uma questão que ainda não sabemos bem, nem temos certeza. A sua ajuda neste ponto como usuário é importante para a equipe do AudioWeb. Testamos com alguns leitores de tela, como Jaws, Nvda e Orca. Teoricamente, o leitor de tela deveria ser desligado quando o usuário escolhe uma imagem para ouvir, pois é o próprio AudioWeb que gera os sons e as audiodescrições da imagem e de suas áreas marcadas. Notamos que alguns textos de descrição das áreas marcadas são lidos pelos leitores de tela, no entanto, a dupla audiodescrição acaba atrapalhando a audição correta das áreas.</p>
						</div>
					</div>
				</div>

				<div class="panel panel-default">
					<div class="panel-heading" role="tab" id="cabecalho-borda-imagem">
						<h2 class="panel-title">
							<a data-toggle="collapse" data-parent="#funcionamento" href="#ajuda-borda-imagem" aria-expanded="false" aria-controls="ajuda-borda-imagem">
								Como saber a onde está a borda da imagem?
							</a>
						</h2>
					</div>
					<div id="ajuda-borda-imagem" class="panel-collapse collapse" role="tabpanel" aria-labelledby="cabecalho-borda-imagem">
						<div class="panel-body">
							<p>O AudioImagem emite um som que avisa que a setinha está sobre a borda da imagem, é um som Biiii, Biiii, Biiii, intermitente. Se o usuário mover a setinha sobre a borda, ouvindo este bip, ele poderá percorrer toda a borda da imagem e sentir espacialmente onde a imagem se encontra.</p>
						</div>
					</div>
				</div>

				<div class="panel panel-default">
					<div class="panel-heading" role="tab" id="cabecalho-inspecionar-regiao">
						<h2 class="panel-title">
							<a data-toggle="collapse" data-parent="#funcionamento" href="#ajuda-inspecionar-regiao" aria-expanded="false" aria-controls="ajuda-inspecionar-regiao">
								Como saber o tamanho de uma área marcada dentro da imagem?
							</a>
						</h2>
					</div>
					<div id="ajuda-inspecionar-regiao" class="panel-collapse collapse" role="tabpanel" aria-labelledby="cabecalho-inspecionar-regiao">
						<div class="panel-body">
							<p>Quando ao mover a setinha, esta alcançar uma área marcada, o usuário ouvirá imediatamente a sua audiodescrição curta. Caso ele deixe a setinha parada sobre a área marcada, por alguns segundos, o AudioImagem passa a emitir um bip seco, Túc, Túc, Túc, que continuará a ser emitido enquanto a setinha estiver sobre a área marcada. Assim, ouvindo esse bip seco, o usuário poderá mover a setinha sobre a área marcada e saber que continua sobre aquela área marcada, podendo então perceber espacialmente o tamanho daquela área marcada. Caso o usuário se esqueça da descrição curta da área marcada, basta clicar sobre ela ou digitar <kbd><?= $teclas['falar_nome_regiao']['tecla'] ?></kbd> que a descrição curta é repetida novamente. Para ouvir a descrição longa da região, faça um duplo clique sobre a região ou digite <kbd><?= $teclas['falar_descricao_regiao']['tecla'] ?></kbd>.</p>
						</div>
					</div>
				</div>

			</div>
		</div>
	</div>
</section>