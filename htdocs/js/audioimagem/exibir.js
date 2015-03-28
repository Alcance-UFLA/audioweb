$(document).ready(function(){
	carregar_recursos_pagina();
});

/**
 * Carrega os recursos da pagina
 */
function carregar_recursos_pagina() {
	var audios = $("audio");

	if (audios.length > 0) {
		var modal_carregamento = $('<div id="modal-carregamento" class="modal fade"><div class="modal-dialog"><div class="modal-content"><div class="modal-header"><button type="button" class="close" data-dismiss="modal" aria-label="Fechar"><span aria-hidden="true">&times;</span></button><h1 class="modal-title h4">Carregando</h1></div><div class="modal-body"><div id="barra-carregamento" class="progress"><div class="progress-bar" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%;" aria-live="polite">0%</div></div></div></div></div></div>');
		modal_carregamento.data("total", audios.length);
		modal_carregamento.data("carregados", 0);
		modal_carregamento.data("tocou-aviso-carregando", false);
		$("body").append(modal_carregamento);
		modal_carregamento.modal("show");

		var timer = window.setInterval(
			function(){
				$("audio:not(.carregado)").each(function(){
					if (this.readyState == 4 || this.networkState == 3) {
						$(this).addClass("carregado");
					}
				});
				var carregados = $("audio.carregado").length;
				var modal_carregamento = $("#modal-carregamento");
				var percentual = Math.round(carregados * 100 / modal_carregamento.data("total"));

				modal_carregamento.data("carregados", carregados);
				modal_carregamento.find("#barra-carregamento .progress-bar")
					.attr("aria-valuenow", percentual)
					.css("width", percentual + "%")
					.html(percentual + "%");

				if (carregados == modal_carregamento.data("total")) {
					window.setTimeout(
						function(){
							$("#modal-carregamento").modal("hide");
						},
						500
					);
					window.clearInterval(modal_carregamento.data("timer"));

					$("audio#aviso-pagina-carregando").trigger("pause");
					$("audio#aviso-pagina-carregada").trigger("play");
					aplicar_comportamentos_pagina();
				} else if (!modal_carregamento.data("tocou-aviso-carregando")) {
					$("audio#aviso-pagina-carregando").trigger("play");
					modal_carregamento.data("tocou-aviso-carregando", true);
				}
			},
			500
		);
		modal_carregamento.data("timer", timer);
	} else {
		aplicar_comportamentos_pagina();
	}
}

/**
 * Aplica os comportamentos na pagina
 */
function aplicar_comportamentos_pagina() {
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
	botao_modo_exibicao.click(alternar_modo_exibicao);
	$("#area-botoes").append(botao_modo_exibicao);


	/**
	 * Evento ao clicar na imagem
	 */
	$("#imagem").click(rolar_imagem_visivel);

	/**
	 * Evento quando o mouse move
	 */
	$(window).mousemove(function(e){
		var imagem = $("#imagem");
		var conteudo_auxiliar = $("#conteudo-auxiliar");
		var limite_externo = imagem.data("limite-externo");

		// Determinar posicao do mouse em relacao a imagem
		var posicao = new Array();
		if (e.pageY < limite_externo.cima) {
			posicao.push("cima");
		} else if (e.pageY > limite_externo.baixo) {
			posicao.push("baixo");
		}
		if (e.pageX < limite_externo.esquerda) {
			posicao.push("esquerda");
		} else if (e.pageX > limite_externo.direita) {
			posicao.push("direita");
		}

		// Esta dentro da imagem
		if (posicao.length == 0) {
			var limite_interno = imagem.data("limite-interno");

			// Determinar posicao interna
			if (e.pageY < limite_interno.cima) {
				posicao.push("cima");
			} else if (e.pageY > limite_interno.baixo) {
				posicao.push("baixo");
			} else {
				posicao.push("centro");
			}
			if (e.pageX < limite_interno.esquerda) {
				posicao.push("esquerda");
			} else if (e.pageX > limite_interno.direita) {
				posicao.push("direita");
			} else {
				posicao.push("centro");
			}

			imagem.data("mouse-sobre-imagem", true);

			conteudo_auxiliar.find(".audio-regiao-interna.ativa, .audio-regiao-externa.ativa").removeClass("ativa");
			conteudo_auxiliar.find("#audio-regiao-interna-" + posicao.join("-")).addClass("ativa");

			if (imagem.data("sintetizador").length > 0) {
				conteudo_auxiliar.find(".audio-regiao-externa")
					.trigger("pause")
					.prop("currentTime", 0)
					.removeClass("ativa");
				conteudo_auxiliar.find("#audio-bip-externo").trigger("pause");

				// Se esta em alguma regiao mapeada
				var area_ativa = $("#mapa-regioes area.ativa");
				if (area_ativa.length > 0) {
					area_ativa.trigger("mouseenter");
				}
			}

		// Esta fora da imagem
		} else {
			imagem.data("mouse-sobre-imagem", false);

			if (imagem.data("sintetizador").length > 0) {
				var conteudo_auxiliar = $("#conteudo-auxiliar");

				conteudo_auxiliar.find(".audio-regiao-interna.ativa").removeClass("ativa");

				var regiao_externa_ativa = conteudo_auxiliar.find(".audio-regiao-externa.ativa");
				var regiao_externa_nova = conteudo_auxiliar.find("#audio-regiao-externa-" + posicao.join("-"));

				// Se mudou de regiao externa: tocar a nova regiao externa
				if (
					regiao_externa_nova.attr("id") != regiao_externa_ativa.attr("id")
					||
					(
						conteudo_auxiliar.find("#audio-bip-externo")[0].paused
						&& regiao_externa_nova[0].paused
					)
				) {
					conteudo_auxiliar.find(".audio-bip").trigger("pause");
					regiao_externa_ativa
						.removeClass("ativa")
						.trigger("pause")
						.prop("currentTime", 0);
					regiao_externa_nova
						.addClass("ativa")
						.trigger("play");
				}
			}
		}
	});

	// Para cada area do mapa
	$("#mapa-regioes area").each(function(){

		// Associar aos dados da regiao coorespondente
		if ($(this).hasClass("area-imagem")) {
			var regiao = $("#regioes #regiao-" + $(this).data("id-imagem-regiao"));
			$(this).data("dados-regiao", regiao);
			regiao.data("dados-area", $(this));
		}

		/**
		 * Evento quando o mouse entrar em uma regiao
		 */
		$(this).mouseenter(function(){
			var area = $(this);

			area.addClass("ativa");

			// Se eh uma area mapeada
			if ($(this).hasClass("area-imagem")) {
				var imagem        = $("#imagem");
				var regioes       = $("#regioes");
				var regiao        = area.data("dados-regiao");
				var regiao_falada = regioes.find(".regiao.falada");
				var lista_regioes = regioes.find(".panel-body");

				$("#conteudo-descricao-imagem.in").collapse("hide");
				$("#conteudo-regioes").collapse("show");
				$("#conteudo-teclas.in").collapse("hide");

				regiao.addClass("ativa");
				lista_regioes.scrollTop(regiao.offset().top - lista_regioes.find(".regiao:first-child").offset().top);
				if (regiao_falada.attr("id") != regiao.attr("id")) {
					regiao_falada.removeClass("falada");
				}

				if (imagem.data("sintetizador").length > 0) {
					if (regiao.hasClass("falada")) {
						$("#conteudo-auxiliar #audio-bip-interno").trigger("play");
					} else {
						regiao.find(".audio-nome").trigger("play");
					}
				}
			} else {
				switch (area.attr("id")) {
				case "area-borda-imagem":
					if ($("#imagem").data("sintetizador").length > 0) {
						$("#conteudo-auxiliar #audio-bip-borda").trigger("play");
					}
					break;
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

			$(this).removeClass("ativa");
			regiao_ativa.removeClass("ativa");

			if (imagem.data("sintetizador").length > 0) {
				regiao_ativa.find("audio").trigger("pause").prop("currentTime", 0);
				$("#conteudo-auxiliar .audio-bip").trigger("pause");
			}
		});

		/**
		 * Evento ao clicar sobre uma regiao
		 */
		$(this).click(function(e){
			e.preventDefault();

			var area   = $(this);
			var imagem = $("#imagem");
			var regiao = area.data("dados-regiao");

			if (imagem.data("sintetizador").length > 0) {
				$("#conteudo-auxiliar .audio-bip").trigger("pause");
				regiao.find(".audio-nome").trigger("play");
			}
		});
	});

	/**
	 * Evento quando o audio de uma descricao curta ou longa termina
	 */
	$("#regioes .regiao .audio-nome, #regioes .regiao .audio-descricao").on("ended", function(){
		var audio        = $(this);
		var bip          = $("#conteudo-auxiliar #audio-bip-interno");
		var regiao_ativa = $("#regioes .regiao.ativa");

		audio.prop("currentTime", 0);
		if (regiao_ativa.length > 0) {
			regiao_ativa.addClass("falada");
			bip.trigger("play");
		}
	});

	/**
	 * Evento quando o audio de uma descricao de regiao externa termina
	 */
	$("#conteudo-auxiliar .audio-regiao-externa").on("ended", function(){
		var audio = $(this);
		var bip   = $("#conteudo-auxiliar #audio-bip-externo");

		audio.prop("currentTime", 0);
		if (!$("#imagem").data("mouse-sobre-imagem")) {
			bip.trigger("play");
		}
	});

	/**
	 * Evento ao pausar o bip
	 */
	$("#conteudo-auxiliar .audio-bip").on("pause", function(){
		$(this).prop("currentTime", 0);
	});

	/**
	 * Eventos relacionados ao teclado
	 */
	$(document).keypress(function(e){

		if (e.ctrlKey || e.altKey || e.shiftKey) {
			return;
		}

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
		case teclas.falar_nome_regiao:
			var imagem       = $("#imagem");
			var regioes      = $("#regioes");
			var regiao_ativa = regioes.find(".regiao.ativa")

			if (imagem.data("sintetizador").length > 0 && regiao_ativa.length > 0) {
				regiao_ativa.find("audio").trigger("pause").prop("currentTime", 0);
				$("#conteudo-auxiliar .audio-bip").trigger("pause");

				if (regiao_ativa.length > 0) {
					regiao_ativa.find(".audio-nome").trigger("play");
				}
			}
			e.preventDefault();
			break;
		case teclas.falar_descricao_regiao:
			var imagem       = $("#imagem");
			var regioes      = $("#regioes");
			var regiao_ativa = regioes.find(".regiao.ativa")

			if (imagem.data("sintetizador").length > 0 && regiao_ativa.length > 0) {
				regiao_ativa.find("audio").trigger("pause").prop("currentTime", 0);
				$("#conteudo-auxiliar .audio-bip").trigger("pause");

				if (regiao_ativa.length > 0) {
					regiao_ativa.find(".audio-descricao").trigger("play");
				}
			}
			e.preventDefault();
			break;
		case teclas.falar_posicao:
			if ($("#imagem").data("sintetizador").length > 0) {
				$("#conteudo-auxiliar .audio-bip").trigger("pause");
				$("#conteudo-auxiliar .audio-regiao-externa.ativa, .audio-regiao-interna.ativa").trigger("play");
			}
			e.preventDefault();
			break;
		case teclas.alternar_modo_exibicao:
			$("#botao-alternar-modo-exibicao").click();
			e.preventDefault();
			break;
		case teclas.falar_ajuda:
			if ($("#imagem").data("sintetizador").length > 0) {
				$("#conteudo-auxiliar .audio-bip").trigger("pause");
				$("#conteudo-auxiliar #audio-ajuda").trigger("play");
			}
			e.preventDefault();
			break;
		case teclas.falar_nome_imagem:
			if ($("#imagem").data("sintetizador").length > 0) {
				$("#conteudo-auxiliar .audio-bip").trigger("pause");
				$("#conteudo-auxiliar #audio-nome-imagem").trigger("play");
			}
			e.preventDefault();
			break;
		case teclas.falar_descricao_imagem:
			if ($("#imagem").data("sintetizador").length > 0) {
				$("#conteudo-auxiliar .audio-bip").trigger("pause");
				$("#conteudo-auxiliar #audio-descricao-imagem").trigger("play");
			}
			e.preventDefault();
			break;
		case teclas.parar_bip:
			$("#conteudo-auxiliar .audio-bip").trigger("pause");
			e.preventDefault();
			break;
		}
	});
}

/**
 * Alterna entre os modos de exibicao vidente e cego
 */
function alternar_modo_exibicao() {
	var imagem = $("#imagem");

	// Parar audio auxiliar
	if (imagem.data("sintetizador").length > 0) {
		$("#conteudo-auxiliar audio")
			.trigger("pause")
			.prop("currentTime", 0);
	}

	// Desmarcar regioes ativas
	$("#mapa-regioes area.ativa").removeClass("ativa");
	$("#regioes .regiao.ativa").removeClass("ativa");
	$("#conteudo-auxiliar").find(".audio-regiao-externa.ativa, .audio-regiao-interna.ativa").removeClass("ativa");

	// Tocar o nome do modo ativo
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

	// Alterar estilos
	$("head #modo-corrente").remove();
	var modo = imagem.data("modo-exibicao");
	var style = $('<link id="modo-corrente" rel="stylesheet" href="' + $("#estilo-modo-" + modo).attr("href") + '" />');
	$("head").append(style);
	style.load(ajustar_modo_exibicao);
}

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
	var imagem = $("#imagem");
	var modo = imagem.data("modo-exibicao");
	var altura_navbar = $("#navbar-pagina").height();
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

	// Determinar limites da imagem
	var limite_externo = {
		"cima": imagem.offset().top,
		"baixo": imagem.offset().top + imagem.height(),
		"esquerda": imagem.offset().left,
		"direita": imagem.offset().left + imagem.width()
	};
	imagem.data("limite-externo", limite_externo);

	var terco_altura = imagem.height() / 3;
	var terco_largura = imagem.width() / 3;

	var limite_interno = {
		"cima": imagem.offset().top + terco_altura,
		"baixo": imagem.offset().top + terco_altura + terco_altura,
		"esquerda": imagem.offset().left + terco_largura,
		"direita": imagem.offset().left + terco_largura + terco_largura
	};
	imagem.data("limite-interno", limite_interno);
}

/**
 * Rola o scroll da pagina para tornar a imagem visivel na tela
 */
function rolar_imagem_visivel() {
	$("html, body").animate({"scrollTop": $("#imagem").offset().top - $("#navbar-pagina").height() - 1}, 1000);
}