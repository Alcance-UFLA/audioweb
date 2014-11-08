$(document).ready(function(){
	$("#mapa-regioes").data("id-audio-ativo", false);

	// Para cada area do mapa
	$("#mapa-regioes area").each(function(){

		/**
		 * Evento quando o mouse entrar em uma regiao
		 */
		$(this).mouseenter(function(){
			var area = $(this);
			var mapa = $("#mapa-regioes");
			if (mapa.data("id-audio-ativo")) {
				var audio_ativo = $("#regioes #" + mapa.data("id-audio-ativo"))[0];
				if (audio_ativo.pause) {
					audio_ativo.pause();
					audio_ativo.currentTime = 0;
				}
				mapa.data("id-audio-ativo", false);
			}
			var audio = $("#regioes #audio-" + area.data("id-imagem-regiao") + "-nome")[0];
			if (audio.play && audio.canPlayType("audio/mpeg")) {
				mapa.data("id-audio-ativo", audio.id);
				audio.play();
			}
		});

		/**
		 * Evento quando o mouse sair de uma regiao
		 */
		$(this).mouseleave(function(){
			var mapa = $("#mapa-regioes");
			if (mapa.data("id-audio-ativo")) {
				var audio_ativo = $("#regioes #" + mapa.data("id-audio-ativo"))[0];
				if (audio_ativo.pause) {
					audio_ativo.pause();
					audio_ativo.currentTime = 0;
				}
				mapa.data("id-audio-ativo", false);
			}
		});
	});

});