$(document).ready(function(){

	/**
	 * Evento quanto o mouse sai da imagem
	 */
	$("#imagem").mouseleave(function(){
		// TODO
	});

	// Para cada area do mapa
	$("#mapa-regioes area").each(function(){

		/**
		 * Evento quando o mouse entrar em uma regiao
		 */
		$(this).mouseenter(function(){
			var area = $(this);
			var mapa = $("#mapa-regioes");

			// Parar o audio ativo
			var audio_ativo = $("audio.ativo");
			audio_ativo.trigger("pause").prop("currentTime", 0);

			// Parar o bip
			$("#audio-bip")
				.prop("loop", false)
				.prop("muted", false)
				.trigger("pause")
				.prop("currentTime", 0);

			// Tocar o audio da regiao ou o bip
			var audio = $("#regioes #audio-" + area.data("id-imagem-regiao") + "-nome");
			if (audio_ativo.attr("id") != audio.attr("id")) {
				audio_ativo.removeClass("ativo");
				audio
					.addClass("ativo")
					.trigger("play");
			} else {
				$("#audio-bip")
					.prop("loop", true)
					.trigger("play");
			}
		});

		/**
		 * Evento quando o mouse sair de uma regiao
		 */
		$(this).mouseleave(function(){

			// Parar o audio ativo
			$("audio.ativo")
				.trigger("pause")
				.prop("currentTime", 0);

			// Parar o bip
			$("#audio-bip")
				.prop("loop", false)
				.prop("muted", true)
				.trigger("pause")
				.prop("currentTime", 0);
		});
	});

	// Para cada audio de descricao curta
	$("#regioes audio.audio-nome").each(function(){

		/**
		 * Evento quando o audio de uma descricao curta termina
		 */
		$(this).on("ended", function(){
			if (!$("#audio-bip").prop("muted")) {
				$("#audio-bip")
					.prop("loop", true)
					.trigger("play");
			}
		});
	});

});