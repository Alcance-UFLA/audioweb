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
			var area        = $(this);
			var imagem      = $("#imagem");
			var audio_ativo = $("#regioes audio.ativo");
			var bip         = $("#conteudo-auxiliar #audio-bip");
			var regiao      = area.data("dados-regiao");
			var audio       = regiao.find(".audio-nome");

			$("#regioes .regiao.ativa").removeClass("ativa");
			regiao.addClass("ativa");

			if (imagem.data("sintetizador").length > 0) {

				// Parar o audio ativo
				audio_ativo.trigger("pause").prop("currentTime", 0);

				// Parar o bip
				bip.trigger("pause");

				// Tocar o audio da regiao ou o bip
				if (audio_ativo.attr("id") != audio.attr("id")) {
					audio_ativo.removeClass("ativo");
					audio.addClass("ativo").trigger("play");
				} else {
					bip.trigger("play");
				}
			}
		});

		/**
		 * Evento quando o mouse sair de uma regiao
		 */
		$(this).mouseleave(function(){
			var imagem = $("#imagem");
			var regiao = $("#regioes .regiao.ativa");

			regiao.removeClass("ativa");

			if (imagem.data("sintetizador").length > 0) {

				// Parar o audio ativo
				$("#regioes audio.ativo").trigger("pause").prop("currentTime", 0);

				// Parar o bip
				$("#conteudo-auxiliar #audio-bip").trigger("pause");
			}
		});
	});

	/**
	 * Evento quando o audio de uma descricao curta e longa termina
	 */
	$("#regioes audio.audio-nome, #regioes audio.audio-descricao").on("ended", function(){
		var audio = $(this);
		var bip = $("#conteudo-auxiliar #audio-bip");
		var regiao_ativa = $("#regioes .regiao.ativa");

		audio.prop("currentTime", 0);
		if (regiao_ativa.length > 0) {
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
			var regiao_ativa = $("#regioes .regiao.ativa")
			var audio_ativo  = $("#regioes audio.ativo");
			var bip          = $("#conteudo-auxiliar #audio-bip");

			if (imagem.data("sintetizador").length > 0) {

				// Parar o audio ativo
				audio_ativo.trigger("pause").prop("currentTime", 0);

				// Parar o bip
				bip.trigger("pause");

				if (regiao_ativa.length > 0) {
					regiao_ativa.find(".audio-nome").trigger("play");
				}
			}
			break;

		// tecla d (descricao)
		case 100:
			var imagem       = $("#imagem");
			var regiao_ativa = $("#regioes .regiao.ativa")
			var audio_ativo  = $("#regioes audio.ativo");
			var bip          = $("#conteudo-auxiliar #audio-bip");

			if (imagem.data("sintetizador").length > 0) {

				// Parar o audio ativo
				audio_ativo.trigger("pause").prop("currentTime", 0);

				// Parar o bip
				bip.trigger("pause");

				if (regiao_ativa.length > 0) {
					regiao_ativa.find(".audio-descricao").trigger("play");
				}
			}
			break;
		}
	});
});