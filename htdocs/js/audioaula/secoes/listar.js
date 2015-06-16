$(document).ready(function(){

	// Tornar a lista de secoes ordenavel
	$("#lista-secoes").each(function(){

		if ($(this).find(".secao").length <= 1) {
			return;
		}

		$(this).find(".nome-secao").each(function(){
			var icone = $('<i class="glyphicon glyphicon-sort text-danger"></i>');
			icone.css("cursor", "move");
			$(this).prepend(icone);
			$(document.createTextNode(" ")).insertAfter(icone);
		});
		$(this).sortable({
			"cursor": "move",
			"handle": ".nome-secao",
			"items": "> li.secao",
			"stop": function(event, ui){

				// Detectar mudancas
				var params = {
					"mudancas": {}
				};
				var precisa_salvar = false;
				var secoes = $("#lista-secoes .secao");
				for (var i = 0; i < secoes.length; i++) {
					var secao = $(secoes[i]);
					var posicao = i + 1;
					if (secao.data("posicao") != posicao) {
						params.mudancas[secao.data("id-secao")] = posicao;
						precisa_salvar = true;
						secao.data("posicao", posicao);
					}
				}

				// Se encontrou mudancas: salvar
				if (precisa_salvar) {
					$.ajax({
						"type": "POST",
						"url": $(this).data("action-salvar-posicoes"),
						"data": params,
						"success": function(data, text_status, xhr){
							if (!data.sucesso) {
								window.alert("Estamos com problemas para salvar as novas posições das seções.");
							}
							for (var id_secao in data.secoes) {
								$("#secao" + id_secao + " .numero").text(data.secoes[id_secao]);
							}
						},
						"error": function(){
							window.alert("Estamos com problemas para salvar as novas posições das seções.");
						}
					});
				}
			}
		});
		$(this).disableSelection();
	});
});