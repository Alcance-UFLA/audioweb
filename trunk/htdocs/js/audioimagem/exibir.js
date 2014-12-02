$(document).ready(function(){

	ajustar_modo_exibicao();
	ajustar_proporcao_mapa();

	/**
	 * Evento quando a janela muda de tamanho
	 */
	$(window).resize(ajustar_modo_exibicao);

	/**
	 * Botao de alternar modo de exibicao
	 */
	var botao_modo_exibicao = $('<button type="button" id="botao-alternar-modo-exibicao" class="btn btn-lg btn-default"><i class="glyphicon glyphicon-fullscreen"></i> Alternar modo de exibição</button>');
	botao_modo_exibicao.click(function(){
		var imagem = $("#imagem");
		$("#imagem").data("moveu-mouse", false);
		if (imagem.data("modo-exibicao") == "vidente") {
			imagem.data("modo-exibicao", "cego");
			if (imagem.data("sintetizador").length > 0) {
				$("#conteudo-auxiliar #audio-modo-cego").trigger("play");
			}
		} else {
			imagem.data("modo-exibicao", "vidente");
			if (imagem.data("sintetizador").length > 0) {
				$("#conteudo-auxiliar #audio-modo-vidente").trigger("play");
			}
		}
		$("head link[title='Modo']").remove();
		var modo = imagem.data("modo-exibicao");
		var style = $('<link title="Modo" rel="stylesheet" href="' + $("body").data("url-base") + 'css/audioimagem/modo-' + modo + '.min.css" />');
		$("head").append(style);
		style.load(ajustar_modo_exibicao);
	});
	$("#area-botoes").append(botao_modo_exibicao);


	/**
	 * Evento ao clicar na imagem
	 */
	$("#imagem").click(function(){
		$("html, body").animate({"scrollTop": $(this).offset().top - $("#navbar-pagina").height() - 1}, 1000);
	});

	/**
	 * Evento quando o mouse entra na imagem
	 */
	$("#imagem").mouseenter(function(e){
		$(this).data("mouse-dentro", true);
	});

	/**
	 * Evento quando o mouse sai da imagem
	 */
	$("#imagem").mouseleave(function(e){
		$(this).data("mouse-dentro", false);

		// Determinar por onde mouse saiu
		if ($(this).data("moveu-mouse") && $(this).data("sintetizador").length > 0) {
			$(this).data("moveu-mouse", false);
			if (e.pageX < $(this).offset().left) {
				$("#conteudo-auxiliar #audio-saiu-esquerda").trigger("play");
			} else if (e.pageX > $(this).offset().left + $(this).width()) {
				$("#conteudo-auxiliar #audio-saiu-direita").trigger("play");
			} else if (e.pageY < $(this).offset().top) {
				$("#conteudo-auxiliar #audio-saiu-cima").trigger("play");
			} else if (e.pageY > $(this).offset().top + $(this).height()) {
				$("#conteudo-auxiliar #audio-saiu-baixo").trigger("play");
			}
		}
	});

	/**
	 * Evento quando o mouse move
	 */
	$(window).mousemove(function(e){
		$("#imagem").data("moveu-mouse", true);
	});

	// Para cada area do mapa
	$("#mapa-regioes area").each(function(){

		// Associar aos dados da regiao coorespondente
		$(this).data("dados-regiao", $("#regioes #regiao-" + $(this).data("id-imagem-regiao")));

		/**
		 * Evento quando o mouse entrar em uma regiao
		 */
		$(this).mouseenter(function(){
			var area          = $(this);
			var imagem        = $("#imagem");
			var regioes       = $("#regioes");
			var regiao        = area.data("dados-regiao");
			var regiao_falada = regioes.find(".regiao.falada");
			var lista_regioes = regioes.find(".panel-body");

			regiao.addClass("ativa");
			lista_regioes.animate({"scrollTop": regiao.offset().top - lista_regioes.find(".regiao").offset().top}, 1000);
			if (regiao_falada.attr("id") != regiao.attr("id")) {
				regiao_falada.removeClass("falada");
			}

			if (imagem.data("sintetizador").length > 0) {
				if (regiao.hasClass("falada")) {
					$("#conteudo-auxiliar #audio-bip").trigger("play");
				} else {
					regiao.find(".audio-nome").trigger("play");
				}
			}
		});

		/**
		 * Evento quando o mouse sair de uma regiao
		 */
		$(this).mouseleave(function(){
			var imagem       = $("#imagem");
			var regioes      = $("#regioes");
			var regiao_ativa = regioes.find(".regiao.ativa");

			regiao_ativa.removeClass("ativa");

			if (imagem.data("sintetizador").length > 0) {
				regiao_ativa.find("audio").trigger("pause").prop("currentTime", 0);
				$("#conteudo-auxiliar #audio-bip").trigger("pause");
			}
		});
	});

	/**
	 * Evento quando o audio de uma descricao curta ou longa termina
	 */
	$("#regioes .regiao .audio-nome, #regioes .regiao .audio-descricao").on("ended", function(){
		var audio        = $(this);
		var bip          = $("#conteudo-auxiliar #audio-bip");
		var regiao_ativa = $("#regioes .regiao.ativa");

		audio.prop("currentTime", 0);
		if (regiao_ativa.length > 0) {
			regiao_ativa.addClass("falada");
			bip.trigger("play");
		}
	});

	/**
	 * Evento ao pausar o bip
	 */
	$("#conteudo-auxiliar #audio-bip").on("pause", function(){
		$(this).prop("currentTime", 0);
	});

	/**
	 * Eventos relacionados ao teclado
	 */
	$(document).keypress(function(e){

		/*
		 * Montar objeto para facilitar acesso as teclas de atalho, conforme exemplo:
		 * {
		 *     "falar_nome_regiao": 99,
		 *     "falar_descricao_regiao": 108
		 * }
		 */
		var teclas = $("#teclas").data("teclas");
		if (!teclas) {
			var lista_teclas = $("#teclas").find(".tecla");
			teclas = new Object();
			for (var i = 0; i < lista_teclas.length; i++) {
				var tecla = lista_teclas[i];
				teclas[$(tecla).data("nome")] = $(tecla).data("codigo");
			}
			$("#teclas").data("teclas", teclas);
		}

		switch (e.which) {
		case teclas.falar_ajuda:
			$("#conteudo-auxiliar #audio-ajuda").trigger("play");
			break;
		case teclas.falar_dados_imagem:
			$("#conteudo-auxiliar #audio-dados-imagem").trigger("play");
			break;
		case teclas.falar_nome_regiao:
			var imagem       = $("#imagem");
			var regioes      = $("#regioes");
			var regiao_ativa = regioes.find(".regiao.ativa")

			if (imagem.data("sintetizador").length > 0 && regiao_ativa.length > 0) {
				regiao_ativa.find("audio").trigger("pause").prop("currentTime", 0);
				$("#conteudo-auxiliar #audio-bip").trigger("pause");

				if (regiao_ativa.length > 0) {
					regiao_ativa.find(".audio-nome").trigger("play");
				}
			}
			break;
		case teclas.falar_descricao_regiao:
			var imagem       = $("#imagem");
			var regioes      = $("#regioes");
			var regiao_ativa = regioes.find(".regiao.ativa")

			if (imagem.data("sintetizador").length > 0 && regiao_ativa.length > 0) {
				regiao_ativa.find("audio").trigger("pause").prop("currentTime", 0);
				$("#conteudo-auxiliar #audio-bip").trigger("pause");

				if (regiao_ativa.length > 0) {
					regiao_ativa.find(".audio-descricao").trigger("play");
				}
			}
			break;
		case teclas.alternar_modo_exibicao:
			$("#botao-alternar-modo-exibicao").click();
			break;
		}
	});
});

/**
 * Ajusta as coordenadas de cada regiao de acordo com o redimensionamento da imagem
 */
function ajustar_proporcao_mapa(){
	var imagem = $("#imagem");
	var mapa = $("#mapa-regioes");
	var proporcao = imagem.width() / imagem.data("largura-original");
	if (mapa.data("proporcao") != proporcao) {
		mapa.data("proporcao", proporcao);
		mapa.find("area").each(function(){
			var proporcao = $("#mapa-regioes").data("proporcao");
			if (proporcao == 1) {
				$(this).attr("coords", $(this).data("coords-original"));
			} else {
				var coords = $(this).data("coords-original").split(",");
				var coords_ajustado = new Array();
				for (var i in coords) {
					coords_ajustado.push(Math.round(coords[i] * proporcao));
				}
				$(this).attr("coords", coords_ajustado.join(","));
			}
		});
	}
}

/**
 * Ajusta o modo de exibicao para vidente ou cego
 */
function ajustar_modo_exibicao() {
	var modo = $("#imagem").data("modo-exibicao");
	var altura_navbar = $("#navbar-pagina").height();
	var imagem = $("#imagem");
	var altura = $(window).height() - altura_navbar;
	var largura = imagem.data("largura-original") * altura / imagem.data("altura-original");
	var margem = 1;

	if (largura > imagem.offsetParent().width()) {
		largura = imagem.offsetParent().width();
		altura = imagem.data("altura-original") * largura / imagem.data("largura-original");
		if (imagem.data("modo-exibicao") == "cego") {
			margem = ($(window).height() - altura) / 2;
		}
	}

	altura = Math.round(altura) - 4;
	largura = Math.round(largura) - 4;

	imagem.css({
		"height": altura + "px",
		"width": largura + "px",
		"margin-top": margem + "px",
		"margin-bottom": margem + "px"
	});
	ajustar_proporcao_mapa();
}