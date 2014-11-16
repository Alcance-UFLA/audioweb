$(document).ready(function(){

	/**
	 * Ajusta as coordenadas de cada regiao de acordo com o redimensionamento da imagem
	 */
	var ajustar_proporcao_mapa = function(){
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
	};

	ajustar_proporcao_mapa();

	/**
	 * Evento quando a janela muda de tamanho
	 */
	$(window).resize(ajustar_proporcao_mapa);

	/**
	 * Evento quanto o mouse sai da imagem
	 */
	$("#imagem").mouseleave(function(){
		// TODO
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
		switch (e.which) {

		// tecla c (curta)
		case 99:
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

		// tecla d (descricao)
		case 100:
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
		}
	});
});