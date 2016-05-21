$(document).ready(function(){

var AudioImagem = {

	/// Referencia para elementos muito utilizados
	"audios":            $("audio"),
	"audio_auxiliar":    $("#conteudo-auxiliar audio"),
	"imagem":            $("#imagem"),
	"regioes":           $("#regioes"),
	"conteudo_auxiliar": $("#conteudo-auxiliar"),
	"mapa_regioes":      $("#mapa-regioes"),
	"teclas":            $("#teclas"),

	"audio_bip":                     $("#conteudo-auxiliar .audio-bip"),
	"audio_bip_interno":             $("#conteudo-auxiliar #audio-bip-interno"),
	"audio_bip_borda":               $("#conteudo-auxiliar #audio-bip-borda"),
	"audio_ajuda":                   $("#conteudo-auxiliar #audio-ajuda"),
	"audio_regiao_externa":          $("#conteudo-auxiliar .audio-regiao-externa"),
	"audio_nome_imagem":             $("#conteudo-auxiliar #audio-nome-imagem"),
	"audio_descricao_imagem":        $("#conteudo-auxiliar #audio-descricao-imagem"),
	"audio_modo_cego":               $("#conteudo-auxiliar #audio-modo-cego"),
	"audio_modo_vidente":            $("#conteudo-auxiliar #audio-modo-vidente"),
	"audio_aviso_pagina_carregando": $("#conteudo-auxiliar #aviso-pagina-carregando"),
	"audio_aviso_pagina_carregada":  $("#conteudo-auxiliar #aviso-pagina-carregada"),

	/// Metodos

	/**
	 * Carrega os recursos da pagina atualizando uma barra de progresso
	 */
	"carregar_recursos_pagina": function () {

		if (AudioImagem.audios.length == 0) {
			AudioImagem.aplicar_comportamentos_pagina();
			return;
		}
		var modal_carregamento = $('<div id="modal-carregamento" class="modal fade"><div class="modal-dialog"><div class="modal-content"><div class="modal-header"><button type="button" class="close" data-dismiss="modal" aria-label="Fechar"><span aria-hidden="true">&times;</span></button><h1 class="modal-title h4">Carregando</h1></div><div class="modal-body"><div id="barra-carregamento" class="progress"><div class="progress-bar" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%;" aria-live="polite">0%</div></div></div></div></div></div>');
		modal_carregamento.data("total", AudioImagem.audios.length);
		modal_carregamento.data("carregados", 0);
		modal_carregamento.data("tocou-aviso-carregando", false);
		$("body").append(modal_carregamento);
		modal_carregamento.modal("show");

		var timer = window.setInterval(function(){
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

            console.log("Carregou: " + carregados + " sons de " + modal_carregamento.data("total"));
			if (carregados == modal_carregamento.data("total")) {
				window.setTimeout(
					function(){
						$("#modal-carregamento").modal("hide");
					},
					500
				);
				window.clearInterval(modal_carregamento.data("timer"));

				AudioImagem.aplicar_comportamentos_pagina();

				AudioImagem.pausar(AudioImagem.audio_aviso_pagina_carregando);
				AudioImagem.tocar(AudioImagem.audio_aviso_pagina_carregada);
			} else if (!modal_carregamento.data("tocou-aviso-carregando")) {
				AudioImagem.tocar(AudioImagem.audio_aviso_pagina_carregando);
				modal_carregamento.data("tocou-aviso-carregando", true);
			}
		}, 500);
		modal_carregamento.data("timer", timer);
	},

	/**
	 * Aplica os comportamentos na pagina
	 */
	"aplicar_comportamentos_pagina": function () {
		AudioImagem.ajustar_modo_exibicao();
		AudioImagem.ajustar_proporcao_mapa();

		// Evento quando a janela muda de tamanho
		$(window).resize(AudioImagem.ajustar_modo_exibicao);

		// Botao de alternar modo de exibicao
		var botao_modo_exibicao = $('<button type="button" id="botao-alternar-modo-exibicao" class="btn btn-lg btn-default"><i class="glyphicon glyphicon-fullscreen"></i> Alternar modo de exibição</button>');
		botao_modo_exibicao.click(AudioImagem.alternar_modo_exibicao);
		$("#area-botoes").append(botao_modo_exibicao);

		// Evento ao clicar na imagem
		AudioImagem.imagem.click(AudioImagem.rolar_imagem_visivel);

		// Evento quando o mouse move
		$(window).mousemove(AudioImagem.evento_mouse_moveu);

		// Para cada area do mapa
		AudioImagem.mapa_regioes.find("area").each(function(){

			// Associar aos dados da regiao coorespondente
			if ($(this).hasClass("area-imagem")) {
				var regiao = AudioImagem.regioes.find("#regiao-" + $(this).data("id-imagem-regiao"));
				$(this).data("dados-regiao", regiao);
				regiao.data("dados-area", $(this));
			}

			// Evento quando o mouse entrar em uma regiao
			$(this).mouseenter(AudioImagem.evento_mouse_entrou_regiao);

			// Evento quando o mouse sair de uma regiao
			$(this).mouseleave(AudioImagem.evento_mouse_saiu_regiao);

			// Evento ao clicar sobre uma regiao uma ou duas vezes
			$(this).single_double_click(
				AudioImagem.evento_clicou_regiao,
				AudioImagem.evento_clicou_duplo_regiao,
				{
					"prevent": true,
					"timeout": 500
				}
			);

		});

		// Evento quando o audio de uma descricao curta ou longa termina
		AudioImagem.regioes.find(".regiao .audio-nome, .regiao .audio-descricao").on("ended", AudioImagem.evento_terminou_descricao);

		// Evento quando o audio de uma descricao de regiao externa termina
		AudioImagem.audio_regiao_externa.on("ended", AudioImagem.evento_terminou_regiao_externa);

		// Eventos relacionados ao teclado
		$(document).keydown(AudioImagem.evento_pressionou_tecla);
	},

	/**
	 * Alterna entre os modos de exibicao vidente e cego
	 */
	"alternar_modo_exibicao": function () {

		// Parar audio auxiliar
		AudioImagem.pausar(AudioImagem.audio_auxiliar);

		// Desmarcar regioes ativas
		AudioImagem.mapa_regioes.find("area.ativa").removeClass("ativa");
		AudioImagem.regioes.find(".regiao.ativa").removeClass("ativa");
		AudioImagem.conteudo_auxiliar.find(".audio-regiao-externa.ativa, .audio-regiao-interna.ativa").removeClass("ativa");

		// Tocar o nome do modo ativo
		if (AudioImagem.imagem.data("modo-exibicao") == "vidente") {
			AudioImagem.imagem.data("modo-exibicao", "cego");
			AudioImagem.tocar(AudioImagem.audio_modo_cego);
		} else {
			AudioImagem.imagem.data("modo-exibicao", "vidente");
			AudioImagem.tocar(AudioImagem.audio_modo_vidente);
		}

		// Alterar estilos
		$("head #modo-corrente").remove();
		var modo = AudioImagem.imagem.data("modo-exibicao");
		var style = $('<link id="modo-corrente" rel="stylesheet" href="' + $("#estilo-modo-" + modo).attr("href") + '" />');
		$("head").append(style);
		style.load(AudioImagem.ajustar_modo_exibicao);
	},

	/**
	 * Ajusta as coordenadas de cada regiao de acordo com o redimensionamento da imagem
	 */
	"ajustar_proporcao_mapa": function () {
		var proporcao = AudioImagem.imagem.width() / AudioImagem.imagem.data("largura-original");
		if (AudioImagem.mapa_regioes.data("proporcao") != proporcao) {
			AudioImagem.mapa_regioes.data("proporcao", proporcao);
			AudioImagem.mapa_regioes.find("area").each(function(){
				var proporcao = AudioImagem.mapa_regioes.data("proporcao");
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
	},

	/**
	 * Ajusta o modo de exibicao para vidente ou cego
	 */
	"ajustar_modo_exibicao": function () {
		var modo = AudioImagem.imagem.data("modo-exibicao");
		var altura_navbar = $("#navbar-pagina").height();
		var altura = $(window).height() - altura_navbar;
		var largura = AudioImagem.imagem.data("largura-original") * altura / AudioImagem.imagem.data("altura-original");
		var margem = 1;

		if (largura > AudioImagem.imagem.offsetParent().width()) {
			largura = AudioImagem.imagem.offsetParent().width();
			altura = AudioImagem.imagem.data("altura-original") * largura / AudioImagem.imagem.data("largura-original");
			if (AudioImagem.imagem.data("modo-exibicao") == "cego") {
				margem = ($(window).height() - altura) / 2;
			}
		}

		altura = Math.round(altura) - 4;
		largura = Math.round(largura) - 4;

		AudioImagem.imagem.css({
			"height": altura + "px",
			"width": largura + "px",
			"margin-top": margem + "px",
			"margin-bottom": margem + "px"
		});
		AudioImagem.ajustar_proporcao_mapa();

		// Determinar limites da imagem
		var limite_externo = {
			"cima": AudioImagem.imagem.offset().top,
			"baixo": AudioImagem.imagem.offset().top + AudioImagem.imagem.height(),
			"esquerda": AudioImagem.imagem.offset().left,
			"direita": AudioImagem.imagem.offset().left + AudioImagem.imagem.width()
		};
		AudioImagem.imagem.data("limite-externo", limite_externo);

		var terco_altura = AudioImagem.imagem.height() / 3;
		var terco_largura = AudioImagem.imagem.width() / 3;

		var limite_interno = {
			"cima": AudioImagem.imagem.offset().top + terco_altura,
			"baixo": AudioImagem.imagem.offset().top + terco_altura + terco_altura,
			"esquerda": AudioImagem.imagem.offset().left + terco_largura,
			"direita": AudioImagem.imagem.offset().left + terco_largura + terco_largura
		};
		AudioImagem.imagem.data("limite-interno", limite_interno);
	},

	/**
	 * Rola o scroll da pagina para tornar a imagem visivel na tela
	 */
	"rolar_imagem_visivel": function () {
		$("html, body").animate({"scrollTop": AudioImagem.imagem.offset().top - $("#navbar-pagina").height() - 1}, 1000);
	},

	/**
	 * Funcao para tocar um som
	 * @param audio obj
	 */
	"tocar": function (obj) {
		if (AudioImagem.imagem.data("sintetizador").length == 0) {
			return;
		}
		obj.each(function() {
			if (this.paused) {
				$(this).trigger("play");
				console.log("play: " + $(this).attr("id"));
			}
		});
	},

	/**
	 * Funcao para pausar um som
	 * @param audio obj
	 */
	"pausar": function (obj) {
		if (AudioImagem.imagem.data("sintetizador").length == 0) {
			return;
		}
		obj.each(function() {
			if (!this.paused) {
				$(this).trigger("pause").prop("currentTime", 0);
				console.log("pause: " + $(this).attr("id"));
			}
		});
	},

	/// Eventos

	"evento_mouse_moveu": function (e) {
		var limite_externo = AudioImagem.imagem.data("limite-externo");

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
			var limite_interno = AudioImagem.imagem.data("limite-interno");

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

			AudioImagem.imagem.data("mouse-sobre-imagem", true);

			AudioImagem.conteudo_auxiliar.find(".audio-regiao-interna.ativa, .audio-regiao-externa.ativa").removeClass("ativa");
			AudioImagem.conteudo_auxiliar.find("#audio-regiao-interna-" + posicao.join("-")).addClass("ativa");

			AudioImagem.pausar(AudioImagem.conteudo_auxiliar.find(".audio-regiao-externa"), true);
			AudioImagem.audio_regiao_externa.removeClass("ativa");

			// Se esta em alguma regiao mapeada
			var area_ativa = AudioImagem.mapa_regioes.find("area.ativa");
			if (area_ativa.length > 0) {
				area_ativa.trigger("mouseenter");
			}

		// Esta fora da imagem
		} else {
			AudioImagem.imagem.data("mouse-sobre-imagem", false);
			AudioImagem.conteudo_auxiliar.find(".audio-regiao-interna.ativa").removeClass("ativa");

			var regiao_externa_ativa = AudioImagem.conteudo_auxiliar.find(".audio-regiao-externa.ativa");
			var regiao_externa_nova = AudioImagem.conteudo_auxiliar.find("#audio-regiao-externa-" + posicao.join("-"));

			// Se mudou de regiao externa: tocar a nova regiao externa
			if (regiao_externa_nova.attr("id") != regiao_externa_ativa.attr("id")) {
				AudioImagem.pausar(AudioImagem.audio_bip);
				AudioImagem.pausar(regiao_externa_ativa, true);
				regiao_externa_ativa.removeClass("ativa")
				AudioImagem.tocar(regiao_externa_nova);
				regiao_externa_nova.addClass("ativa");
			}
		}
	},

	"evento_mouse_entrou_regiao": function () {
		var area = $(this);

		area.addClass("ativa");

		// Se eh uma area mapeada
		if ($(this).hasClass("area-imagem")) {
			var regiao        = area.data("dados-regiao");
			var regiao_falada = AudioImagem.regioes.find(".regiao.falada");
			var lista_regioes = AudioImagem.regioes.find(".panel-body");

			$("#conteudo-descricao-imagem.in").collapse("hide");
			$("#conteudo-regioes").collapse("show");
			$("#conteudo-teclas.in").collapse("hide");

			regiao.addClass("ativa");
			lista_regioes.scrollTop(regiao.offset().top - lista_regioes.find(".regiao:first-child").offset().top);
			if (regiao_falada.attr("id") != regiao.attr("id")) {
				regiao_falada.removeClass("falada");
			}

			if (regiao.hasClass("falada")) {
				AudioImagem.tocar(AudioImagem.audio_bip_interno);
			} else {
				AudioImagem.tocar(regiao.find(".audio-nome"));
			}
		} else {
			switch (area.attr("id")) {
			case "area-borda-imagem":
				AudioImagem.tocar(AudioImagem.audio_bip_borda);
				break;
			}
		}
	},

	"evento_mouse_saiu_regiao": function () {
		var regiao_ativa = AudioImagem.regioes.find(".regiao.ativa");

		$(this).removeClass("ativa");
		regiao_ativa.removeClass("ativa");

		AudioImagem.pausar(regiao_ativa.find("audio"));
		AudioImagem.pausar(AudioImagem.audio_bip);
	},

	"evento_clicou_regiao": function () {
		var area = $(this);
		var regiao = area.data("dados-regiao");
		AudioImagem.pausar(AudioImagem.audio_bip);
		AudioImagem.tocar(regiao.find(".audio-nome"));
	},

	"evento_clicou_duplo_regiao": function () {
		var area = $(this);
		var regiao = area.data("dados-regiao");
		AudioImagem.pausar(AudioImagem.audio_bip);
		AudioImagem.tocar(regiao.find(".audio-descricao"));
	},

	"evento_terminou_descricao": function () {
		var audio        = $(this);
		var regiao_ativa = AudioImagem.regioes.find(".regiao.ativa");

		audio.prop("currentTime", 0);
		if (regiao_ativa.length > 0) {
			regiao_ativa.addClass("falada");
			AudioImagem.tocar(AudioImagem.audio_bip_interno);
		}
	},

	"evento_terminou_regiao_externa": function () {
		$(this).prop("currentTime", 0);
	},

	"evento_pressionou_tecla": function (e) {

		/*
		 * Montar objeto para facilitar acesso as teclas de atalho, conforme exemplo:
		 * {
		 *     "falar_nome_imagem": {"codigo": 99, "alt": false},
		 *     "falar_descricao_imagem": {"codigo': 108, "alt": false},
		 *     "falar_nome_regiao": {"codigo": 99, "alt": true},
		 *     "falar_descricao_regiao": {"codigo': 108, "alt": true}
		 * }
		 */
		var teclas = AudioImagem.teclas.data("teclas");
		if (!teclas) {
			var lista_teclas = AudioImagem.teclas.find(".tecla");
			teclas = new Object();
			for (var i = 0; i < lista_teclas.length; i++) {
				var tecla = lista_teclas[i];
				teclas[$(tecla).data("nome")] = $(tecla).data("codigo") + "-" + ($(tecla).data("alt") == "1" ? "1" : "0") + "-" + ($(tecla).data("ctrl") == "1" ? "1" : "0") + "-" + ($(tecla).data("shift") == "1" ? "1" : "0");
			}
			AudioImagem.teclas.data("teclas", teclas);
		}

		var acao = e.which + "-" + (e.altKey ? "1" : "0") + "-" + (e.ctrlKey ? "1" : "0") + "-" + (e.shiftKey ? "1" : "0");

		switch (acao) {
		case teclas.falar_nome_regiao:
			var regiao_ativa = AudioImagem.regioes.find(".regiao.ativa")

			if (regiao_ativa.length > 0) {
				AudioImagem.pausar(regiao_ativa.find("audio"));
				AudioImagem.pausar(AudioImagem.audio_bip);
				AudioImagem.tocar(regiao_ativa.find(".audio-nome"));
			}
			e.preventDefault();
			break;
		case teclas.falar_descricao_regiao:
			var regiao_ativa = AudioImagem.regioes.find(".regiao.ativa")

			if (regiao_ativa.length > 0) {
				AudioImagem.pausar(regiao_ativa.find("audio"));
				AudioImagem.pausar(AudioImagem.audio_bip);
				AudioImagem.tocar(regiao_ativa.find(".audio-descricao"));
			}
			e.preventDefault();
			break;
		case teclas.falar_posicao:
			AudioImagem.pausar(AudioImagem.audio_bip);
			AudioImagem.tocar(AudioImagem.conteudo_auxiliar.find(".audio-regiao-externa.ativa, .audio-regiao-interna.ativa"));
			e.preventDefault();
			break;
		case teclas.alternar_modo_exibicao:
			$("#botao-alternar-modo-exibicao").click();
			e.preventDefault();
			break;
		case teclas.falar_ajuda:
			AudioImagem.pausar(AudioImagem.audio_bip);
			AudioImagem.tocar(AudioImagem.audio_ajuda);
			e.preventDefault();
			break;
		case teclas.falar_nome_imagem:
			AudioImagem.pausar(AudioImagem.audio_bip);
			AudioImagem.tocar(AudioImagem.audio_nome_imagem);
			e.preventDefault();
			break;
		case teclas.falar_descricao_imagem:
			AudioImagem.pausar(AudioImagem.audio_bip);
			AudioImagem.tocar(AudioImagem.audio_descricao_imagem);
			e.preventDefault();
			break;
		case teclas.parar_bip:
			AudioImagem.pausar(AudioImagem.audio_bip);
			e.preventDefault();
			break;
		}
	}
};

AudioImagem.carregar_recursos_pagina();
});
