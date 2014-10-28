$(document).ready(function(){
	$("body").data("id-audio-ativo", false);

	/**
	 * Evento ao entrar o mouse em uma regiao
	 */
	$("#mapa area").mouseenter(function(){
		if ($("body").data("id-audio-ativo")) {
			var audio_ativo = $("#audios #" + $("body").data("id-audio-ativo"))[0];
			if (audio_ativo.pause) {
				audio_ativo.pause();
				audio_ativo.currentTime = 0;
			}
			$("body").data("id-audio-ativo", false);
		}
		var audio = $("#audios #audio-" + $(this).data("id-imagem-regiao") + "-nome")[0];
		if (audio.play && audio.canPlayType("audio/mpeg")) {
			audio.play();
			$("body").data("id-audio-ativo", audio.id);
		}
	});
});