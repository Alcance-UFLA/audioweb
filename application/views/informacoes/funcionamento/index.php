<section id="conteudo-principal" class="container" role="main">
	<header class="page-header">
		<h1><i class="glyphicon glyphicon-cog"></i> Funcionamento do AudioWeb</h1>
	</header>
	<?= Helper_Trilha::exibir($trilha) ?>
	<div class="row">
		<div class="col-lg-12">
			<dl>
				<dt>Como funciona o AudioWeb?</dt>
				<dd>Há dois tipos de usuários no AudioWeb: o que prepara o material digital para ser ouvido pelo usuário com deficiência visual, ou seja, o usuário preparador; e aquele que utiliza o material preparado, isto é, o usuário ouvidor. No caso, do AudioImagem, o usuário preparador seleciona uma imagem, delimita uma ou mais áreas dentro da imagem, descreve cada uma delas textualmente e o AudioImagem salva tudo e gera os áudios falados de descrição da imagem e de suas áreas marcadas. Uma vez preparada a imagem, pelo usuário preparador, ela está pronta para ser vista, interagida e ouvida pelo usuário ouvidor. Para tanto, o usuário com deficiência visual precisa entrar no AudioWeb, com login e senha, escolher o módulo AudioImagem, e selecionar uma imagem para ser ouvida a partir de uma lista de imagens, já preparadas previamente. Ao selecionar uma delas, ele poderá interagir e ouvir a imagem escolhida.</dd>

				<dt>Como faço para interagir e ouvir as áreas marcadas de uma imagem?</dt>
				<dd>A interação é feita mexendo-se o ponteiro do cursor, a setinha, sobre a imagem, movendo o mouse, ou movendo uma caneta sobre uma mesa digitalizadora (tablet de desenho), ou ainda movendo o dedo sobre um monitor com tela touch-screen. Quando a setinha está sobre uma área marcada, o AudioImagem fala a descrição curta da área marcada, ou seja, audiodescreve a área. É importante que o computador esteja com os alto-falantes ou fones de ouvidos ligados para que o usuário possa ouvir as audiodescrições da imagem.</dd>

				<dt>Como mexer a setinha sobre a imagem, se não a vejo?</dt>
				<dd>O AudioImagem fala várias mensagens e emite alguns sons que avisam a onde a setinha se encontra no momento. Se a setinha for movida para a esquerda da imagem, o AudioImagem irá falar: “À esquerda da imagem”. Se o usuário mover a setinha para cima da imagem, ouvirá: “Acima da imagem”, e assim por diante. Se deixar a setinha parada, sem movê-la, e apertar a tecla 'P', o AudioImagem irá falar a posição em que a setinha se encontra, dentro e fora da imagem. Por exemplo, “Dentro, abaixo e à direita da imagem”, “Dentro e no centro da imagem”, “À direita e acima da imagem”, e assim por diante.</dd>

				<dt>Como ajustar a figura no meio da tela, para poder ouvi-la, se não a vejo?</dt>
				<dd>O AudioImagem permite mostrar a imagem no maior tamanho possível apertando a tecla 'M', que alterna entre o modo vidente e o modo cego. Quando o usuário aperta a tecla 'M', o AudioImagem fala: “Modo Cego” ou “Modo Vidente”, avisando para qual modo mudou. No modo vidente, caso o usuário clique na imagem, o AudioWeb centraliza a imagem para que possa ser navegada e ouvida pelo usuário vidente, embora sem aumentar o tamanho da imagem.</dd>

				<dt>Como saber a onde está a borda da imagem?</dt>
				<dd>O AudioImagem emite um som que avisa que a setinha está sobre a borda da imagem, é um som Biiii, Biiii, Biiii, intermitente. Se o usuário mover a setinha sobre a borda, ouvindo este bip, ele poderá percorrer toda a borda da imagem e sentir espacialmente onde a imagem se encontra.</dd>

				<dt>Como ouvir a descrição da imagem como um todo?</dt>
				<dd>O AudioImagem fala duas audiodescrições de uma imagem como um todo, sem necessidade de mexer a setinha. Quando o usuário aperta a tecla 'C', o AudioImagem fala a descrição curta da imagem; e a a tecla 'L', a descrição longa da imagem como um todo.</dd>

				<dt>Como saber o tamanho de uma área marcada dentro da imagem?<dt>
				<dd>Quando ao mover a setinha, esta alcançar uma área marcada, o usuário ouvirá imediatamente a sua audiodescrição curta. Caso ele deixe a setinha parada sobre a área marcada, por alguns segundos, o AudioImagem passa a emitir um bip seco, Túc, Túc, Túc, que continuará a ser emitido enquanto a setinha estiver sobre a área marcada. Assim, ouvindo esse bip seco, o usuário poderá mover a setinha sobre a área marcada e saber que continua sobre aquela área marcada, podendo então perceber espacialmente o tamanho daquela área marcada. Caso o usuário se esqueça da descrição curta da área marcada, basta clicar sobre ela que a descrição curta é repetida novamente.</dd>
			</dl>
		</div>
	</div>
</section>